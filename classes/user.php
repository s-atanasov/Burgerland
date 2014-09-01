<?php
class User{

    private $_db;

    function __construct($db){
    
    	$this->_db = $db;
    }

    private function get_user_pass($username){	

        try {
            $stmt = $this->_db->prepare('SELECT password FROM users WHERE username = :username ');
            $stmt->execute(array('username' => $username));

            $row = $stmt->fetch();
            return $row['password'];

        } catch(PDOException $e) {
            echo '<p>'.$e->getMessage().'</p>';
        }
    }
    
    function get_user_name($userID){	

        try {
            $stmt = $this->_db->prepare('SELECT username FROM users WHERE user_id = :userID ');
            $stmt->execute(array('userID' => $userID));

            $row = $stmt->fetch();
            return $row['username'];

        } catch(PDOException $e) {
            echo '<p>'.$e->getMessage().'</p>';
        }
    }
    
    
    
    private function get_user_info($username, $password){	

        try {
            $stmt = $this->_db->prepare('SELECT * FROM users WHERE username = :username AND password = :password ');
            $stmt->execute(array('username' => $username, 'password' => md5($password)));
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row;

        } catch(PDOException $e) {
            echo '<p>'.$e->getMessage().'</p>';
        }
    }

    public function login($username,$password){

        $hashed = $this->get_user_pass($username);

        if(md5($password) == $hashed){
            
            $us = $this->get_user_info($username, $password);
            
            if($us['access'] == 2){
                $_SESSION['userAdmin'] = true;
            }
            
            $_SESSION['loggedin'] = true;
            $_SESSION['userInfo'] = $us;
            
            return true;
        } 	
    }
		
    public function logout(){
        session_destroy();
    }

    public function is_logged_in(){
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
            return true;
        }		
    }
	
}