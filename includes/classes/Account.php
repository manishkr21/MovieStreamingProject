<?php

// require_once("includes/classes/Constants.php");
class Account{
    
    private $connection;
    private $errorArray = array();
    private $query;

    public function __construct($connection){
        $this->connection = $connection;
    }

    public function register($fn, $ln, $un,$em, $em2, $pw, $pw2){
        $this->validateFirstName($fn);
        $this->validateLastName($ln);
        $this->validateUsername($un);
        $this->validateEmails($em,$em2);
        $this->validatePasswords($pw,$pw2);

        if(empty($this->errorArray)){
            return $this->insertUserDetails($fn, $ln, $un, $em, $pw);
        }

        return false;
    }

    
    public function login($un, $pw){
        $pw = hash("sha512", $pw);
        
        $query = $this->connection->prepare("SELECT * FROM users WHERE username=:un AND password=:pw");
        $query->bindValue(":un",$un);
        $query->bindValue(":pw",$pw);

        $query->execute();

        if($query->rowCount() == 1){
            return true;
        }

        array_push($this->errorArray, Constants::$loginFailed);
        return false;


    }


    private function insertUserDetails($fn, $ln, $un, $em, $pw){
        $pw = hash("sha512", $pw);

        $query = $this->connection->prepare("INSERT INTO users (firstName, lastName, username, email, password) VALUES (:fn, :ln, :un, :em, :pw)");
        $query->bindValue(":fn", $fn);
        $query-> bindValue(":ln",$ln);

        $query-> bindValue(":un",$un);

        $query-> bindValue(":em",$em);

        $query-> bindValue(":pw",$pw);

        // var_dump($query->errorInfo());  will dump the error info at screen
        return $query->execute();  // query return true of false based on succesful execution of query true if success

    }

    private function validateFirstName($fn){  // you can not call pruavte funtion with directly $account->funtionname
        if(strlen($fn) < 2 || strlen($fn) > 25){
            array_push($this->errorArray, Constants::$firstNameCharacters);
        }
    }

    private function validateLastName($ln){
        if(strlen($ln) < 2 || strlen($ln) > 25){
            array_push($this->errorArray, Constants::$lastNameCharacters);
        }
    }

    private function validateUsername($un){
        if(strlen($un) < 2 || strlen($un) > 25){
            array_push($this->errorArray, Constants::$usernameCharacters);
            return;
        }

        $query = $this->connection->prepare("SELECT * FROM users WHERE username=:un");
        $query->bindValue(":un",$un);

        $query->execute();

        if($query->rowCount() != 0){
            array_push($this->errorArray, Constants::$usernameTaken);
        }
    }

    private function validateEmails($em, $em2){
        if($em != $em2){
            array_push($this->errorArray, Constants::$emailsDontMatch);
            return;
        }

        if(!filter_var($em, FILTER_VALIDATE_EMAIL)){
            array_push($this->errorArray, Constants::$Invalidemail);
        }

        $query = $this->connection->prepare("SELECT * FROM users WHERE email=:em");
        $query->bindValue(":em",$em);

        $query->execute();

        if($query->rowCount() != 0){
            array_push($this->errorArray, Constants::$emailTaken);
        }

    }

    private function validatePasswords($pw, $pw2){

        if($pw != $pw2){
            array_push($this->errorArray, Constants::$passwordDontMatch);
            return;
        }
        if(strlen($pw) < 5 || strlen($pw) > 25){
            array_push($this->errorArray, Constants::$passwordLength);
        }

    }

    public function getError($error){
        if(in_array($error, $this->errorArray)){
            return "<span class='errorMessage'>$error</span>";
        }
    }

}

?>