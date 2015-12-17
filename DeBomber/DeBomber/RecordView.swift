//
//  RecordView.swift
//  DeBomber
//
//  Created by Kage on 4/2/15.
//
//

import UIKit

/*
protocol RecordViewDelegate{
    
    func replayBackgroundMusic(controller: RecordView)
}
*/
class RecordView: UIViewController {

    @IBOutlet weak var image_view1: UIImageView!
    @IBOutlet weak var image_view2: UIImageView!
    @IBOutlet weak var backButton: UIButton!
    
    //var delegate:RecordViewDelegate? = nil
    
    override func viewDidLoad() {
        super.viewDidLoad()
        
        view.backgroundColor = UIColor(patternImage: UIImage(named: "background.png")!)

        var record_first = ["",""]
        var record_second = ["",""]
        var record_third = ["",""]
        
        var record = ["","",""]
        var time = ["","",""]
        
        var userDefaults = NSUserDefaults.standardUserDefaults()
        
        //read record
        if var array : AnyObject = userDefaults.objectForKey("record_survival_first") {
            record[0] = array[0] as String
            time[0] = array[1] as String
        }
        if var array : AnyObject = userDefaults.objectForKey("record_survival_second") {
            record[1] = array[0] as String
            time[1] = array[1] as String
        }
        if var array : AnyObject = userDefaults.objectForKey("record_survival_third") {
            record[2] = array[0] as String
            time[2] = array[1] as String
        }

        
        let ranking1_image = UIImage(named:"record1.png" )
        var new_img = drawText(ranking1_image!, point1: record[0], time1:time[0],
                                                point2: record[1], time2:time[1],
                                                point3: record[2], time3:time[2])
        image_view1.image = new_img
        
        record = ["","",""]
        time = ["","",""]
        
        if var array : AnyObject = userDefaults.objectForKey("record_mission_first") {
            record[0] = array[0] as String
            time[0] = array[1] as String
        }
        if var array : AnyObject = userDefaults.objectForKey("record_mission_second") {
            record[1] = array[0] as String
            time[1] = array[1] as String
        }
        if var array : AnyObject = userDefaults.objectForKey("record_mission_third") {
            record[2] = array[0] as String
            time[2] = array[1] as String
        }
        
        
        let ranking2_image = UIImage(named:"record2.png" )
        new_img = drawText(ranking2_image!, point1: record[0], time1:time[0],
            point2: record[1], time2:time[1],
            point3: record[2], time3:time[2])
        image_view2.image = new_img

    }
    
    
    func drawText(image :UIImage, point1:String, time1:String, point2:String, time2:String, point3:String, time3:String) ->UIImage
    {
        UIGraphicsBeginImageContext(image.size);
        
        //draw 1st image
        let imageRect = CGRectMake(0,0,image.size.width,image.size.height)
        image.drawInRect(imageRect)
        
        //draw 2nd image(text part)
        var textRect  = CGRectMake(120, 45, image.size.width/2, image.size.height/3)
        var font = UIFont.boldSystemFontOfSize(85)
        
        var textFontAttributes = [
            NSFontAttributeName: font,
            NSForegroundColorAttributeName: UIColor.blackColor()
            
            /*,NSStrokeColorAttributeName: UIColor.blackColor(),
            NSStrokeWidthAttributeName: 7.0*/
        ]
        point1.drawInRect(textRect, withAttributes: textFontAttributes)
        
        //draw 3rd image(text part)
        textRect  = CGRectMake(320, 75, image.size.width/2, image.size.height/3)
        font = UIFont.boldSystemFontOfSize(40)
        
        textFontAttributes = [
            NSFontAttributeName: font,
            NSForegroundColorAttributeName: UIColor.lightGrayColor(),
        ]
        time1.drawInRect(textRect, withAttributes: textFontAttributes)
        
        //draw 4th image(text part)
        textRect  = CGRectMake(120, 125, image.size.width/2, image.size.height/3)
        font = UIFont.boldSystemFontOfSize(85)
        
        textFontAttributes = [
            NSFontAttributeName: font,
            NSForegroundColorAttributeName: UIColor.blackColor(),
        ]
        point2.drawInRect(textRect, withAttributes: textFontAttributes)
        
        //draw 5th image(text part)
        textRect  = CGRectMake(320, 155, image.size.width/2, image.size.height/3)
        font = UIFont.boldSystemFontOfSize(40)
        
        textFontAttributes = [
            NSFontAttributeName: font,
            NSForegroundColorAttributeName: UIColor.lightGrayColor(),
        ]
        time2.drawInRect(textRect, withAttributes: textFontAttributes)
        
        //draw 6th image(text part)
        textRect  = CGRectMake(120, 205, image.size.width/2, image.size.height/3)
        font = UIFont.boldSystemFontOfSize(85)
        
        textFontAttributes = [
            NSFontAttributeName: font,
            NSForegroundColorAttributeName: UIColor.blackColor(),
        ]
        point3.drawInRect(textRect, withAttributes: textFontAttributes)
        
        //draw 7th image(text part)
        textRect  = CGRectMake(320, 235, image.size.width/2, image.size.height/3)
        font = UIFont.boldSystemFontOfSize(40)
        
        textFontAttributes = [
            NSFontAttributeName: font,
            NSForegroundColorAttributeName: UIColor.lightGrayColor(),
        ]
        time3.drawInRect(textRect, withAttributes: textFontAttributes)

        
        //get the screen shot for current image context
        let newImage = UIGraphicsGetImageFromCurrentImageContext();
        
        UIGraphicsEndImageContext()
        
        return newImage
    }


    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    @IBAction func backButtonPressed(){
        self.dismissViewControllerAnimated(true, completion: nil)
       
        /*
        if (self.delegate != nil){
            self.delegate!.replayBackgroundMusic(self)
        }
        */

    }
}
