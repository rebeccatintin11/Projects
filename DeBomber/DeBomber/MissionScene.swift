//
//  MissionScene.swift
//  DeBomber
//
//  Created by Rebecca Lin on 3/25/15.
//
import Foundation
import SpriteKit

//var onTrail = [0.0, 0.0, 0.0, 0.0, 0.0]

class MissionScene: SKScene {
    
    //Timer, controled by PlayViewCOntroller
    var time = NSTimer()
    var second = 60
    
    let floor_y = CGFloat(150)
    var moverSpeed = 5.0
    var now : NSDate?
    var nextTime : NSDate?
    var colWidth = 40
    var NTrails = 5

    
    var pause = false
    var restart = false
    var hiddenNodes:[bombNode] = []
    
    var targets:[target] = []
    var level_of_guarantee = 3


    /* Variable for mission timer */
    var mTime = NSTimer()
    var mSecond = 10
    var mTimeLabel = SKLabelNode(fontNamed:"Futura-Medium")
    var passButton = SKSpriteNode(imageNamed: "pass_button.gif")
    
    override func didMoveToView(view: SKView) {
        self.physicsBody = SKPhysicsBody(edgeLoopFromRect: self.frame)
        initializeValues()
    }
    
    /* Mission timer */
    
    func setMTimer() {
        mSecond = 10
        addMTimeLabel()
        setMtimer_s()
    }
    func setMtimer_s() {
        mTime = NSTimer.scheduledTimerWithTimeInterval(1.0, target: self, selector: Selector("updateMTime"), userInfo: nil, repeats: true)
    }
    func addPass() {
        passButton = SKSpriteNode(imageNamed: "pass_button.gif")
        passButton.position = CGPoint(x:CGRectGetMaxX(self.frame) - 30, y:15);
        passButton.name = "passButton"
        passButton.xScale = 0.3
        passButton.yScale = 0.3
        
        self.addChild(passButton)
    }
    func addPass2() {
        passButton = SKSpriteNode(imageNamed: "passButton.png")
        passButton.position = CGPoint(x:CGRectGetMaxX(self.frame)/2, y: 22);
        passButton.name = "passButton"
        passButton.xScale = 0.7
        passButton.yScale = 0.45
        
        self.addChild(passButton)
    }
    func addMTimeLabel() {
        mTimeLabel = SKLabelNode(fontNamed: "Futura-Medium")
        mTimeLabel.text = String(format: "%d", mSecond)
        mTimeLabel.fontSize = 200
        var myWhiteColor = SKColor.whiteColor().colorWithAlphaComponent(0.7)
        mTimeLabel.fontColor = myWhiteColor
        //mTimeLabel.position = CGPoint(x:10, y:10);
        mTimeLabel.position = CGPoint(x: (self.frame.width)/2, y: (self.frame.height)/2 )
        mTimeLabel.zPosition = 0
        self.addChild(mTimeLabel)
    }
    func resetMTime() {
        mSecond = 10
        mTimeLabel.text = String(format: "%d", mSecond)
    }
    func updateMTime() {
        if( mSecond == 0) {
            resetMTime()
            generateNewMission()
            
        }
        else {
            mSecond--
            mTimeLabel.text = String(format: "%d", mSecond)
        }
    }
    
    override func touchesBegan(touches: NSSet, withEvent event: UIEvent) {
        var touch: UITouch = touches.anyObject() as UITouch
        var location = touch.locationInNode(self)
        var node = self.nodeAtPoint(location)
        
        // If next button is touched, start transition to second scene
        if (node.name == "passButton") {
            resetMTime()
            mTimeLabel.text = String(format: "%d", mSecond)
            generateNewMission()
        }
    }
    
