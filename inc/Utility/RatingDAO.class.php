<?php

class RatingDAO  {

    //Hold the $_db in a variable.
    private static $_db;

    static function initialize()    {
      //Create the PDOService instance locally, be sure to specify the class.
      self::$_db=new PDOService('Rating');
    }
    //Create a new rating
    static function createRating(Rating $newRating) {

        //Create means INSERT
        $sql="INSERT INTO Rating (AgentID, AreaExpertiseID, UserID, Date, Rating, Review)
        VALUES (:Agentid,:AreaExpertiseid,:Userid,:date,:rating,:review);";
        //QUERY BIND EXECUTE RETURN
        self::$_db->query($sql);
        self::$_db->bind(":Agentid",$newRating->getAgentID());
        self::$_db->bind(":AreaExpertiseid",$newRating->getAreaExpertiseID());
        self::$_db->bind(":Userid",$newRating->getUserID());
        self::$_db->bind(":date",$newRating->getDate());
        self::$_db->bind(":rating",$newRating->getRating());
        self::$_db->bind(":review",$newRating->getReview());
        self::$_db->execute();    
        return self::$_db->lastInsertedId();
      

    }
    //Get a particular rating
    static function getRating(int $ratingID)  {

        //Gget means get one
        $sql="SELECT * FROM Rating WHERE RatingID=:ratingid;";

        //QUERY, BIND, EXECUTE, RETURN
        self::$_db->query($sql);
        self::$_db->bind(":ratingid",$ratingID);
        self::$_db->execute();
        return self::$_db->singleResult();
       
    }
    //Get all ratings
    static function getRatings() {

        //No parameters so no bind
        $sql="SELECT * FROM Rating;";
        self::$_db->query($sql);
        
        //Prepare the Query
        //execute the query
        self::$_db->execute();
        //Return results
        return self::$_db->resultSet();
    }
    //Get Reviews for particular Agent
    static function getAgentReviews(Agent $Agent){
        $sql = "SELECT AreaExpertise.AreaExpertiseShortName, User.FirstName, User.LastName, Rating.RatingID, Rating.Date, Rating.AreaExpertiseID, Rating.UserID, Rating.AgentID, Rating.Rating, Rating.Review 
        FROM Agent, Rating, User, AreaExpertise 
        where Rating.AgentID=:Agentid = Agent.AgentID and Rating.AreaExpertiseID = AreaExpertise.AreaExpertiseID and Rating.UserID = User.UserID
         ORDER BY Rating.Date DESC;";
        self::$_db->query($sql);
        self::$_db->bind(":Agentid", $Agent->getAgentID());
        self::$_db->execute();
        return self::$_db->resultSet();
    }
    //Update a rating
    static function updateRating (Rating $ratingToUpdate) {
            //update means UPDATE query
        $sql = "UPDATE Rating SET AgentID = :Agentid,AreaExpertiseID=:AreaExpertiseID, UserID = :UserID,Date = :date, Rating=:rating,Review=:review
                WHERE RatingID=:ratingid;";
            //, FirstName=:firstName,LastName=:lastName
        self::$_db->query($sql);
        
        self::$_db->bind(":Agentid",$ratingToUpdate->getAgentID());
        self::$_db->bind(":rating",$ratingToUpdate->getRating());
        self::$_db->bind(":review",$ratingToUpdate->getReview());
        self::$_db->bind(":AreaExpertiseID",$ratingToUpdate->getAreaExpertiseID());
        self::$_db->bind(":UserID",$ratingToUpdate->getUserID());
        self::$_db->bind(":date",$ratingToUpdate->getDate());
        self::$_db->bind(":ratingid",$ratingToUpdate->getRatingID());
        // self::$_db->bind(":firstName",$ratingToUpdate->getFirstName());
        // self::$_db->bind(":lastName",$ratingToUpdate->getLastName());

        self::$_db->execute();
       // return self::$_db->rowCount();
        return self::$_db->lastInsertedId();


        //QUERY BIND EXECUTE RETURN THE RESULTS


    }
    //Delete rating
    static function deleteRating(int $ratingID) {


        $sql="DELETE FROM Rating WHERE RatingID=:ratingid;";
        self::$_db->query($sql);
        self::$_db->bind(":ratingid",$ratingID);
        self::$_db->execute();
        return self::$_db->rowCount();
       

    }
   

}


?>