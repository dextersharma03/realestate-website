<?php
/**
 * Developed by:
 * Dikshit Sharma
 * T00706524
 */
//Require files
require_once("inc/config.inc.php");
require_once("inc/Entity/User.class.php");
require_once("inc/Utility/PDOService.class.php");
require_once("inc/Utility/UserDAO.class.php");
require_once("inc/Utility/LoginManager.class.php");
require_once("inc/Utility/Page.class.php");
//Init Userdao
UserDAO::init();
//If post is not empty!
if (!empty($_POST)) {
    // if post is create
if ($_POST["action"] == "create")    {
    //Assemble the Section to Insert
     
    $newUser = new User();
    //Hash the password!
    $storedHash = password_hash($_POST["password"], PASSWORD_DEFAULT);
    //Send the section to the DAO for insertion
    $newUser->setFirstName($_POST["firstname"]);
    $newUser->setLastName($_POST["lastname"]);
    $newUser->setEmail($_POST["email"]);
    $newUser->setUsername($_POST["username"]);
    $newUser->setPassword($storedHash);
    //Send the section to the DAO to be created
    UserDAO::createUser($newUser);

    header('Location: http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) .'/realestate-login.php');

    }
}
Page::header();
Page::showRegistrationForm();
Page::footer();


?>