    /*
    Sets the initial values for our variables.
    */
    func initializeValues(){
        
        self.removeAllChildren()
        
        /*add background picture*/
        let background = SKSpriteNode(imageNamed: "background")
        background.anchorPoint = CGPointMake(0, 1)
        background.position = CGPointMake(0, size.height)
        background.size = CGSize(width: self.view!.bounds.size.width, height:self.view!.bounds.size.height)
        addChild(background)
        
        /* Adjust # of trails according to screen size */
        onTrail = [0.0, 0.0, 0.0, 0.0, 0.0]
        onTrail_next = [0.0, 0.0, 0.0, 0.0, 0.0]
        NTrails  = (Int(self.frame.width) - 40)/colWidth
        if (NTrails > 5) {
            var count = NTrails - 5
            for i in 0...count {
                onTrail.append(0.0) //add extra trails
                onTrail_next.append(0.0)
            }
        }
        /* End of adjust # of trails according to screen size */
        
        moverSpeed = 3.0
        nextTime = NSDate()
        now = NSDate()
        
        /* Set score display */
        scoreLabel = SKLabelNode(fontNamed:"Futura-Medium")
        scoreLabel.text = String(format: "%05d", score)
        score = 0
        scoreLabel.fontSize = 25
        scoreLabel.fontColor = SKColor.blueColor()
        scoreLabel.horizontalAlignmentMode = SKLabelHorizontalAlignmentMode.Right
        scoreLabel.position = CGPoint(x:CGRectGetMaxX(self.frame) - 4, y:(CGRectGetMaxY(self.frame) - 40));
        scoreLabel.zPosition = 3
        
        self.addChild(scoreLabel)
        /* End of set score display */
        
        /* Add the bottom line */
        var bottomLine = SKShapeNode()
        let lineToDraw = CGPathCreateMutable()
        CGPathMoveToPoint(lineToDraw, nil, CGRectGetMinX(self.frame), floor_y)
        CGPathAddLineToPoint(lineToDraw, nil, CGRectGetMaxX(self.frame), floor_y)
        bottomLine.path = lineToDraw
        bottomLine.strokeColor = SKColor.redColor()
        bottomLine.lineWidth = 4
        bottomLine.name = "bottomLine"
        self.addChild(bottomLine)
        /* End of add the bottom line */
        
        pause = false
        restart = false
        hiddenNodes.removeAll()
        
        /* Combo */
        comboRate = 1.0
        
        addPass2()
        setMTimer()
        generateMission()
    }
    
    func increaseSpeed() {
        moverSpeed = moverSpeed - (0.001*(Double(score)))
    }
    
    override func update(currentTime: CFTimeInterval) {
        
        if (!self.pause){
            
            if(self.restart)
            {
                
                for child in self.hiddenNodes{
                    child.hidden = false
                }
                self.hiddenNodes.removeAll()
                self.restart = false
                
            }
            
            self.paused = false
            
            now = NSDate()
            if (now?.timeIntervalSince1970 > nextTime?.timeIntervalSince1970) {
                
                nextTime = now?.dateByAddingTimeInterval(NSTimeInterval(0.1))
    
                for i in 0...onTrail.count-1 {
                    if (onTrail[i] > 0){
                        onTrail[i] = onTrail[i] - 0.1
                        onTrail_next[i] = onTrail_next[i] - 0.1
                    }
                    else if(onTrail[i] < 0){
                        onTrail[i] = 0
                        onTrail_next[i] = 0
                    }
                    
                }
                
                /* Generate a bomb*/
                generateBomb()

                
                /* Generate new mission*/
                if(targets[0].isMatched
                    && targets[1].isMatched
                    && targets[2].isMatched
                    && targets[3].isMatched){
                        resetMTime()
                        generateNewMission()
                }
                
            }
            
        }
        
    }
    func generateNewMission() {
        for m in targets {
            m.runAction(SKAction.hide())
        }
        targets.removeAll()
        generateMission()
    }
    func generateBomb() {
        
        let width = Int(self.frame.width) - 2*colWidth
        var newX = colWidth + ( (arc4random() % UInt32(NTrails)) * UInt32(colWidth))
        var newY = Int(self.frame.height) + 10
        var pp = CGPoint(x:Int(newX), y:newY)
        var destinationp = CGPoint(x:Int(newX), y:200) //170 -> 200
        
        // check if any mission node exist in screen. Add one if there's no any, but not guarantee
        if Int(arc4random_uniform(10))+1 <= level_of_guarantee{
            for i in 0...3 {
                var colorExist = 0
                for child in self.children{
                    if (child is bombNode){
                        let node = child as?bombNode
                        if node?.myColor == targets[i].myColor{
                            colorExist = 1
                            break
                        }
                    }
                
                }
                if colorExist == 0{
                    addItem(pp, destination: destinationp, color:targets[i].myColor)
                }
            }
        }
        
        else if Int(arc4random_uniform(10))+1 <= 2{
            for i in 0...3 {
                if !targets[i].isMatched {
                    addItem(pp, destination: destinationp, color:targets[i].myColor)
                }
            }

        }
        else{
            addItem(pp, destination: destinationp)
        }
        
        
    }

