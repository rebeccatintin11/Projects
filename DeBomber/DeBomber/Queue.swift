//
//  queue.swift
//  DeBomber
//  Original author: Wayne Bishop
// - See more at: http://waynewbishop.com/swift/stacks-queues/#sthash.b29xAvV6.dpuf
//  Created by Ming-Lung Chen on 2015/4/10.
//
//

import Foundation

class QNode<T> {
    var key: T? = nil
    var next: QNode? = nil
}

public class pair {
    var x: Int
    var y: Int
    
    init(special:Int, type:Int) {
        x = special;
        y = type;
    }
    
    func getX()->Int {
        return x;
    }
    
    func getY()->Int {
        return y;
    }
}
public class Queue<T> {
    
    private var top: QNode<T>! = QNode<T>()
    
    //enqueue the specified object
    func enQueue(var key: T) {
        
        //check for the instance
        if (top == nil) {
            top = QNode()
        }
        
        //establish the top node
        if (top.key == nil) {
            top.key = key;
            return
        }
        
        var childToUse: QNode<T> = QNode<T>()
        var current: QNode = top
        
        
        //cycle through the list of items to get to the end.
        while (current.next != nil) {
            current = current.next!
        }
        
        
        //append a new item
        childToUse.key = key;
        current.next = childToUse;
        
    }
    //retrieve items from the top level in O(1) constant time
    
    func deQueue() -> T? {
        
        //determine if the key or instance exists
        let topitem: T? = self.top?.key
        
        if (topitem == nil) {
            return nil
        }
        
        //retrieve and queue the next item
        var queueitem: T? = top.key!
        
        
        //use optional binding
        if let nextitem = top.next {
            top = nextitem
        }
        else {
            top = nil
        }
        
        return queueitem
    }
    //check for the presence of a value
    func isEmpty() -> Bool {
        //determine if the key or instance exist
        if let topitem: T = self.top?.key {
            return false
        }
        else {
            return true
        }
    }
    
    //retrieve the top most item
    func peek() -> T? {
        return top.key!
    }
}


