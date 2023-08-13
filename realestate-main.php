<?php
/**
 * Developed by:
 * Dikshit Sharma
 * T00706524
 */
require_once("inc/config.inc.php");
require_once("inc/Entity/Agent.class.php");
require_once("inc/Entity/Rating.class.php");
require_once("inc/Entity/AreaExpertise.class.php");
require_once("inc/Entity/User.class.php");
require_once("inc/Utility/LoginManager.class.php");
require_once("inc/Utility/RestClient.class.php");
require_once("inc/Utility/Page.class.php");

session_start();
//Verify Login
LoginManager::verifyLogin();
//show header
Page::headerForAgent();
//Get all Agent fullnames from database for autofill
$getDataForAutoFill = RestClient::call("GET");
Page::searchFormAgent($getDataForAutoFill);
$User = $_SESSION["user"];
//If get request is not empty
if (!empty($_GET)) {
    //If action is search for Agent
    if (isset($_GET["action"]) && $_GET["action"] == "searchButton")    {
        //Get fullname
        $fullName = $_GET["search"];
        $errors = array();     
        //If all the format matches            
            if(strpos($fullName, ' ') !== false) {    
                //Get serializedAgent, Reviews for Agent, and AreaExpertises for Agent         
                $jInstrucorReviewsAndAreaExpertises = RestClient::call("GET", array('search' => $_GET["search"]));
                //If cannot get anything, show error list that Agent is not found
                if ($jInstrucorReviewsAndAreaExpertises == null){
                    $errors[] = "Cannot Find Agent, Try Again!";
                    Page::showErrorsList($errors);
                } 
                //If Agent is found, proceed
                else {
                $reviews = array();
                $AreaExpertises = array(); 
                //Unserialize an Agent from json
                $Agent = new Agent();
                $Agent->setAgentID($jInstrucorReviewsAndAreaExpertises[2]->AgentID);
                if($jInstrucorReviewsAndAreaExpertises[2]->AreaExpertiseID != null){
                $Agent->setAreaExpertiseID($jInstrucorReviewsAndAreaExpertises[2]->AreaExpertiseID); 
                }
                $Agent->setFirstName($jInstrucorReviewsAndAreaExpertises[2]->FirstName); 
                $Agent->setLastName($jInstrucorReviewsAndAreaExpertises[2]->LastName); 
                $Agent->setEmail($jInstrucorReviewsAndAreaExpertises[2]->Email);
                //Unserialize reviews for Agent              
                foreach ($jInstrucorReviewsAndAreaExpertises[0] as $jInstrucorReviewAndAreaExpertise){
                        $rating = new Rating();
                        $rating->setRatingID($jInstrucorReviewAndAreaExpertise->RatingID)  ;              
                        $rating->setAgentID($jInstrucorReviewAndAreaExpertise->AgentID);
                        $rating->setAreaExpertiseID($jInstrucorReviewAndAreaExpertise->AreaExpertiseID);
                        $rating->setUserID($jInstrucorReviewAndAreaExpertise->UserID);
                        $rating->setDate($jInstrucorReviewAndAreaExpertise->Date);
                        $rating->setReview($jInstrucorReviewAndAreaExpertise->Review);
                        $rating->setRating($jInstrucorReviewAndAreaExpertise->Rating);
                        $rating->setFirstName($jInstrucorReviewAndAreaExpertise->FirstName);
                        $rating->setLastName($jInstrucorReviewAndAreaExpertise->LastName);  
                        $rating->setAreaExpertiseShortName($jInstrucorReviewAndAreaExpertise->AreaExpertiseShortName);               
                        $reviews[] = $rating;                    
                }         
                //Unserialize AreaExpertises for Agent    
                foreach($jInstrucorReviewsAndAreaExpertises[1] as $jInstrucorReviewAndAreaExpertise){
                    $AreaExpertise = new AreaExpertise();
                    $AreaExpertise->setAreaExpertiseID($jInstrucorReviewAndAreaExpertise->AreaExpertiseID);
                    $AreaExpertise->setAreaExpertiseShortName($jInstrucorReviewAndAreaExpertise->AreaExpertiseShortName);
                    $AreaExpertise->setAreaExpertiseLongName($jInstrucorReviewAndAreaExpertise->AreaExpertiseLongName);
                    $AreaExpertises[] = $AreaExpertise;                    
                }  
                //Calculate average for Agent                                   
                $totalRating = 0;                            
                    foreach ($reviews as $review){         
                        $totalRating += $review->getRating(); 
                    }
                    $averageForAgent = 0; 
                    //If reviews for Agent is not zero, proceed. Its done to eliminate errors by dividing on zero.      
                    if (sizeof($reviews) != 0){
                        $averageForAgent = $totalRating / sizeof($reviews); 
                    }              
                    Page::reviewsSection($reviews, $averageForAgent, $Agent);
                    Page::ratingsForm($AreaExpertises, $Agent); 
                }
                                            
            }
            //If the format is not a match, show an error!
            else {  
                $errors[] = "Cannot Find Agent, Please try again!"; 
                Page::showErrorsList($errors);                            
           }
         }
    }

    //If post is not empty
    if (!empty($_POST)){
        //If ratings button is clicked
        if (isset($_POST["action"]) && $_POST["action"] == "ratingsButton"){  
            //Get current date and set it to a newly created rating
            $date = date("Y/m/d")  ;
            $postData = array(
                "AgentID" => $_POST["Agentid"],
                "AreaExpertiseID" => $_POST["AreaExpertiseNumber"],
                "Rating" => $_POST["ratingNumber"],
                "Review" => $_POST["experience"],
                "UserID" => $User->getUserID(),
                "Date" => $date
            );  
            //Create a new rating based on the postdata       
            RestClient::call("POST", $postData);
            //Show all the ratings for the Agent with newly created rating
            $AgentName = $_POST['firstname']." ".$_POST['lastname'];
            $jInstrucorReviewsAndAreaExpertises = RestClient::call("GET", array('search' => $AgentName));         
            $reviews = array();
            $AreaExpertises = array(); 
            $Agent = new Agent();
            $Agent->setAgentID($jInstrucorReviewsAndAreaExpertises[2]->AgentID);
            if($jInstrucorReviewsAndAreaExpertises[2]->AreaExpertiseID != null){
                $Agent->setAreaExpertiseID($jInstrucorReviewsAndAreaExpertises[2]->AreaExpertiseID); 
            }
            $Agent->setFirstName($jInstrucorReviewsAndAreaExpertises[2]->FirstName); 
            $Agent->setLastName($jInstrucorReviewsAndAreaExpertises[2]->LastName); 
            $Agent->setEmail($jInstrucorReviewsAndAreaExpertises[2]->Email);              
            foreach ($jInstrucorReviewsAndAreaExpertises[0] as $jInstrucorReviewAndAreaExpertise){
                    $rating = new Rating();
                    $rating->setRatingID($jInstrucorReviewAndAreaExpertise->RatingID)  ;              
                    $rating->setAgentID($jInstrucorReviewAndAreaExpertise->AgentID);
                    $rating->setAreaExpertiseID($jInstrucorReviewAndAreaExpertise->AreaExpertiseID);
                    $rating->setUserID($jInstrucorReviewAndAreaExpertise->UserID);
                    $rating->setDate($jInstrucorReviewAndAreaExpertise->Date);
                    $rating->setReview($jInstrucorReviewAndAreaExpertise->Review);
                    $rating->setRating($jInstrucorReviewAndAreaExpertise->Rating);
                    $rating->setFirstName($jInstrucorReviewAndAreaExpertise->FirstName);
                    $rating->setLastName($jInstrucorReviewAndAreaExpertise->LastName);  
                    $rating->setAreaExpertiseShortName($jInstrucorReviewAndAreaExpertise->AreaExpertiseShortName);               
                    $reviews[] = $rating;                    
            }             
            foreach($jInstrucorReviewsAndAreaExpertises[1] as $jInstrucorReviewAndAreaExpertise){
                $AreaExpertise = new AreaExpertise();
                $AreaExpertise->setAreaExpertiseID($jInstrucorReviewAndAreaExpertise->AreaExpertiseID);
                $AreaExpertise->setAreaExpertiseShortName($jInstrucorReviewAndAreaExpertise->AreaExpertiseShortName);
                $AreaExpertise->setAreaExpertiseLongName($jInstrucorReviewAndAreaExpertise->AreaExpertiseLongName);
                $AreaExpertises[] = $AreaExpertise;                    
            }                                     
            $totalRating = 0;                            
                foreach ($reviews as $review){         
                    $totalRating += $review->getRating(); 
                }
                $averageForAgent = 0;       
                    if (sizeof($reviews) != 0){
                        $averageForAgent = $totalRating / sizeof($reviews); 
                }                       
                Page::reviewsSection($reviews, $averageForAgent, $Agent);
                Page::ratingsForm($AreaExpertises, $Agent);
            
        }
    
    //If edit button is clicked, edit the rating!
    else if (isset($_POST["action"]) && $_POST["action"] == "ratingsEditButton"){
        $date = date("Y/m/d")  ;
            $postData = array(
                "AgentID" => $_POST["Agentid"],
                "AreaExpertiseID" => $_POST["AreaExpertiseNumber"],
                "Rating" => $_POST["ratingNumber"],
                "Review" => $_POST["experience"],
                "UserID" => $User->getUserID(),
                "RatingID" => $_POST["ratingID"],
                "Date" => $date
            );     
            //Update it based on post data!    
            RestClient::call("PUT", $postData);
            //Show updated rating!
            $AgentName = $_POST['firstname']." ".$_POST['lastname'];
            $jInstrucorReviewsAndAreaExpertises = RestClient::call("GET", array('search' => $AgentName));         
            $reviews = array();
            $AreaExpertises = array(); 
            $Agent = new Agent();
            $Agent->setAgentID($jInstrucorReviewsAndAreaExpertises[2]->AgentID);
            if($jInstrucorReviewsAndAreaExpertises[2]->AreaExpertiseID != null){
                $Agent->setAreaExpertiseID($jInstrucorReviewsAndAreaExpertises[2]->AreaExpertiseID); 
            }
            $Agent->setFirstName($jInstrucorReviewsAndAreaExpertises[2]->FirstName); 
            $Agent->setLastName($jInstrucorReviewsAndAreaExpertises[2]->LastName); 
            $Agent->setEmail($jInstrucorReviewsAndAreaExpertises[2]->Email);              
            foreach ($jInstrucorReviewsAndAreaExpertises[0] as $jInstrucorReviewAndAreaExpertise){
                    $rating = new Rating();
                    $rating->setRatingID($jInstrucorReviewAndAreaExpertise->RatingID)  ;              
                    $rating->setAgentID($jInstrucorReviewAndAreaExpertise->AgentID);
                    $rating->setAreaExpertiseID($jInstrucorReviewAndAreaExpertise->AreaExpertiseID);
                    $rating->setUserID($jInstrucorReviewAndAreaExpertise->UserID);
                    $rating->setDate($jInstrucorReviewAndAreaExpertise->Date);
                    $rating->setReview($jInstrucorReviewAndAreaExpertise->Review);
                    $rating->setRating($jInstrucorReviewAndAreaExpertise->Rating);
                    $rating->setFirstName($jInstrucorReviewAndAreaExpertise->FirstName);
                    $rating->setLastName($jInstrucorReviewAndAreaExpertise->LastName);  
                    $rating->setAreaExpertiseShortName($jInstrucorReviewAndAreaExpertise->AreaExpertiseShortName);               
                    $reviews[] = $rating;                    
            }             
            foreach($jInstrucorReviewsAndAreaExpertises[1] as $jInstrucorReviewAndAreaExpertise){
                $AreaExpertise = new AreaExpertise();
                $AreaExpertise->setAreaExpertiseID($jInstrucorReviewAndAreaExpertise->AreaExpertiseID);
                $AreaExpertise->setAreaExpertiseShortName($jInstrucorReviewAndAreaExpertise->AreaExpertiseShortName);
                $AreaExpertise->setAreaExpertiseLongName($jInstrucorReviewAndAreaExpertise->AreaExpertiseLongName);
                $AreaExpertises[] = $AreaExpertise;                    
            }                                     
            $totalRating = 0;                            
                foreach ($reviews as $review){         
                    $totalRating += $review->getRating(); 
                }
                $averageForAgent = 0;       
                    if (sizeof($reviews) != 0){
                        $averageForAgent = $totalRating / sizeof($reviews); 
                }                                  
                Page::reviewsSection($reviews, $averageForAgent, $Agent);
                Page::ratingsForm($AreaExpertises, $Agent);
    
    }
}else if(empty($_GET)){
    Page::allAgentsSection($getDataForAutoFill);
}