    func addItem(p:CGPoint, destination:CGPoint, color: String=""){

        
        var trailNum_temp = (Int(p.x)/colWidth)-1
        var item:bombNode!
        
        if(color == ""){
            item = bombNode()
        }else{
            item = bombNode(color: color)
        }
        
        item.xScale = 0.4
        item.yScale = 0.4
        item.position = p
        item.trailNum = trailNum_temp
        
        item.myMission = targets
        
        let duration = NSTimeInterval(moverSpeed*item.mySpeedFactor)
        let falling = SKAction.moveTo(destination, duration: duration)
        let hide = SKAction.hide()
        let durInt:Double = Double(duration)
        
        item.runAction(SKAction.sequence([falling, hide, SKAction.removeFromParent()]))
        
        /* avoid overlap from current and nearby trails */
        if (item.trailNum == 0){
            if (onTrail[item.trailNum]+1 < durInt && onTrail[item.trailNum+1]+1 < durInt){
                onTrail_next[item.trailNum] = onTrail[item.trailNum]
                onTrail[item.trailNum] = durInt
                update_trail_top(item.trailNum)
                self.addChild(item)
            }
        }
        else if (item.trailNum == onTrail.count-1){
            if (onTrail[item.trailNum]+1 < durInt && onTrail[item.trailNum-1]+1 < durInt){
                onTrail_next[item.trailNum] = onTrail[item.trailNum]
                onTrail[item.trailNum] = durInt
                update_trail_top(item.trailNum)
                self.addChild(item)
            }
        }
        else{
            if ((onTrail[item.trailNum]+1 < durInt) && (onTrail[item.trailNum+1]+1 < durInt) && (onTrail[item.trailNum-1]+1 < durInt)){
                onTrail_next[item.trailNum] = onTrail[item.trailNum]
                onTrail[item.trailNum] = durInt
                update_trail_top(item.trailNum)
                self.addChild(item)
            }
        }
        /*end of avoiding overlap*/
    }
    
    func generateMission() {
        
        let colorOptions = ["blue", "brown", "gray", "green", "orange", "pink", "red", "purple", "yellow"]
        let screenSize: CGRect = UIScreen.mainScreen().bounds
        let screenWidth = screenSize.width
        let screenHeight = screenSize.height
        var width = screenWidth/4
        
        for var index = 0; index < 4; index++ {
            
            var myColor = colorOptions[Int(arc4random_uniform(9))]      //randomly choose color
            
            var tmp = SKSpriteNode(imageNamed: myColor)
            
            tmp.xScale = 0.4
            tmp.yScale = 0.4
            var offset = tmp.size.width/2
            tmp.position = CGPointMake(CGFloat(index)*width+offset,100) //60 -> 100
            
            var rec = CGRectMake(tmp.position.x-offset-10,screenHeight-120,width+20,120)
            
            var t = target(color: myColor, r:rec)
            t.xScale = 0.4
            t.yScale = 0.4
            t.alpha = 0.3
            t.position = tmp.position
            addChild(t)
            targets.append(t)
            
        }
        
    }
    
    func update_trail_top(trailNum: Int){
        for child in self.children{
            if child is bombNode && child.trailNum == trailNum {
                let node = child as?bombNode
                node?.onTop = 0
             
            }
        }
    }

    func getScore() -> Int
    {
        return score
    }
    
    func pauseGame(){
        
        self.pause = true
        
        for child in self.children{
            
            if child is bombNode{
                
                let hide = SKAction.hide()
                child.runAction(SKAction.sequence([hide, SKAction.runBlock(self.pauseAction)]))
                
                if let node=child as?bombNode
                {
                    self.hiddenNodes.append(node)
                }
            }
        }
    }
    
    func pauseAction(){
        self.paused = true
    }

    class bombNode: SKSpriteNode {
        
        let colorOptions = ["blue", "brown", "gray", "green", "orange", "pink", "red", "purple", "yellow"]
        var myColor:String
        var mySpeedFactor: Double
        var myScore: Double
        var myMission:[target] = []
        var onTop: Int
        var trailNum: Int
        
        override init() {
            
            myColor = colorOptions[Int(arc4random_uniform(9))]      //randomly choose color
            mySpeedFactor = Double(4+Float(arc4random_uniform(7)))/Double(10) //choose a random number between 0.4~1
            onTop = 1
            trailNum = -1
            
            myScore = Double(10)/mySpeedFactor
            
            let myTexture = SKTexture(imageNamed: myColor)
            super.init(texture: myTexture, color: UIColor.clearColor(), size: myTexture.size())
            
            super.userInteractionEnabled = true
            
        }
        
