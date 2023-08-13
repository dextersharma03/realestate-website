<?php

class UserDAO   {

    //Store the PDO agent here.
    private static $_db;

    static function init()  {
        //Initialize the internal PDO Agent
        self::$_db = new PDOService('User');
    }
    //create User
    static function createUser(User $newUser) {

        //Create means INSERT
        $sql="INSERT INTO User (FirstName,LastName,Email,Username,Password)
        VALUES (:firstname,:lastname,:email,:username,:password);";

        //QUERY BIND EXECUTE RETURN
        self::$_db->query($sql);
        self::$_db->bind(":firstname",$newUser->getFirstName());
        self::$_db->bind(":lastname",$newUser->getLastName());
        self::$_db->bind(":email",$newUser->getEmail());
        self::$_db->bind(":username",$newUser->getUsername());
        self::$_db->bind(":password",$newUser->getPassword());
        self::$_db->execute();
        
        return self::$_db->lastInsertedId();
      

    }
    //Get the user
    static function getUser(string $userName)  {
        $sql = "SELECT * FROM User
        where Username = :userName;";

        //QUERY!!
        self::$_db->query($sql);
        //BIND
        self::$_db->bind(":userName",$userName);
        //EXECUTE!!
        self::$_db->execute();
        //RETURN
        return self::$_db->singleResult();

    }
    //Get all User users
    static function getUsers()  {
        $sql = "SELECT * FROM User;";

        //QUERY!!
        self::$_db->query($sql);
        //BIND BUT THERE ARE NONE
        //EXECUTE!!
        self::$_db->execute();
        //RETURN
        return self::$_db->resultSet();

    }
    //Update a User
    static function updateUser (User $UserToUpdate) {
        //update means UPDATE query
    $sql = "UPDATE User SET FirstName=:firstname,LastName=:lastname,Email=:email,Username=:username,Password=:password
            WHERE UserID=:Userid;";
        
    self::$_db->query($sql);
    self::$_db->bind(":firstname",$UserToUpdate->getFirstName());
    self::$_db->bind(":lastname",$UserToUpdate->getLastName());
    self::$_db->bind(":email",$UserToUpdate->getEmail());
    self::$_db->bind(":username",$UserToUpdate->getUsername());
    self::$_db->bind(":password",$UserToUpdate->getPassword());
    self::$_db->bind(":Userid",$UserToUpdate->getUserID());
    self::$_db->execute();
    return self::$_db->rowCount();


    //QUERY BIND EXECUTE RETURN THE RESULTS


}
//Delete a User
static function deleteUser(int $UserID) {


    $sql="DELETE FROM User WHERE UserID=:Userid;";
    self::$_db->query($sql);
    self::$_db->bind(":Userid",$UserID);
    self::$_db->execute();
    return self::$_db->rowCount();
   

}
    
    
}