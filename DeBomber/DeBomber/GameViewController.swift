//
//  GameViewController.swift
//  DeBomber
//
//  Created by Linda on 2/23/15.
//  Copyright (c) 2015 MatchStick. All rights reserved.
//

import UIKit
import SpriteKit
import AVFoundation

class GameViewController: UIViewController, PlayViewControllerDelegate/*, RecordViewDelegate*/{

    @IBOutlet weak var segment: UISegmentedControl!

    var backgroundPlayer = AVAudioPlayer()
    var backgroundURL: NSURL!

    override func viewDidLoad() {
        super.viewDidLoad()
        
        view.backgroundColor = UIColor(patternImage: UIImage(named: "background.png")!)

        //background Music
        backgroundURL = NSURL(fileURLWithPath: NSBundle.mainBundle().pathForResource("gameView", ofType: "mp3")!)
        backgroundPlayer = AVAudioPlayer(contentsOfURL: backgroundURL, error: nil)
        backgroundPlayer.numberOfLoops = -1
        backgroundPlayer.volume = 0.5
        backgroundPlayer.enableRate = true
        backgroundPlayer.rate = 1.0
        backgroundPlayer.play()

    }
    
    //send data from 1st view(GameViewController) to 2nd view(PlayViewController)
    override func prepareForSegue(segue: UIStoryboardSegue, sender: AnyObject?) {
        
        //var id = segue.identifier
        if let identifier = segue.identifier {
            
            //backgroundPlayer.stop()

            if (identifier == "survivalButtonSegue")
            {
                var secondVC = segue.destinationViewController as PlayViewController;
                secondVC.delegate = self
                secondVC.difficulty = 0
                backgroundPlayer.stop()
            }
            else if (identifier == "missionButtonSegue")
            {
                var secondVC = segue.destinationViewController as PlayViewController;
                secondVC.delegate = self
                secondVC.difficulty = 1
                backgroundPlayer.stop()
            }else if (identifier == "TutorialViewSegue"){
                
                var secondVC = segue.destinationViewController as TutorialViewController;
                
            }
            
        }
    }

    //replay background Music when back to the 1st View
    func replayBackgroundMusic(controller: PlayViewController){
        
        backgroundPlayer.play()
        
    }
    /*
    func replayBackgroundMusic(controller: RecordView){
        
        backgroundPlayer.play()
        
    }
    */

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Release any cached data, images, etc that aren't in use.
    }
}