        init(color: String) {
            
            myColor = color
            mySpeedFactor = Double(4+Float(arc4random_uniform(7)))/Double(10) //choose a random number between 0.4~1
            myScore = Double(10)/mySpeedFactor
            onTop = 1
            trailNum = -1
  
            let myTexture = SKTexture(imageNamed: myColor)
            super.init(texture: myTexture, color: UIColor.clearColor(), size: myTexture.size())
            
            super.userInteractionEnabled = true
            
        }
        
        required init?(coder aDecoder: NSCoder) {
            fatalError("init(coder:) has not been implemented")
        }
        
        override func touchesMoved(touches: NSSet, withEvent event: UIEvent) {
            for touch in touches {
                let location = touch.locationInNode(scene)  // make sure this is scene, not self
                position = location
            }
        }
        
        override func touchesBegan(touches: NSSet, withEvent event: UIEvent) {
            for touch in touches {
                
                // note: removed references to touchedNode
                // 'self' in most cases is not required in Swift
                if(hasActions() == true){
                    
                    removeAllActions()
                    zPosition = 15
                    let liftUp = SKAction.scaleTo(0.6, duration: 0.2)
                    runAction(liftUp)
                    if(onTop == 1 ){
                        onTrail[trailNum] = onTrail_next[trailNum]
                    }
                    
                }
            }
        }
        
        func checkOverlap(r: CGRect, p: CGPoint) -> Bool {
            
            let p = CGPointMake(p.x, p.y)
            if(CGRectContainsPoint(r, p)){
                return true
            }
            else {
                return false
            }
        }
        
        override func touchesEnded(touches: NSSet, withEvent event: UIEvent) {
            for touch in touches {
                zPosition = 0
                var positionInScene = touch.locationInView(nil)
                
                let dropDown = SKAction.scaleTo(0.4, duration: 0.2)
                runAction(dropDown)
                
                let disapear = SKAction.removeFromParent()
                var tmpTarget:target?
                
                /* check if the position of touched bomb is located on one of each target */
                for m in myMission {
                    if checkOverlap(m.rec, p: positionInScene) && !m.isMatched {
                        tmpTarget = m
                        
                        if(tmpTarget?.myColor == myColor){
                            break
                        }

                    }
                }
                
                /* to check if target is matched to the touched bomb */
                //1 check if target was found
                if let foundTarget = tmpTarget {
                    
                    //2 check if letter matches
                    if foundTarget.myColor == myColor {
                        foundTarget.alpha = 1
                        foundTarget.isMatched = true
                        scoring(foundTarget.isMatched)
                        runAction(SKAction.sequence([matchSound, disapear]))
                        
                        //check if all targets are matched
                        checkForSuccess()
                        
                    }else{
                        scoring(foundTarget.isMatched)
                        runAction(SKAction.sequence([explosionSound, disapear]))
                    }
                }
                else{ // play error sound
                    scoring(false)
                    runAction(SKAction.sequence([explosionSound, disapear]))
                }
                
            }
            
        }
        func hideMission() {
            let hide = SKAction.hide()
            for m in myMission {
                m.runAction(hide)
            }
        }
        func checkForSuccess() {
            for m in myMission {
                //no success, bail out
                if !m.isMatched {
                    return
                }
            }
            let comboSoundOption = Int(arc4random_uniform(2))
            
            var comboSound: SKAction
            switch(comboSoundOption){
                case 0: comboSound = yahooSound
                case 1: comboSound = YAYSound
                default: comboSound = yahooSound
            }
            runAction(comboSound)
            
            comboRate += 0.2
            scoring(true)
            hideMission()
            resetMTime()
            
        }
        func resetMTime() {
            if let myParent = self.parent as? MissionScene {
                myParent.resetMTime()
            }
        }
        func scoring(add: Bool) {
            
            if add == true {
                myScore *= comboRate
                score += Int(round(myScore))
            }
            else {
                if score < Int(round(myScore)) {
                    score = 0
                }
                else{
                    score -= Int(round(myScore))
                }
            }
        }
        
    }
    
    class target: SKSpriteNode{
        
        var isMatched = false
        var myColor:String
        var rec:CGRect
        
        init(color: String, r: CGRect){
            myColor = color
            rec = r
            let myTexture = SKTexture(imageNamed: myColor)
            super.init(texture: myTexture, color: UIColor.clearColor(), size: myTexture.size())
            
        }
        
        required init?(coder aDecoder: NSCoder) {
            fatalError("init(coder:) has not been implemented")
        }
        
    }
    
}
