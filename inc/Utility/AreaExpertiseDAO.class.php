<?php



class AreaExpertiseDAO  {

    //Static DB
    private static $_db;

    //Initialize the AreaExpertiseDAO
    static function initialize()    {
        //Remember to send in the AreaExpertise name
        self::$_db=new PDOService('AreaExpertise');
    }

    //Get all the AreaExpertises
    static function getAreaExpertises() {
        $sql="SELECT * FROM AreaExpertise ;";
       

        //Prepare the Query
        self::$_db->query($sql);

        self::$_db->execute();
        //Return the results
        
        //Return resultSet
        return self::$_db->resultSet();
    }
    //Get all Agent AreaExpertises
    static function getAgentAreaExpertise(Agent $Agent){
        $sql = "SELECT AreaExpertise.AreaExpertiseID, AreaExpertise.AreaExpertiseShortName, AreaExpertise.AreaExpertiseLongName FROM AreaExpertise, Agent_AreaExpertise where Agent_AreaExpertise.AgentID=:Agentid and Agent_AreaExpertise.AreaExpertiseID = AreaExpertise.AreaExpertiseID;";
        self::$_db->query($sql);
        self::$_db->bind(":Agentid", $Agent->getAgentID());
        self::$_db->execute();
        return self::$_db->resultSet();
    }
    //Create a new AreaExpertise
    static function createAreaExpertise(AreaExpertise $newAreaExpertise) {

        //Create means INSERT
        $sql="INSERT INTO AreaExpertise (AreaExpertiseShortName,AreaExpertiseLongName)
        VALUES (:shortname,:longname);";

        //QUERY BIND EXECUTE RETURN
        self::$_db->query($sql);
        
        self::$_db->bind(":shortname",$newAreaExpertise->getAreaExpertiseShortName());
        self::$_db->bind(":longname",$newAreaExpertise->getAreaExpertiseLongName());
       
        self::$_db->execute();
        
        return self::$_db->lastInsertedId();
    }
    //Update a AreaExpertise
    static function updateAreaExpertise (AreaExpertise $AreaExpertiseToUpdate) {
        //update means UPDATE query
    $sql = "UPDATE AreaExpertise SET AreaExpertiseShortName = :AreaExpertiseshortname,AreaExpertiseLongName=:AreaExpertiselongname
            WHERE AreaExpertiseID=:AreaExpertiseid;";
        
    self::$_db->query($sql);
    self::$_db->bind(":AreaExpertiseshortname",$AreaExpertiseToUpdate->getAreaExpertiseShortName());
    self::$_db->bind(":AreaExpertiselongname",$AreaExpertiseToUpdate->getAreaExpertiseLongName());
    self::$_db->bind(":AreaExpertiseid",$AreaExpertiseToUpdate->getAreaExpertiseID());
    self::$_db->execute();
    return self::$_db->rowCount();


    //QUERY BIND EXECUTE RETURN THE RESULTS


}
//Get a AreaExpertise
static function getAreaExpertise(int $AreaExpertiseID)  {

    //Get means get one
    $sql="SELECT * FROM AreaExpertise WHERE AreaExpertiseID=:AreaExpertiseid;";

    //QUERY, BIND, EXECUTE, RETURN
    self::$_db->query($sql);
    self::$_db->bind(":AreaExpertiseid",$AreaExpertiseID);
    self::$_db->execute();
    return self::$_db->singleResult();    
}
//Delete a AreaExpertise
static function deleteAreaExpertise(int $AreaExpertiseID) {


    $sql="DELETE FROM AreaExpertise WHERE AreaExpertiseID=:AreaExpertiseid;";
    self::$_db->query($sql);
    self::$_db->bind(":AreaExpertiseid",$AreaExpertiseID);
    self::$_db->execute();
    return self::$_db->rowCount();
   

}
}



?>