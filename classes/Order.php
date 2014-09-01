<?php

class Order {
    
    private $_dbOrder;
    
    function __construct($db) {
        $this->_dbOrder = $db;
    }
            
    function placeOrder ($userID,$burger,$name,$phone,$city,$address,$price,$ingredients = null){
        
        $date = date("Y-m-d H:i:s");
        $status = '1';
        
        try {
            $stmt = $this->_dbOrder->prepare('INSERT INTO orders (user_id,burger,name,phone,city,address,price,date,status) VALUES (:userID,:burger,:name,:phone,:city,:address,:price,:date,:status) ');
            $stmt->execute(array('userID' => $userID, 'burger' => $burger, 'name' => $name, 'phone' => $phone, 'city' => $city, 'address' => $address, 'price' => $price, 'date' => $date, 'status' => $status));
            
            $id = $this->_dbOrder->lastInsertId();
            
            try{
                
                if(is_array($ingredients) && $ingredients != null){
                    foreach($ingredients as $i){
                        $stmt = $this->_dbOrder->prepare('INSERT INTO ingredients (ingredients_id,order_id) VALUES (:ingredient,:order) ');
                        $stmt->execute(array('ingredient' => $i, 'order' => $id));
                    }
                }
                return true;
                
            }  catch (PDOException $e){
                echo '<p>'.$e->getMessage().'</p>';
            }
            
            

        } catch(PDOException $e) {
            echo '<p>'.$e->getMessage().'</p>';
        }
        
    }
    
    function getOrderStatus($statusID){
        $statusName = '';
        switch ($statusID){
            case '1':
                $statusName = 'ordered';
                break;
            case '2':
                $statusName = 'in progress';
                break;
            case '3':
                $statusName = 'on the road';
                break;
            case '4':
                $statusName = 'delivered';
                break;
            default :
               $statusName = '';
               break;
        }
        return $statusName;
    }
    
    function getBurgerName($burgerID){
        $burgName = '';
        switch ($burgerID){
            case '1':
                $burgName = 'Chiken burger';
                break;
            case '2':
                $burgName = 'Pork burger';
                break;
            default :
               $burgName = '';
               break;
        }
        return $burgName;
    }
    
    function getBurgerPrice($burgerID){
        $burgPrice = 0.00;
        switch ($burgerID){
            case '1':
                $burgPrice = 2.50;
                break;
            case '2':
                $burgPrice = 3.50;
                break;
            default :
               $burgPrice = 0.00;
               break;
        }
        return $burgPrice;
    }
    
    function getOrderPrice($burgerID,$ingredients){
        
        $price = $this->getBurgerPrice($burgerID);
        
        
        
        if(is_array($ingredients) && $ingredients != NULL && !empty($ingredients)){
            foreach ($ingredients as $v) {
                $price = $price + 0.50;
            }
        }
        
        return $price;
        
    }
    
    function getUserOrders($userID){
        
        try {
            
            $stmt = $this->_dbOrder->prepare('SELECT * FROM orders WHERE user_id = :userID ');
            $stmt->execute(array('userID' => $userID));
            

            $res = array();
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $res[] = $row;
            }

            return $res;

        } catch(PDOException $e) {
            echo '<p>'.$e->getMessage().'</p>';
        }
        
    }
    
    function getOrderIngredients($orderID){
        
        try {
            
            $stmt = $this->_dbOrder->prepare('SELECT * FROM ingredients WHERE order_id = :orderID ');
            $stmt->execute(array('orderID' => $orderID));
            

            $res = array();
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $res[] = $row;
            }
            
            if($res){
                $names = array();
                foreach ($res as $val) {
                   $names[] = $this->getIngredientsName($val['ingredients_id']);
                }
                return implode(', ', $names);
            }else{
                return 'None';
            }

            

        } catch(PDOException $e) {
            echo '<p>'.$e->getMessage().'</p>';
        }
        
    }
    
    private function getIngredientsName($ingredID){
        $name = '';
        switch ($ingredID) {
            case '1':
                $name = 'Egg';
                break;
            case '2':
                $name = 'Cheese';
                break;
            case '3':
                $name = 'Potatoes';
                break;
            default:
                $name = '';
                break;
        }
        
        return $name;
    }
    
    function getAllOrders(){
        try {
            
            $stmt = $this->_dbOrder->prepare('SELECT * FROM orders');
            $stmt->execute();

            $res = array();
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $res[] = $row;
            }

            return $res;

        } catch(PDOException $e) {
            echo '<p>'.$e->getMessage().'</p>';
        }
    }
    
    function getOrder($orderID){
        try {
            
            $stmt = $this->_dbOrder->prepare('SELECT * FROM orders WHERE order_id = :orderID ');
            $stmt->execute(array('orderID' => $orderID));

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $row;

        } catch(PDOException $e) {
            echo '<p>'.$e->getMessage().'</p>';
        }
    }
    
    function getOrdersByStatus($statusID){
        try {
            
            $stmt = $this->_dbOrder->prepare('SELECT * FROM orders WHERE status = :status ');
            $stmt->execute(array('status' => $statusID));

            $res = array();
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $res[] = $row;
            }

            return $res;

        } catch(PDOException $e) {
            echo '<p>'.$e->getMessage().'</p>';
        }
    }
    
    function updateStatus($orderID,$status){
        
        try {
            
            
            $stmt = $this->_dbOrder->prepare('UPDATE orders SET status = :status WHERE order_id = :orderID ');
            $stmt->execute(array( 'status' => $status, 'orderID' => $orderID));

            return true;

        } catch(PDOException $e) {
            echo '<p>'.$e->getMessage().'</p>';
        }
        
    }
    
}