//when the delete button is clicked in panel
if (isset($_GET["action"]) && $_GET["action"] == "deleteButton"){    
    //Call Restclient to delete a rating! 
    RestClient::call("DELETE", array('id' => $_GET['id']));
    //Show all the ratings once again!
    $AgentName = $_GET['firstname']." ".$_GET['lastname'];
            $jInstrucorReviewsAndAreaExpertises = RestClient::call("GET", array('search' => $AgentName));         
            $reviews = array();
            $AreaExpertises = array(); 
            $Agent = new Agent();
            $Agent->setAgentID($jInstrucorReviewsAndAreaExpertises[2]->AgentID);
            if($jInstrucorReviewsAndAreaExpertises[2]->AreaExpertiseID != null){
                $Agent->setAreaExpertiseID($jInstrucorReviewsAndAreaExpertises[2]->AreaExpertiseID); 
            }
            $Agent->setFirstName($jInstrucorReviewsAndAreaExpertises[2]->FirstName); 
            $Agent->setLastName($jInstrucorReviewsAndAreaExpertises[2]->LastName); 
            $Agent->setEmail($jInstrucorReviewsAndAreaExpertises[2]->Email);              
            foreach ($jInstrucorReviewsAndAreaExpertises[0] as $jInstrucorReviewAndAreaExpertise){
                    $rating = new Rating();
                    $rating->setRatingID($jInstrucorReviewAndAreaExpertise->RatingID)  ;              
                    $rating->setAgentID($jInstrucorReviewAndAreaExpertise->AgentID);
                    $rating->setAreaExpertiseID($jInstrucorReviewAndAreaExpertise->AreaExpertiseID);
                    $rating->setUserID($jInstrucorReviewAndAreaExpertise->UserID);
                    $rating->setDate($jInstrucorReviewAndAreaExpertise->Date);
                    $rating->setReview($jInstrucorReviewAndAreaExpertise->Review);
                    $rating->setRating($jInstrucorReviewAndAreaExpertise->Rating);
                    $rating->setFirstName($jInstrucorReviewAndAreaExpertise->FirstName);
                    $rating->setLastName($jInstrucorReviewAndAreaExpertise->LastName);  
                    $rating->setAreaExpertiseShortName($jInstrucorReviewAndAreaExpertise->AreaExpertiseShortName);               
                    $reviews[] = $rating;                    
            }             
            foreach($jInstrucorReviewsAndAreaExpertises[1] as $jInstrucorReviewAndAreaExpertise){
                $AreaExpertise = new AreaExpertise();
                $AreaExpertise->setAreaExpertiseID($jInstrucorReviewAndAreaExpertise->AreaExpertiseID);
                $AreaExpertise->setAreaExpertiseShortName($jInstrucorReviewAndAreaExpertise->AreaExpertiseShortName);
                $AreaExpertise->setAreaExpertiseLongName($jInstrucorReviewAndAreaExpertise->AreaExpertiseLongName);
                $AreaExpertises[] = $AreaExpertise;                    
            }                                     
            $totalRating = 0;                            
                foreach ($reviews as $review){         
                    $totalRating += $review->getRating(); 
                }
                $averageForAgent = 0;       
                    if (sizeof($reviews) != 0){
                        $averageForAgent = $totalRating / sizeof($reviews); 
                 }  
                                  
                Page::reviewsSection($reviews, $averageForAgent, $Agent);
                Page::ratingsForm($AreaExpertises, $Agent);


}

