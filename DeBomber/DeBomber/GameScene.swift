//
//  GameScene.swift
//  DeBomber
//
//  Created by Linda on 2/23/15.
//  Copyright (c) 2015 MatchStick. All rights reserved.
//

import SpriteKit
import AVFoundation

var scoreLabel = SKLabelNode(fontNamed:"Futura-Medium")

var score: Int = 0{
    didSet {
        scoreLabel.text = String(format: "%05d", score)
    }
}
////////////
var comboLabel = SKLabelNode(fontNamed:"Futura-Medium")

var comboRate: Double = 0.0{
    didSet {
        if(comboRate == 0.0){
            comboLabel.text = String()
        }
        else{
            comboLabel.text = String(format: "Combo: x%.1f", comboRate)
        }
    }
}

let explosionSound = SKAction.playSoundFileNamed("explosion.mp3", waitForCompletion: false)
let matchSound = SKAction.playSoundFileNamed("match.mp3", waitForCompletion: false)

let hahaSound = SKAction.playSoundFileNamed("haha.mp3", waitForCompletion: false)
let yahooSound = SKAction.playSoundFileNamed("yahoo.mp3", waitForCompletion: false)
let YAYSound = SKAction.playSoundFileNamed("YAY.mp3", waitForCompletion: false)
let EvilSound = SKAction.playSoundFileNamed("EvilLaugh.mp3", waitForCompletion: false)

var specialNodeResult = String()
var showTimeAdded: Bool = false
var showAllClear: Bool = false
var onTrail = [0.0, 0.0, 0.0, 0.0, 0.0]
var onTrail_next = [0.0, 0.0, 0.0, 0.0, 0.0]

class GameScene: SKScene {
    
    //Timer, controled by PlayViewCOntroller
    var time = NSTimer()
    var second = 60
    
    let floor_y = CGFloat(80)
    var moverSpeed = 5.0
    let moveFactor = 1.05
    var now : NSDate?
    var nextTime : NSDate?
    var colWidth = 40
    var NTrails = 5
    
    
    /* variables for bomb number control */
    var bombQ: Queue<pair>!
    var Qsize = 9
    var bombCount = 0
    var maxNumOfBombs = 12
    /* end of variables for bomb number control */
    
    var pause = false
    var restart = false
    var hiddenBombNodes:[bombNode] = []
    var hiddenSpecialNodes:[specialNode] = []
    
    //used for "increaseSpeed" Special Node, to record the time interval that bombNodes should increase speed
    var increaseSpeedTimeInterval: Int = 0
    
