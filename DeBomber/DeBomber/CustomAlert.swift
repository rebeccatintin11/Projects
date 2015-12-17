//
//  CustomAlert.swift
//  test1
//
//  Created by Linda on 4/6/15.
//  Copyright (c) 2015 MatchStick. All rights reserved.
//

import Foundation
import UIKit

protocol CustomAlertDelegate{
    func OKorMainButtonClicked(controller: CustomAlert)
    func continueButtonClicked(controller: CustomAlert)
    func retryButtonClicked(controller: CustomAlert)
}

class CustomAlert: UIViewController {
    
    var rootViewController:UIViewController!
    var viewWidth:CGFloat?
    var viewHeight:CGFloat?
    
    var containerView:UIView!
    var alertBackgroundView:UIImageView!
    var alertBackgroundWidth:CGFloat?
    var alertBackgroundHeight: CGFloat?
    
    var alertType: String!
    
    /* used for "Time's Up" alert */
    var textView:UITextView!
    var OKButton:UIButton!
    
    /* used for "Pause" alert */
    var continueButton:UIButton!
    var retryButton:UIButton!
    var mainButton:UIButton!
    
    /* return message to PlayViewController */
    var delegate:CustomAlertDelegate? = nil
    var buttonClicked: String!
    
    required init(coder aDecoder: NSCoder) {
        fatalError("NSCoding not supported")
    }
    
    required override init() {
        super.init()
    }
    