//when the edit button is clicked in panel
if (isset($_GET["action"]) && $_GET["action"] == "editButton"){  
    //Show the edit form!         
            $AgentName = $_GET['firstname']." ".$_GET['lastname'];
            $jInstrucorReviewsAndAreaExpertises = RestClient::call("GET", array('search' => $AgentName));         
            $reviews = array();
            $AreaExpertises = array(); 
            $Agent = new Agent();
            $Agent->setAgentID($jInstrucorReviewsAndAreaExpertises[2]->AgentID);
            if($jInstrucorReviewsAndAreaExpertises[2]->AreaExpertiseID != null){
                $Agent->setAreaExpertiseID($jInstrucorReviewsAndAreaExpertises[2]->AreaExpertiseID); 
            }
            $Agent->setFirstName($jInstrucorReviewsAndAreaExpertises[2]->FirstName); 
            $Agent->setLastName($jInstrucorReviewsAndAreaExpertises[2]->LastName); 
            $Agent->setEmail($jInstrucorReviewsAndAreaExpertises[2]->Email);  
            $ratingObject = new Rating();            
            foreach ($jInstrucorReviewsAndAreaExpertises[0] as $jInstrucorReviewAndAreaExpertise){
                    $rating = new Rating();
                    $rating->setRatingID($jInstrucorReviewAndAreaExpertise->RatingID); 
                    if($jInstrucorReviewAndAreaExpertise->RatingID == $_GET["id"] ) {
                        $ratingObject->setRatingID($jInstrucorReviewAndAreaExpertise->RatingID);
                    }            
                    $rating->setAgentID($jInstrucorReviewAndAreaExpertise->AgentID);
                    $rating->setAreaExpertiseID($jInstrucorReviewAndAreaExpertise->AreaExpertiseID);
                    $rating->setUserID($jInstrucorReviewAndAreaExpertise->UserID);
                    $rating->setDate($jInstrucorReviewAndAreaExpertise->Date);
                    $rating->setReview($jInstrucorReviewAndAreaExpertise->Review);
                    if($jInstrucorReviewAndAreaExpertise->Review == $_GET["review"] ) {
                        $ratingObject->setReview($jInstrucorReviewAndAreaExpertise->Review);
                    }
                    $rating->setRating($jInstrucorReviewAndAreaExpertise->Rating);
                    if($jInstrucorReviewAndAreaExpertise->Rating == $_GET["rating"] ) {
                        $ratingObject->setRating($jInstrucorReviewAndAreaExpertise->Rating);
                    }
                    $rating->setFirstName($jInstrucorReviewAndAreaExpertise->FirstName);
                    $rating->setLastName($jInstrucorReviewAndAreaExpertise->LastName);  
                    $rating->setAreaExpertiseShortName($jInstrucorReviewAndAreaExpertise->AreaExpertiseShortName);               
                    $reviews[] = $rating;                    
            }             
            foreach($jInstrucorReviewsAndAreaExpertises[1] as $jInstrucorReviewAndAreaExpertise){
                $AreaExpertise = new AreaExpertise();
                $AreaExpertise->setAreaExpertiseID($jInstrucorReviewAndAreaExpertise->AreaExpertiseID);
                $AreaExpertise->setAreaExpertiseShortName($jInstrucorReviewAndAreaExpertise->AreaExpertiseShortName);
                $AreaExpertise->setAreaExpertiseLongName($jInstrucorReviewAndAreaExpertise->AreaExpertiseLongName);
                $AreaExpertises[] = $AreaExpertise;                    
            }                                     
            $totalRating = 0;                            
                foreach ($reviews as $review){         
                    $totalRating += $review->getRating(); 
                }
                $averageForAgent = 0;       
                    if (sizeof($reviews) != 0){
                        $averageForAgent = $totalRating / sizeof($reviews); 
                }  
                                  
                Page::reviewsSection($reviews, $averageForAgent, $Agent);
                Page::editRatingsForm($AreaExpertises, $Agent, $ratingObject);

}

Page::footerforAgent();

?>