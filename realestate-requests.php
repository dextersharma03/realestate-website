<?php
/**
 * Developed by:
 * Dikshit Sharma
 * T00706524
 */

//Require configuration
require_once('inc/config.inc.php');

//Require Entities
require_once('inc/Entity/AreaExpertise.class.php');
require_once('inc/Entity/Agent.class.php');
require_once('inc/Entity/Rating.class.php');
require_once('inc/Entity/User.class.php');

//Require Utillity Classes
require_once('inc/Utility/PDOService.class.php');
require_once('inc/Utility/AreaExpertiseDAO.class.php');
require_once('inc/Utility/AgentDAO.class.php');
require_once('inc/Utility/RatingDAO.class.php');
require_once('inc/Utility/UserDAO.class.php');

/*
Create  - INSERT - POST
Read    - SELECT - GET
Update  - UPDATE - PUT
DELETE  - DELETE - DELETE
*/

//Pull the request data
$requestData = json_decode(file_get_contents('php://input'));


//Do something based on the request
switch ($_SERVER["REQUEST_METHOD"])   {

    case "POST":    
    RatingDAO::initialize();
    //New Rating
//Set values for a new rating
    $rating = new Rating();
    $rating->setAgentID($requestData->AgentID);
    $rating->setAreaExpertiseID($requestData->AreaExpertiseID);
    $rating->setRating($requestData->Rating);
    $rating->setReview($requestData->Review);
    $rating->setUserID($requestData->UserID);
    $rating->setDate($requestData->Date);
      //Create a new rating!
    $result = RatingDAO::createRating($rating);
    header('Content-Type: application/json');
    //Encode the result!
    echo json_encode($result);

    break;

    //If there was a request with an id return that, if not return all of them!
    case "GET":

      
            //If request data is search!
            if (isset($requestData->search)){
                //Get all necessary information for an Agent!
                AgentDAO::initialize();
                $splitFullName = explode(" ", $requestData->search);
                $firstName = $splitFullName[0];
                $lastName = $splitFullName[1];
                $Agent = AgentDAO::getAgentByName($firstName, $lastName);
                RatingDAO::initialize();
                $ratings = RatingDAO::getAgentReviews($Agent);                
                AreaExpertiseDAO::initialize();
                $AreaExpertises = AreaExpertiseDAO::getAgentAreaExpertise($Agent);
            //Walk the users and add them to a serialized array to return.
            $serializedRatings = array();
            $serializedAreaExpertises = array();
            $serializedAgent;
            //Serialize ratings!
            foreach ($ratings as $rating){
                $serializedRatings[] = $rating->jsonSerialize();         
            }
            //Serialize AreaExpertises!
            foreach ($AreaExpertises as $AreaExpertise)    {
                $serializedAreaExpertises[] = $AreaExpertise->jsonSerialize();
            }  
            //Serialize Agent     
            $serializedAgent = $Agent->jsonSerialize();
            //Return the results
            //Set the header
            header('Content-Type: application/json');
            //Return the array with JSON values!
            $myJSON[] = $serializedRatings; 
            $myJSON[] = $serializedAreaExpertises;
            $myJSON[] = $serializedAgent;
            echo json_encode($myJSON);
            } 
            else{
                //Init daos
                AgentDAO::initialize();
                $Agent = AgentDAO::getAgents();
                RatingDAO::initialize();
                AreaExpertiseDAO::initialize();
                $AgentFullName = array();

                foreach($Agent as $Agentr){
                    $ratings[] = RatingDAO::getAgentReviews($Agentr);                
                    $AreaExpertises[] = AreaExpertiseDAO::getAgentAreaExpertise($Agentr);
                    $AgentFullName[] = $Agentr->getFirstName()." ".$Agentr->getLastName();
                }
            $serializedRatings = array();
            $serializedAreaExpertises = array();
            $serialized = array();
            $serializedAgent;
            //Add serialized ratings to an array
            foreach ($ratings as $rating){
                foreach($rating as $ratingg){         
                    $serialized[] = $ratingg->jsonSerialize();         
                }
            }
            //Add serialized AreaExpertises to an array
            foreach ($AreaExpertises as $AreaExpertise)    {
                foreach($AreaExpertise as $AreaExpertisee){
                    $serialized[] = $AreaExpertisee->jsonSerialize();
                }
            }    
            //Add serialized Agents to an array
            foreach ($Agent as $Agentr)    {               
                $serialized[] = $Agentr->jsonSerialize();
            }
           //Add serialized Agent to an array
            $serialized[] = $AgentFullName;

  
            header('Content-Type: application/json');
           //Return serialized array!
            echo json_encode($serialized);
            }                   
    break;
   //If put, its time to update!
    case "PUT":
        RatingDAO::initialize();
        //Update Rating
        $rating = new Rating();
        $rating->setAgentID($requestData->AgentID);
        $rating->setAreaExpertiseID($requestData->AreaExpertiseID);
        $rating->setRating($requestData->Rating);
        $rating->setReview($requestData->Review);
        $rating->setUserID($requestData->UserID);
        $rating->setDate($requestData->Date);
        $rating->setRatingID($requestData->RatingID);      
        //Update the rating!
        $result = RatingDAO::updateRating($rating);
        header('Content-Type: application/json');
        //Encode result!
        echo json_encode($result);

    break;
//If delete, its time to delete!
    case "DELETE":
       
        RatingDAO::initialize();
        //Delete rating!
        $result = RatingDAO::deleteRating($requestData->id);
        //Set the header
        header('Content-Type: application/json');
        //return the confirmation of deletion
        echo json_encode($result);
        

    break; 

    default:
        echo json_encode(array("message"=> "Check HTTP response?"));
    break;
}


?>