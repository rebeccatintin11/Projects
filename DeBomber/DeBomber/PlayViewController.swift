//
//  PlayViewController.swift
//  DeBomber
//
//  Created by Linda on 2/23/15.
//  Copyright (c) 2015 MatchStick. All rights reserved.
//

import UIKit
import SpriteKit
import AVFoundation

//When back to the 1st View(the 2nd View is dismissed), replay the background music of the 1st view
//Since 1st view is the root, which must not be removed when calling the 2nd view. It only can be covered by the 2nd view
protocol PlayViewControllerDelegate{
    
    func replayBackgroundMusic(controller: PlayViewController)
}

class PlayViewController: UIViewController, CustomAlertDelegate{
    
    var difficulty:Int = 0
    var gameScene: GameScene!
    var missionScene: MissionScene!
    
    @IBOutlet var stopButton: UIButton!
    //@IBOutlet var progressTime: UIProgressView!
    @IBOutlet weak var progressImageView: UIImageView!
    
    //Used for 10s left
    @IBOutlet weak var clockImageView: UIImageView!
    @IBOutlet weak var HurryUpImageView: UIImageView!
    
    //background music
    var backgroundPlayer = AVAudioPlayer()
    var backgroundURL: NSURL!
    
    //10s Left sound
    var tenSecPlayer = AVAudioPlayer()
    var tenSecURL: NSURL!
    var tenSecSoundPlaying = Bool()
    
    //Time's Up sound
    var ohohPlayer = AVAudioPlayer()
    var ohohURL: NSURL!
    
    var delegate:PlayViewControllerDelegate? = nil
    
    var alert = CustomAlert()
    
    override func viewDidLoad() {
        super.viewDidLoad()
        setupGame()
        
        // Do any additional setup after loading the view.
    }
    
