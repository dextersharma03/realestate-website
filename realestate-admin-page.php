<?php
/**
 * Developed by:
 * Dikshit Sharma
 * T00706524
 */
require_once("inc/config.inc.php");
require_once("inc/Entity/Agent.class.php");
require_once("inc/Entity/Agent_AreaExpertise.class.php");
require_once("inc/Entity/Rating.class.php");
require_once("inc/Entity/AreaExpertise.class.php");
require_once("inc/Entity/User.class.php");
require_once("inc/Utility/PDOService.class.php");
require_once("inc/Utility/AgentDAO.class.php");
require_once("inc/Utility/Agent_AreaExpertiseDAO.class.php");
require_once("inc/Utility/AreaExpertiseDAO.class.php");
require_once("inc/Utility/RatingDAO.class.php");
require_once("inc/Utility/UserDAO.class.php");
require_once("inc/Utility/LoginManager.class.php");
require_once("inc/Utility/Page.class.php");

//Initialise the DAOs
session_start();
$user=$_SESSION['user'];
//If verify login is true and username is admin - proceed
if(LoginManager::verifyLogin() && $user->getUsername()=="admin")
{

AreaExpertiseDAO::initialize();
AgentDAO::initialize();
UserDAO::init();
RatingDAO::initialize();
Agent_AreaExpertiseDAO::initialize();





if (!empty($_POST)) {
    if ($_POST["action"] == "createic")    {
        //Assemble the Section to Insert
         
        $newIC = new Agent_AreaExpertise();
        //Send the section to the DAO for insertion
        $newIC->setAgentID($_POST["Agentid"]);
        $newIC->setAreaExpertiseID($_POST["AreaExpertiseid"]);
        //Send the section to the DAO to be created
        Agent_AreaExpertiseDAO::createAgent_AreaExpertise($newIC);
        
    }
}

//Create 
if (!empty($_POST)) {
    if ($_POST["action"] == "create")    {
        //Assemble the Section to Insert
         
        $newAreaExpertise = new AreaExpertise();
        //Send the section to the DAO for insertion
        $newAreaExpertise->setAreaExpertiseShortName($_POST["AreaExpertiseshortname"]);
        $newAreaExpertise->setAreaExpertiseLongName($_POST["AreaExpertiselongname"]);
        
        //Send the section to the DAO to be created
        AreaExpertiseDAO::createAreaExpertise($newAreaExpertise);
    }else if ($_POST["action"] == "edit"){
        //Assemble the Section to Insert
         
        $editAreaExpertise = new AreaExpertise();
        //Send the section to the DAO for insertion
        $editAreaExpertise->setAreaExpertiseID($_POST["AreaExpertiseid"]);
        $editAreaExpertise->setAreaExpertiseShortName($_POST["AreaExpertiseshortname"]);
        $editAreaExpertise->setAreaExpertiseLongName($_POST["AreaExpertiselongname"]);
        
        //Send the section to the DAO to be created
        AreaExpertiseDAO::updateAreaExpertise($editAreaExpertise);

    }

}//If there was a delete that came in via GET
if (isset($_GET["action"]) && $_GET["action"] == "delete")  {
    //Call the DAO and delete the respecitve Section
    AreaExpertiseDAO::deleteAreaExpertise($_GET["id"]);
}

///////////////////////////////////////////////////////
////////////////////Agents////////////////////////
///////////////////////////////////////////////////////

if (!empty($_POST)) {
    if ($_POST["action"] == "createAgent")    {
        //Assemble the Section to Insert
         
        $newAgent = new Agent();
        //Send the section to the DAO for insertion

        $newAgent->setFirstName($_POST["Agentfirstname"]);
        $newAgent->setLastName($_POST["Agentlastname"]);
        $newAgent->setEmail($_POST["Agentemail"]);
        
        //Send the section to the DAO to be created
        AgentDAO::createAgent($newAgent);
    }else if ($_POST["action"] == "editAgent"){
        //Assemble the Section to Insert
         
        $newAgent = new Agent();
        //Send the section to the DAO for insertion
        $newAgent->setFirstName($_POST["Agentfirstname"]);
        $newAgent->setLastName($_POST["Agentlastname"]);
        $newAgent->setEmail($_POST["Agentemail"]);
        $newAgent->setAgentID($_POST["Agentid"]);
        
        //Send the section to the DAO to be created
        AgentDAO::updateAgent($newAgent);

    }
}
if (isset($_GET["action"]) && $_GET["action"] == "deleteAgent")  {
    //Call the DAO and delete the respecitve Section
    AgentDAO::deleteAgent($_GET["id"]);
}
if (isset($_GET["action"]) && $_GET["action"] == "deleteUser")  {
    //Call the DAO and delete the respecitve Section
    UserDAO::deleteUser($_GET["id"]);
}

//show
Page::headerForAdminCRUD();
Page::listAreaExpertises(AreaExpertiseDAO::getAreaExpertises());
//If someone clicked Edit
if (isset($_GET["action"]) && $_GET["action"] == "edit")  {
    //Pull the section to Edit from the DAO
    $AreaExpertiseToEdit = AreaExpertiseDAO::getAreaExpertise($_GET["id"]);
    
    //Render the  Edit Section form with the section to edit and  alist of the AreaExpertises.
    Page::editAreaExpertiseForm($AreaExpertiseToEdit);
}

Page::createAreaExpertiseForm();
Page::listAgents(AgentDAO::getAgents());
if (isset($_GET["action"]) && $_GET["action"] == "editAgent")  {
    //Pull the section to Edit from the DAO
    $AgentToEdit = AgentDAO::getAgent($_GET["id"]);
    
    //Render the  Edit Section form with the section to edit and  alist of the AreaExpertises.
    Page::editAgentForm($AgentToEdit,AreaExpertiseDAO::getAreaExpertises());
}   
//Create all pages pages functions
Page::createAgentForm(AreaExpertiseDAO::getAreaExpertises());
Page::listAgentAreaExpertises(Agent_AreaExpertiseDAO::getAgent_AreaExpertises());
Page::createAgentAreaExpertise(AgentDAO::getAgents(),AreaExpertiseDAO::getAreaExpertises());

Page::listUsers(UserDAO::getUsers());
Page::footerForAdminCRUD();
}else
{
    //Destroy a session if session authentication failed
    session_destroy();
    header("Location: realestate-login.php");
}


?>