<?php

class User {

    //Attributes

    private $UserID ;
    private $FirstName;
    private $LastName;
    private $Email;
    private $Username;
    private $Password;
//setters
    public function setUserID(int $UserID){
        $this->UserID=$UserID;
    }

    public function setFirstName(string $firstName){
        $this->FirstName=$firstName;
    }
    public function setLastName(string $lastName){
        $this->LastName=$lastName;
    }
    public function setEmail(string $email){
        $this->Email=$email;
    }
    public function setUsername(string $username){
        $this->Username=$username;
    }
    public function setPassword(string $password){
        $this->Password=$password;
    }
    
   //getters
   public function getUserID():int{
    return $this->UserID;
    }

    public function getFirstName():string{
        return $this->FirstName;
    }
    public function getLastName():string{
        return $this->LastName;
    }
    public function getEmail():string{
        return $this->Email;
    } 
    public function getUsername():string{
        return $this->Username;
    }
    public function getPassword():string{
        return $this->Password;
    }
    //Verify a User password function
    function verifyPassword(string $passwordToVerify) {
       
        //Return a boolean based on verifying if the password given is correct for the current user
        return password_verify($passwordToVerify,$this->getPassword());     
    }
    //JSON Serialization with std class
    public function jsonSerialize() {
    $obj = new stdClass;
    $obj->UserID = $this->UserID;
    $obj->FirstName = $this->FirstName;
    $obj->LastName = $this->LastName;
    $obj->Email = $this->Email;
    $obj->Username = $this->Username;
    $obj->Password = $this->Password;
    return $obj;
}
}

?>