    func setupGame()  {
        
        // Configure the view.
        let skView = view as SKView
        skView.multipleTouchEnabled = false
        
        // Create and configure the scene & set Timer
        if(difficulty == 0){
            gameScene = GameScene(size: skView.bounds.size)
            gameScene.scaleMode = .AspectFill
            // Present the scene.
            skView.presentScene(gameScene)
        
            gameScene.second = 60
            //progressTime.progress = Float(gameScene.second) / 60.0

            var percent = CGFloat(0.0 + Double(gameScene.second)/60)
            runProgressTime(percent)

            gameScene.time = NSTimer.scheduledTimerWithTimeInterval(1.0, target: self, selector: Selector("updateTime"), userInfo: nil, repeats: true)
        }
        else{ //difficulty == 1
            missionScene = MissionScene(size: skView.bounds.size)
            missionScene.scaleMode = .AspectFill
            // Present the scene.
            skView.presentScene(missionScene)
            
            missionScene.second = 60
            //progressTime.progress = Float(missionScene.second) / 60.0

            var percent = CGFloat(0.0 + Double(missionScene.second)/60)
            runProgressTime(percent)

            missionScene.time = NSTimer.scheduledTimerWithTimeInterval(1.0, target: self, selector: Selector("updateTime"), userInfo: nil, repeats: true)
        }
        
        //background Music
        backgroundURL = NSURL(fileURLWithPath: NSBundle.mainBundle().pathForResource("playView", ofType: "mp3")!)
        backgroundPlayer = AVAudioPlayer(contentsOfURL: backgroundURL, error: nil)
        backgroundPlayer.numberOfLoops = -1
        backgroundPlayer.volume = 0.5
        backgroundPlayer.enableRate = true
        backgroundPlayer.rate = 1.0
        backgroundPlayer.play()
        
        /*
        In some cases, when the "addTime" specialNode is touched, and timer is added from less than 10s to more than 10s,
        we have to initialize all events that occur when the timer is less than 10s. "tenSecSoundPlaying" is to indicate whether those related variables occurs or not.
        */
        tenSecSoundPlaying = false
        
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    func updateTime(){
        
        if(difficulty == 0){
            gameScene.second--
            
            var percent = CGFloat(0.0 + Double(gameScene.second)/60)
            runProgressTime(percent)

            //progressTime.progress = Float(gameScene.second) / 60.0
            //NSLog("%d", gameScene.second)
        }
        else{ //difficulty == 1
            missionScene.second--
            
            var percent = CGFloat(0.0 + Double(missionScene.second)/60)
            runProgressTime(percent)

            //progressTime.progress = Float(missionScene.second) / 60.0
        }
        
        if (difficulty == 0 && gameScene.second == 0)||(difficulty == 1 && missionScene.second == 0){
            
            
            var message = String()
            if(difficulty == 0){
                self.gameScene.pause = true
                self.gameScene.pauseGame()
            }
            else{ //difficulty == 1
                self.missionScene.pause = true
                self.missionScene.mTime.invalidate()
                self.missionScene.pauseGame()
            }
            
            /*
            let alert = UIAlertController(title: "Time's up!",
            message: message,
            preferredStyle: UIAlertControllerStyle.Alert)
            
            alert.addAction(UIAlertAction(title: "OK", style: UIAlertActionStyle.Default, handler: {
            action in
            self.dismissViewControllerAnimated(true, completion:nil)
            
            if (self.delegate != nil){
            self.delegate!.replayBackgroundMusic(self)
            }
            
            }))
            
            presentViewController(alert, animated: true, completion:nil)
            */
            
            //"OhOh~" Time's Up Sound
            ohohURL = NSURL(fileURLWithPath: NSBundle.mainBundle().pathForResource("ohoh", ofType: "mp3")!)
            ohohPlayer = AVAudioPlayer(contentsOfURL: ohohURL, error: nil)
            ohohPlayer.volume = 1.0
            ohohPlayer.play()
            
            backgroundPlayer.stop()
            
            clockImageView.stopAnimating()
            clockImageView.image = UIImage(named: "clock1.png")
            
            HurryUpImageView.stopAnimating()
            HurryUpImageView.image = UIImage()
            
        }
        else if(difficulty == 0 && gameScene.second == -1)||(difficulty == 1 && missionScene.second == -1){
            //Get current date
            let date = NSDate()
            let formatterDate = NSDateFormatter()
            formatterDate.dateStyle = .ShortStyle //Set style of date
            var dateString = formatterDate.stringFromDate(date) //Convert to String
            
            var message = String()
            if(difficulty == 0){
                gameScene.time.invalidate()
                message = String(gameScene.getScore())
                record("survival", point: String(gameScene.getScore()), date: dateString)
            }
            else{ //difficulty == 1
                missionScene.time.invalidate()
                message = String(missionScene.getScore())
                record("mission", point: String(missionScene.getScore()), date: dateString)
            }

            alert.delegate = self
            alert.show(self, type: "timesUp", text: message)
            
        }
        else if(difficulty == 0 && gameScene.second <= 10)||(difficulty == 1 && missionScene.second <= 10){
            
            if(difficulty == 0 && gameScene.second == 10)||(difficulty == 1 && missionScene.second == 10){
                
                tenSecSoundPlaying = true
                
                //Ten Second Music
                tenSecURL = NSURL(fileURLWithPath: NSBundle.mainBundle().pathForResource("BeeDo", ofType: "mp3")!)
                tenSecPlayer = AVAudioPlayer(contentsOfURL: tenSecURL, error: nil)
                tenSecPlayer.volume = 2.0
                tenSecPlayer.play()
               
                //increase the speed of background music
                backgroundPlayer.enableRate = true
                backgroundPlayer.rate = 1.5
                
                //make clock image flush
                var clockList = [UIImage]()
                clockList += [UIImage(named: "clock1")!, UIImage(named: "clock2")!, UIImage(named: "clock3")!]
                clockImageView.animationImages = clockList
                clockImageView.startAnimating()
                
                //show "Hurry Up!!!" label) and make it flush
                HurryUpImageView.image = UIImage(named: "HurryUp1.png")
                var hurryUpList = [UIImage]()
                hurryUpList += [UIImage(named: "HurryUp1")!, UIImage(named: "HurryUp2")!, UIImage(named: "HurryUp3")!]
                HurryUpImageView.animationImages = hurryUpList
                HurryUpImageView.startAnimating()
                
            }
            
        }
        else{
            if(tenSecSoundPlaying){
                
                //initialize all events that occur when the timer is less than 10s
                tenSecPlayer.pause()
                
                backgroundPlayer.rate = 1.0
                
                clockImageView.stopAnimating()
                clockImageView.image = UIImage(named: "clock1.png")
                
                HurryUpImageView.stopAnimating()
                HurryUpImageView.image = UIImage()
                
                tenSecSoundPlaying = false
            }
        }
        
    }
    
    func runProgressTime(percent:CGFloat) {
        
        //println(percent)
        let progressImg : UIImage! = UIImage(named:"progressImage")!
        if progressImg == nil {return}
        let sz = progressImg.size
        let top = sz.width * (1-percent)
        UIGraphicsBeginImageContextWithOptions(sz, false, 0)
        let con = UIGraphicsGetCurrentContext()
        UIColor.blueColor().setFill()
        CGContextFillRect(con, CGRectMake(0,0,sz.width-top,sz.height))
        progressImg.drawAtPoint(CGPointMake(0,0))
        self.progressImageView.image = UIGraphicsGetImageFromCurrentImageContext()
        UIGraphicsEndImageContext()
    }

    @IBAction func stopButtonPressed(){
        
        if(difficulty == 0){
            gameScene.time.invalidate()
            gameScene.pauseGame()
        }
        else{ //difficulty == 1
            missionScene.time.invalidate()
            missionScene.mTime.invalidate() //pause the mission timer
            missionScene.pauseGame()
        }
        
        alert.delegate = self
        alert.show(self, type: "pause")
       
        /*
        let alert = UIAlertController(title: "*Pause*", message: nil, preferredStyle: UIAlertControllerStyle.Alert)
        
        alert.addAction(UIAlertAction(title: "Continue", style: UIAlertActionStyle.Default, handler: {
            action in
            
            if(self.difficulty == 0){
                self.gameScene.time = NSTimer.scheduledTimerWithTimeInterval(1.0, target: self, selector: Selector("updateTime"), userInfo: nil, repeats: true)
                self.gameScene.restart = true
                self.gameScene.pause = false
            }
            else{ //difficulty == 1
                self.missionScene.time = NSTimer.scheduledTimerWithTimeInterval(1.0, target: self, selector: Selector("updateTime"), userInfo: nil, repeats: true)
                self.missionScene.restart = true
                self.missionScene.pause = false
            }
        }))
        
        alert.addAction(UIAlertAction(title: "Retry", style: UIAlertActionStyle.Default, handler: {
            action in
            
            if(self.tenSecSoundPlaying){
                self.clockImageView.stopAnimating()
                self.clockImageView.image = UIImage(named: "clock1.png")
                
                self.HurryUpImageView.stopAnimating()
                self.HurryUpImageView.image = UIImage()
            }
            
            self.setupGame()
        }))
        
        alert.addAction(UIAlertAction(title: "Main", style: UIAlertActionStyle.Default, handler: {
            action in
            
                self.dismissViewControllerAnimated(true, completion: nil)
            
                if (self.delegate != nil){
                    self.delegate!.replayBackgroundMusic(self)
                }
            
        }))
        presentViewController(alert, animated: true, completion:nil)
        */
    }
    
    func continueButtonClicked(controller: CustomAlert){
        
        if (alert.buttonClicked == "Continue"){
            if(self.difficulty == 0){
                self.gameScene.time = NSTimer.scheduledTimerWithTimeInterval(1.0, target: self, selector: Selector("updateTime"), userInfo: nil, repeats: true)
                self.gameScene.restart = true
                self.gameScene.pause = false
            }
            else{ //difficulty == 1
                self.missionScene.time = NSTimer.scheduledTimerWithTimeInterval(1.0, target: self, selector: Selector("updateTime"), userInfo: nil, repeats: true)
                self.missionScene.setMtimer_s()  //resume the mission timer
                self.missionScene.restart = true
                self.missionScene.pause = false
            }
        }
    }
    
    func OKorMainButtonClicked(controller: CustomAlert){
        
        if (alert.buttonClicked == "OKorMain"){
            backgroundPlayer.stop()
            self.dismissViewControllerAnimated(true, completion:nil)
            
            if (self.delegate != nil){
                self.delegate!.replayBackgroundMusic(self)
            }
        }
    }
    
    func retryButtonClicked(controller: CustomAlert){
        
        if (alert.buttonClicked == "Retry"){
            if(self.tenSecSoundPlaying){
                self.clockImageView.stopAnimating()
                self.clockImageView.image = UIImage(named: "clock1.png")
                
                self.HurryUpImageView.stopAnimating()
                self.HurryUpImageView.image = UIImage()
            }
            
            self.setupGame()
        }
    }

    func record(mode:String , point:String, date:String){
        
        var record_first = ["",""]
        var record_second = ["",""]
        var record_third = ["",""]
        
        var record = ["","",""]
        var time = ["","",""]
        
        var userDefaults = NSUserDefaults.standardUserDefaults()


        
        if(mode == "survival"){
            //read record
            if let array : AnyObject = userDefaults.objectForKey("record_survival_first") {
                record[0] = array[0] as String
                time[0] = array[1] as String
            }
            if let array : AnyObject = userDefaults.objectForKey("record_survival_second") {
                record[1] = array[0] as String
                time[1] = array[1] as String
            }
            if let array : AnyObject = userDefaults.objectForKey("record_survival_third") {
                record[2] = array[0] as String
                time[2] = array[1] as String
            }
        }
        else if(mode == "mission"){
            //read record
            if let array : AnyObject = userDefaults.objectForKey("record_mission_first") {
                record[0] = array[0] as String
                time[0] = array[1] as String
            }
            if let array : AnyObject = userDefaults.objectForKey("record_mission_second") {
                record[1] = array[0] as String
                time[1] = array[1] as String
            }
            if let array : AnyObject = userDefaults.objectForKey("record_mission_third") {
                record[2] = array[0] as String
                time[2] = array[1] as String
            }

        }
        
        
        //set current point
        let current_score: String  = point;
        let current_time: String  = date;
        let i:String = ""
        var found : Int = 0;
        
        //update record
        for i in record{
            if (current_score.toInt() > i.toInt() && found == 0)
            {
                let ind_record: Int = find(record,i)!
                for (var j = 2 ; j > ind_record; j--){
                    record[j] = record[j-1]
                    time[j] = time[j-1]
                }
                record[ind_record] = current_score
                time[ind_record] = current_time
                found = 1
            }
        }
        record_first = [record[0],time[0]]
        record_second = [record[1],time[1]]
        record_third = [record[2],time[2]]
        
        
        if(mode == "survival"){
            userDefaults.setObject(record_first, forKey: "record_survival_first")
            userDefaults.setObject(record_second, forKey: "record_survival_second")
            userDefaults.setObject(record_third, forKey: "record_survival_third")
        }
        else if(mode == "mission"){
            userDefaults.setObject(record_first, forKey: "record_mission_first")
            userDefaults.setObject(record_second, forKey: "record_mission_second")
            userDefaults.setObject(record_third, forKey: "record_mission_third")
        }
        userDefaults.synchronize()
        
    }
}




