    override init(nibName nibNameOrNil: String?, bundle nibBundleOrNil: NSBundle?){
        super.init(nibName:nibNameOrNil, bundle:nibBundleOrNil)
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    /* set components position for each alert */
    override func viewDidLayoutSubviews() {
        
        super.viewWillLayoutSubviews()
        
        self.alertBackgroundWidth = self.viewWidth!-50
        self.alertBackgroundHeight = self.viewHeight!/3
        
        if(self.alertType == "timesUp"){
            
            // position text
            if self.textView != nil {
                self.textView.frame = CGRect(x: 20, y: (self.alertBackgroundHeight!/4), width: self.alertBackgroundWidth! - 40, height: (self.alertBackgroundHeight!/2)-20)
            }
            
            // position the OKbutton
            self.OKButton.frame = CGRect(x: (self.alertBackgroundWidth!/4), y: 3*(self.alertBackgroundHeight!/4), width: (self.alertBackgroundWidth!/2), height: (self.alertBackgroundHeight!/5))
        }
        else if(self.alertType == "pause"){
            
            var yPos = (self.alertBackgroundHeight!/4)+7
            
            // position the continueButton
            self.continueButton.frame = CGRect(x: self.alertBackgroundWidth!/5, y: yPos, width: 3*(self.alertBackgroundWidth!/5), height: (self.alertBackgroundHeight!/5))
            
            yPos += (self.alertBackgroundHeight!/5)+6
            
            // position the retryButton
            self.retryButton.frame = CGRect(x: self.alertBackgroundWidth!/5, y: yPos, width: 3*(self.alertBackgroundWidth!/5), height: (self.alertBackgroundHeight!/5))
            
            yPos += (self.alertBackgroundHeight!/5)+6
            
            // position the mainButton
            self.mainButton.frame = CGRect(x: self.alertBackgroundWidth!/5, y: yPos, width: 3*(self.alertBackgroundWidth!/5), height: (self.alertBackgroundHeight!/5))
        }
        
        // size the background view
        self.alertBackgroundView.frame = CGRect(x: 0, y: 0, width: self.alertBackgroundWidth!, height: self.alertBackgroundHeight!)
        
        self.containerView.frame = CGRect(x: 25, y: (self.viewHeight!/3), width: self.alertBackgroundWidth!, height: self.alertBackgroundHeight!)
        
    }
    
    func show(viewController: UIViewController, type: String, text: String?=nil){
        
        self.rootViewController = viewController
        self.rootViewController.addChildViewController(self)
        self.rootViewController.view.addSubview(view)
        
        self.alertType = type
        
        // used for setting the size for alert view
        let sz = UIScreen.mainScreen().bounds.size
        self.viewWidth = sz.width
        self.viewHeight = sz.height
        
        // Container for the entire alert modal contents
        self.containerView = UIView()
        self.view.addSubview(self.containerView!)
        
        if(self.alertType == "timesUp"){
            
            // set background Image
            self.alertBackgroundView = UIImageView(image: UIImage(named:"timesUpAlertBackground.png"))
            alertBackgroundView.contentMode = UIViewContentMode.ScaleAspectFill
            alertBackgroundView.layer.masksToBounds = true
            self.containerView.addSubview(alertBackgroundView!)
            
            // View text
            if let text = text? {
                self.textView = UITextView()
                self.textView.userInteractionEnabled = false
                textView.editable = false
                textView.textColor = UIColor.whiteColor()
                textView.textAlignment = .Center
                textView.font = UIFont(name: "Arial Rounded MT Bold", size: 70)
                textView.backgroundColor = UIColor.clearColor()
                textView.text = text
                self.containerView.addSubview(textView)
            }
            
            // set the OK Button
            self.OKButton = UIButton()
            OKButton.setBackgroundImage(UIImage(named: "OKButton.png"), forState: .Normal)
            OKButton.addTarget(self, action: "OKorMainButtonTap", forControlEvents: .TouchUpInside)
            self.containerView.addSubview(OKButton)
        }
        else if(self.alertType == "pause"){
            
            // set background Image
            self.alertBackgroundView = UIImageView(image: UIImage(named:"pauseAlertBackground.png"))
            alertBackgroundView.contentMode = UIViewContentMode.ScaleAspectFill
            alertBackgroundView.layer.masksToBounds = true
            self.containerView.addSubview(alertBackgroundView!)
            
            // set the Continue Button
            self.continueButton = UIButton()
            continueButton.setBackgroundImage(UIImage(named: "continueButton.png"), forState: .Normal)
            continueButton.addTarget(self, action: "continueButtonTap", forControlEvents: .TouchUpInside)
            self.containerView.addSubview(continueButton)
            
            // set the Retry Button
            self.retryButton = UIButton()
            retryButton.setBackgroundImage(UIImage(named: "retryButton.png"), forState: .Normal)
            retryButton.addTarget(self, action: "retryButtonTap", forControlEvents: .TouchUpInside)
            self.containerView.addSubview(retryButton)
            
            // set the Main Button
            self.mainButton = UIButton()
            mainButton.setBackgroundImage(UIImage(named: "mainButton.png"), forState: .Normal)
            mainButton.addTarget(self, action: "OKorMainButtonTap", forControlEvents: .TouchUpInside)
            self.containerView.addSubview(mainButton)
            
        }
        
        /* open the alert view via animation */
        
        // set the original position
        self.containerView.frame.origin.x = self.rootViewController.view.center.x
        self.containerView.center.y = -500
        
        // animate the alert
        UIView.animateWithDuration(0.5, delay: 0.05, usingSpringWithDamping: 0.8, initialSpringVelocity: 0.5, options: nil, animations: {
            self.containerView.center = self.rootViewController.view.center
            }, completion: { finished in
                
        })
        
    }
    
    /* set the actions when OK button and Main button are tapped */
    func OKorMainButtonTap(){
        
        self.buttonClicked = "OKorMain"
        closeView();
        
        if (self.delegate != nil){
            self.delegate!.OKorMainButtonClicked(self)
        }
    }
    
    /* set the actions when Continue button is tapped */
    func continueButtonTap() {
        
        self.buttonClicked = "Continue"
        closeView();
        
        if (self.delegate != nil){
            self.delegate!.continueButtonClicked(self)
        }
    }
    
    /* set the actions when Retry button is tapped */
    func retryButtonTap() {
        
        self.buttonClicked = "Retry"
        closeView();
        
        if (self.delegate != nil){
            self.delegate!.retryButtonClicked(self)
        }
    }
    
    /* close the alert view via animation */
    func closeView() {
        
        /* "usingSpringWithDamping": the springiness of the bouncing animation.
        The higher the value, the less it'll spring back */
        UIView.animateWithDuration(0.3, delay: 0, usingSpringWithDamping: 0.7, initialSpringVelocity: 0.5, options: nil,
            animations: {
                //set the destination
                self.containerView.center.y = self.rootViewController.view.center.y + self.viewHeight!
            },
            completion: { finished in
                self.view.removeFromSuperview()
        })
    }
    
}