    override func didMoveToView(view: SKView) {
        backgroundColor = (UIColor.lightGrayColor())
        initializeValues()

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
                onTrail_next.append(0.0) //add extra trails
            }
        }
        //NSLog("%d", NTrails);
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
        scoreLabel.position = CGPoint(x:CGRectGetMaxX(self.frame) - 4, y:(CGRectGetMaxY(self.frame) - 42));
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
        hiddenBombNodes.removeAll()
        hiddenSpecialNodes.removeAll()
        
        /* used for "increaseSpeed" Special Node */
        var increaseSpeedTimeInterval = 0
        
        /////////////////
        /* Set comboRate display */
        comboLabel = SKLabelNode(fontNamed:"Futura-Medium")
        comboLabel.text = String(format: "Combo Rate: %.1f", comboRate)
        comboRate = 0.0
        comboLabel.fontSize = 20
        comboLabel.fontColor = SKColor.redColor()
        comboLabel.horizontalAlignmentMode = SKLabelHorizontalAlignmentMode.Right
        comboLabel.position = CGPoint(x: (self.frame.width - 5), y: 5);
        comboLabel.zPosition = 3
        
        self.addChild(comboLabel)
        /* End of set score display */
        
        /* Initialize variables for bomb number control */
        maxNumOfBombs = 12
        Qsize = 9
        bombCount = 0
        bombQ = Queue<pair>()
        fillQueue();

    }
    func minusBombCount() {
        //NSLog("%d", bombCount)
        bombCount--
    }
    func addOneToQ() {
        let nodeChoose = Int(arc4random_uniform(10)) + 1
        let special = (nodeChoose == 1) ? 1 : 0;
        let type = 9;   //random
        let newPair = pair(special: special, type: type)
        bombQ.enQueue(newPair)
    }
    /* Fill queue */
    func fillQueue() {
        for var i = 0; i < Qsize; i++ {
            addOneToQ()
        }
    }
    /*
    func increaseSpeed() {
        moverSpeed = moverSpeed - (0.001*(Double(score)))
    }
    */
    
    override func update(currentTime: CFTimeInterval) {
      
       if (!self.pause){

            if(self.restart)
            {
                
                for child in self.hiddenBombNodes{
                    child.hidden = false
                }
                self.hiddenBombNodes.removeAll()
                
                for child in self.hiddenSpecialNodes{
                    child.hidden = false
                }
                self.hiddenSpecialNodes.removeAll()
                
                self.restart = false
                
            }

            self.paused = false
        
            now = NSDate()
        
            if (now?.timeIntervalSince1970 > nextTime?.timeIntervalSince1970){
                //NSLog("-------------")
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
                    //NSLog("%.1f",onTrail[i])
                }
                
                if bombCount <= (2) { //too few nodes
                    batchBomb()
                }
                if Int(arc4random_uniform(10))+1 < 9 && (bombCount < maxNumOfBombs){
                    generateBomb()
                }
                
            }
        
            if(!specialNodeResult.isEmpty){
                specialEventCheck()
            }
        
            //initialize increaseSpeedTimeInterval
            if(second == increaseSpeedTimeInterval-5){
                increaseSpeedTimeInterval = 0
            }
        }
        
    }
    
    /* call by PlayViewController */
    func pauseGame(){

        self.pause = true
        
        for child in self.children{
            
            if child is bombNode{
                
                let hide = SKAction.hide()
                child.runAction(SKAction.sequence([hide, SKAction.runBlock(self.pauseAction)]))
                
                if let node=child as?bombNode
                {
                    self.hiddenBombNodes.append(node)
                }
            }
            else if child is specialNode{
                
                let hide = SKAction.hide()
                child.runAction(SKAction.sequence([hide, SKAction.runBlock(self.pauseAction)]))
                
                if let node=child as?specialNode
                {
                    self.hiddenSpecialNodes.append(node)
                }
            }

        }
    }
 
    func pauseAction(){
        self.paused = true
    }
    
    func batchBomb() {
        //NSLog("Call batchBomb!!")
        //let width = Int(self.frame.width) - 2*colWidth
        for var i = 0; i < NTrails; i+=2 {
            let newX = colWidth * (i+1)
            let newY = Int(self.frame.height)+10
            
            let pp = CGPoint(x:Int(newX), y:newY)
            let destinationp = CGPoint(x:Int(newX), y:80)
            
            let temp: pair = bombQ.deQueue()!   //take the top pair from the queue
            
            let nodeChoose = temp.getX()
            let type = temp.getY()
            
            addBumb(nodeChoose, type: type, p:pp, destination:destinationp)
            addOneToQ() //generate one pair and put into the queue
        }
        
    }
    
    func generateBomb(){
        let width = Int(self.frame.width) - 2*colWidth
        var newX = colWidth + ( (arc4random() % UInt32(NTrails)) * UInt32(colWidth))
        var newY = Int(self.frame.height) + 10
        
        var pp = CGPoint(x:Int(newX), y:newY)
        var destinationp = CGPoint(x:Int(newX), y:80)
        
        var temp: pair = bombQ.deQueue()!   //take the top pair from the queue
        
        let nodeChoose = temp.getX()
        var type = temp.getY()
        
        addBumb(nodeChoose, type: type, p:pp, destination:destinationp)
        addOneToQ() //generate one pair and put into the queue
    }
    func addBumb(special: Int, type: Int, p:CGPoint, destination:CGPoint) {
        /* special = 0 => regular bomb; special = 1 => special bomb */
        /*     Type   0        1             2                3      4      5     6    7        8       9
        regular(0): blue,    brown,         gray,           green, orange, pink, red, purple, yellow, random, ...
        special(1):addTime, removeAllBombs, increaseSpeed,  random, ...
        */
        //variables in common
        var trailNum_temp = (Int(p.x)/colWidth)-1
        var duration = NSTimeInterval()
        let explode = SKAction.setTexture(SKTexture(imageNamed: "BOOM.png"))
        let explodeDuration = SKAction.waitForDuration(0.5)
        let hide = SKAction.hide()
        let childHide = SKAction.runAction(hide, onChildWithName: "colorName")
        let deductCount = SKAction.runBlock( minusBombCount )
        //NSLog("special = %d", special)
        //three cases
        if( special == 0) {
            var item:bombNode = bombNode(choice: type)
            let touchBanned = SKAction.runBlock( item.touchForbid )
            item.xScale = 0.4
            item.yScale = 0.4
            item.position = p
            item.trailNum = trailNum_temp
            
            var currentColor = item.getColorCode()
            
            if((increaseSpeedTimeInterval>0) && (second<=increaseSpeedTimeInterval && second>=increaseSpeedTimeInterval-5)){
                duration = NSTimeInterval(1.5)
                item.bombDuration = duration
            }
            else{
                duration = NSTimeInterval(moverSpeed*item.mySpeedFactor)
                item.bombDuration = duration
            }
            let falling = SKAction.moveTo(destination, duration: duration)
            if item.matched == true {
                item.runAction(SKAction.sequence([falling, childHide, touchBanned, explode, explodeDuration, deductCount, SKAction.removeFromParent()]))
            }
            else {
                item.runAction(SKAction.sequence([falling, hide, deductCount, SKAction.removeFromParent()]))
            }
            avoidOverlap(item.trailNum, duration: duration, item: item)
        }
        else if( special == 1) {
            var item:specialNode = specialNode(choice: type)
            item.xScale = 0.4
            item.yScale = 0.4
            item.position = p
            item.trailNum = trailNum_temp
            
            var duration = NSTimeInterval()
            if(item.specialNode == "removeAllBombs" || item.specialNode == "addTime"){
                duration = NSTimeInterval(1.5)
            }
            else{
                duration = NSTimeInterval(2.5)
            }
            let falling = SKAction.moveTo(destination, duration: duration)
            item.runAction(SKAction.sequence([falling, hide, deductCount, SKAction.removeFromParent()]))
            avoidOverlap(item.trailNum, duration: duration, item: item)
        }
        else {
            NSLog("Error!!")
        }
    }
    func avoidOverlap(trailNum:Int, duration: Double, item:SKSpriteNode) {
        let durInt:Double = Double(duration)
        
        /*avoid overlap from current and nearby trails*/
        if (trailNum == 0){
            if (onTrail[trailNum]+0.5 < durInt && onTrail[trailNum+1]+0.5 < durInt){
                onTrail_next[trailNum] = onTrail[trailNum]
                onTrail[trailNum] = durInt
                update_trail_top(trailNum)  //let this new node in top
                self.addChild(item)
                bombCount++
            }
        }
        else if (trailNum == onTrail.count-1){
            if (onTrail[trailNum]+0.5  < durInt && onTrail[trailNum-1]+0.5 < durInt){
                onTrail_next[trailNum] = onTrail[trailNum]
                onTrail[trailNum] = durInt
                update_trail_top(trailNum)  //let this new node in top
                self.addChild(item)
                bombCount++
            }
        }
        else{
            if ((onTrail[trailNum]+0.5 < durInt) && (onTrail[trailNum+1]+0.5 < durInt) && (onTrail[trailNum-1]+0.5 < durInt)){
                onTrail_next[trailNum] = onTrail[trailNum]
                onTrail[trailNum] = durInt
                update_trail_top(trailNum)  //let this new node in top
                self.addChild(item)
                bombCount++
            }
        }
        /*end of avoiding overlap*/
    }

    func specialEventCheck(){
        
        if(specialNodeResult == "removeAllBombs"){
            
            /* if "removeAllBombs" is touched, remove all bombs and add score for all matched bombs */
            
            showAllClear = true
            for child in self.children{
                
                if child is bombNode{
                    
                    if(child.matched == true){
                        child.scoring(child.matched)
                    }
                    
                    child.runAction(SKAction.removeFromParent())
                    minusBombCount()
                }
            }
            
            //remove previous "All Clear" image and generate the new one
            for child in self.children{
                
                if child is specialNode{
                    
                    if(child.specialNode == "allClear"){
                        
                        child.runAction(SKAction.removeFromParent())
                    }
                }
            }
            
            /* generate allClear image */
            let start =  CGPoint(x: 3*Int(self.frame.width)/5, y: Int(self.frame.height) - 65)
            let end = CGPoint(x: 4*Int(self.frame.width)/5, y:Int(self.frame.height) - 65)
            
            var item:specialEffect = specialEffect()
            
            item.xScale = 0.4
            item.yScale = 0.4
            item.position = start
            let duration = NSTimeInterval(1)
            
            let falling = SKAction.moveTo(end, duration: duration)
            let hide = SKAction.hide()
            
            item.runAction(SKAction.sequence([falling, hide, SKAction.removeFromParent()]))
            self.addChild(item)
            /* End of generate allClear image */
            
            showAllClear = false
            specialNodeResult = String()
            
        }
        else if(specialNodeResult == "addTime"){
            
            /* if "addTime" is touched, add timer and show the image */
            
            showTimeAdded = true
            
            if(second+5 > 60){
                second = 60
            }
            else{
                second += 5
            }
            
            //remove previous "Time++" image and generate the new one
            for child in self.children{
                
                if child is specialNode{
                    
                    if(child.specialNode == "showTimeAdded"){
                        child.runAction(SKAction.removeFromParent())
                    }
                }
            }
            
            /* generate TimeAdded image */
            let start = CGPoint(x: 4*Int(self.frame.width)/5, y:Int(self.frame.height) - 65)
            let end =  CGPoint(x: 3*Int(self.frame.width)/5, y: Int(self.frame.height) - 65)
            
            var item:specialEffect = specialEffect()
            
            item.xScale = 0.4
            item.yScale = 0.4
            item.position = start
            let duration = NSTimeInterval(1)
            
            let falling = SKAction.moveTo(end, duration: duration)
            
            let hide = SKAction.hide()
            
            item.runAction(SKAction.sequence([falling, hide, SKAction.removeFromParent()]))
            self.addChild(item)
            /* End of generate TimeAdded image */
            
            showTimeAdded = false
            specialNodeResult = String()
        }
        else if(specialNodeResult == "increaseSpeed"){
            
            /* if "increaseSpeed" is touched, record time interval(5 seconds),
                change the speed for exsited bombs and generate the faster bombs during the time interval */
            
            increaseSpeedTimeInterval = second
            
            for child in self.children{
                
                if child is bombNode{
                    child.runAction(SKAction.speedTo(3.0, duration: child.bombDuration/2))
                }
            }
            
            specialNodeResult = String()
        }

    }
    
    func update_trail_top(trailNum: Int){
        for child in self.children{
            if (child is bombNode || child is specialNode) && child.trailNum == trailNum {
                if let node = child as?bombNode{
                   node.onTop = 0
                }
                else if let node = child as?specialNode{
                    node.onTop = 0
                }
            }
        }
    }
    
    func getScore() -> Int{//call by PlayViewController
        
        return score
    }
    
    class specialEffect: SKSpriteNode{
        var specialEffect = String()
        
        override init() {
            
            if(showTimeAdded){
                specialEffect = "showTimeAdded"
            }
            else if(showAllClear){
                specialEffect = "allClear"
            }
            
            let texture = SKTexture(imageNamed: specialEffect)
            
            if(specialEffect=="showTimeAdded"){
                super.init(texture: texture, color: UIColor.clearColor(), size: texture.size())
            }
            else{// specialEffect == "allClear"
                super.init(texture: texture, color: UIColor.clearColor(), size:  CGSize(width: 200, height: 150))
            }
        }
        
        required init?(coder aDecoder: NSCoder) {
            fatalError("init(coder:) has not been implemented")
        }

    }
    
    class specialNode: SKSpriteNode{

        let specialNodeOptions = ["addTime", "removeAllBombs", "increaseSpeed"]
        var specialNode = String()
        var trailNum: Int
        var onTop: Int
        
        init(choice: Int) {
            if(choice >= 3) {
                specialNode = specialNodeOptions[Int(arc4random_uniform(3))]
            }
            else {
                specialNode = specialNodeOptions[choice]
            }
            let texture = SKTexture(imageNamed: specialNode)
            trailNum = -1
            onTop = 1
            
            //set the size for each specialNode, and make it touchable(only "showTimeAdded" & "allClear" canNot be touched)
            switch(specialNode){
            case "addTime":
                super.init(texture: texture, color: UIColor.clearColor(), size: CGSize(width: 120, height: 120))
            case "removeAllBombs":
                super.init(texture: texture, color: UIColor.clearColor(), size: CGSize(width: 120, height: 140))
            case "increaseSpeed":
                super.init(texture: texture, color: UIColor.clearColor(), size: CGSize(width: 180, height: 220))
            default:
                super.init(texture: texture, color: UIColor.clearColor(), size: CGSize(width: 120, height: 120))
            }
            super.userInteractionEnabled = true
        }
        
        required init?(coder aDecoder: NSCoder) {
            fatalError("init(coder:) has not been implemented")
        }
        func addOnePairToQ() {
            if let myParent = self.parent as? GameScene {
                myParent.addOneToQ()
                myParent.generateBomb()
            }
        }
        func minusBombCount() {
            if let myParent = self.parent as? GameScene {
                myParent.minusBombCount()
            }
        }
        override func touchesBegan(touches: NSSet, withEvent event: UIEvent) {
            addOnePairToQ()
            minusBombCount()
            userInteractionEnabled = false
            let hide = SKAction.hide()
            switch(specialNode){
                case "addTime":
                    specialNodeResult = "addTime"
                    let addTimePic = SKAction.setTexture(SKTexture(imageNamed: "addTime.png"))
                    let hideDuration = SKAction.waitForDuration(0.5)
                    self.runAction(SKAction.sequence([YAYSound, hide, addTimePic, hideDuration, SKAction.removeFromParent()]))
                    if(onTop == 1 ){
                        onTrail[trailNum] = onTrail_next[trailNum]
                    }
                
                case "removeAllBombs":
                    specialNodeResult = "removeAllBombs"
                    self.runAction(SKAction.sequence([yahooSound, hide, SKAction.removeFromParent()]))
                    
                    for i in 0...onTrail.count-1{
                        onTrail[i] = 0
                    }
                case "increaseSpeed":
                    specialNodeResult = "increaseSpeed"
                    self.runAction(SKAction.sequence([EvilSound, hide, SKAction.removeFromParent()]))
                    if(onTop == 1 ){
                        onTrail[trailNum] = onTrail_next[trailNum]
                    }
                default:
                    specialNodeResult = "removeAllBombs"
            }
    
        }
        
    }
    
    class bombNode: SKSpriteNode{
        
        let colorOptions = ["blue", "brown", "gray", "green", "orange", "pink", "red", "purple", "yellow"]
        let colorMap: [String: Int] = ["blue" : 0, "brown" : 1, "gray" : 2, "green" : 3, "orange" : 4,
            "pink" : 5, "red" : 6, "purple" : 7, "yellow" : 8]
        var myColor:String
        var myText:String
        var matched:Bool
        var mySpeedFactor: Double
        var myScore: Double
        var trailNum: Int
        var onTop: Int
        
        var bombDuration: NSTimeInterval
        
        init(choice: Int) {
            if( choice >= 9) {    //random case
                myColor = colorOptions[Int(arc4random_uniform(9))]//randomly choose color
                myText = colorOptions[Int(arc4random_uniform(9))]//randomly choose color text
            }
            else {
                myColor = colorOptions[choice]
                myText = colorOptions[choice]
            }
            matched = (myColor == myText)
            mySpeedFactor = Double(4+Float(arc4random_uniform(7)))/Double(10) //choose a random number between 0.4~1
            myScore = Double(10)/mySpeedFactor//myscore = 10/speedfactor (10~40)
            trailNum = -1
            onTop = 1
            
            bombDuration = NSTimeInterval(1.0)
            //super.init()
            
            let texture = SKTexture(imageNamed: myColor)
            super.init(texture: texture, color: UIColor.clearColor(), size: texture.size())
            
            decideText(0.6)//60% chance the text and color will match.
            var textLabel = SKLabelNode()
            textLabel.name = "colorName"
            textLabel.text = randomCapitalize(myText)
            textLabel.fontName = "System-Bold"
            textLabel.fontSize = 45
            textLabel.fontColor = SKColor.blackColor()
            textLabel.position = CGPoint(x: 0, y: -50)
            super.addChild(textLabel)
            super.userInteractionEnabled = true
            
        }
        
        required init?(coder aDecoder: NSCoder) {
            fatalError("init(coder:) has not been implemented")
        }
        func addOnePairToQ() {
            if let myParent = self.parent as? GameScene {
                myParent.addOneToQ()
                myParent.generateBomb()
            }
        }
        func minusBombCount() {
            if let myParent = self.parent as? GameScene {
                myParent.minusBombCount()
            }
        }
        override func touchesBegan(touches: NSSet, withEvent event: UIEvent) {
            minusBombCount()
            addOnePairToQ()
            //No bombs can be touches more than 1 time
            userInteractionEnabled = false
            
            let explode = SKAction.setTexture(SKTexture(imageNamed: "BOOM.png"))
            let explodeDuration = SKAction.waitForDuration(0.5)
            let hide = SKAction.hide()
            let childHide = SKAction.runAction(hide, onChildWithName: "colorName")
            
            if matched == false {
                
                //initialize comboString & comboRate
                comboRate = 0.0
                
                self.runAction(SKAction.sequence([explosionSound, childHide, explode, explodeDuration, SKAction.removeFromParent()]))
                if(onTop == 1 ){
                    onTrail[trailNum] = onTrail_next[trailNum]
                }

                
            }
            else{
                
                if(comboRate == 0.0){
                    comboRate = 1.0
                }
                else if(comboRate > 0.0 && comboRate < 5.0){
                    //the highest comboRate is 5.0
                    comboRate += 0.5
                }
                
                if(comboRate > 1.0){
                    //create new combo image(to combine original combo image and comboRate text)
                    let comboImage = UIImage(named: "Combo.png")
                    var comboText = "x" + String(format:"%.1f", comboRate)
                    var newComboImage = drawText(comboImage!, text: comboText)
                    var combo = SKAction.setTexture(SKTexture(image: newComboImage))
                    
                    let comboDuration = SKAction.waitForDuration(0.3)
                    
                    let comboSoundOption = Int(arc4random_uniform(3))
                    
                    var comboSound: SKAction
                    switch(comboSoundOption){
                        case 0: comboSound = hahaSound
                        case 1: comboSound = yahooSound
                        case 2: comboSound = YAYSound
                        default: comboSound = hahaSound
                    }
                    
                    self.runAction(SKAction.sequence([comboSound, childHide, combo, comboDuration, SKAction.removeFromParent()]))
                    if(onTop == 1 ){
                        onTrail[trailNum] = onTrail_next[trailNum]
                    }

                }
                else{
                    self.runAction(SKAction.sequence([matchSound, hide, SKAction.removeFromParent()]))
                    if(onTop == 1 ){
                        onTrail[trailNum] = onTrail_next[trailNum]
                    }

                }
                
            }
            scoring(matched)
        }
        func getColorCode()-> Int{
            return colorMap[myColor]!
        }
        func touchForbid() {
            userInteractionEnabled = false
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
        
        /* Add text to combo image and return this new image */
        func drawText(image :UIImage, text:String) ->UIImage
        {
            UIGraphicsBeginImageContext(image.size);
            
            //draw 1st image
            let imageRect = CGRectMake(0,0,image.size.width,image.size.height/2)
            image.drawInRect(imageRect)
            
            //draw 2nd image(text part)
            let textRect  = CGRectMake(50, 15, image.size.width-10, image.size.height - 20)
            let font = UIFont.boldSystemFontOfSize(24)
            
            let textFontAttributes = [
                NSFontAttributeName: font,
                NSForegroundColorAttributeName: UIColor.redColor(),
            ]
            text.drawInRect(textRect, withAttributes: textFontAttributes)
            
            //get the screen shot for current image context
            let newImage = UIGraphicsGetImageFromCurrentImageContext();
            
            UIGraphicsEndImageContext()
            
            return newImage
        }

        func decideText(factor: Double) {
            let choose = Int(arc4random_uniform(10)) + 1
            if choose <= (Int)(factor*10)  {
                matched = true
                myText = myColor
            }
            
        }
        
        func randomCapitalize(input: String) -> String {
            var output = ""
            for character in input {
                let pick = Int(arc4random_uniform(2))
                if pick == 1 {
                    output += String(character).uppercaseString
                }
                else {
                    output += String(character)
                }
            }
            return output
        }
        
        func explode(){
            self.removeAllChildren()
        }
    }

}
