<?php

class Agent_AreaExpertiseDAO{

    //Static DB
    private static $_db;

    //Initialize the AreaExpertiseDAO
    static function initialize()    {
        //Remember to send in the AreaExpertise name
        self::$_db=new PDOService('Agent_AreaExpertise');
    }
    //Add a new AreaExpertise for Agent
    static function createAgent_AreaExpertise(Agent_AreaExpertise $newAgentAreaExpertise) {

        //Create means INSERT
        $sql="INSERT IGNORE INTO Agent_AreaExpertise (AgentID,AreaExpertiseID)
        VALUES (:Agentid,:AreaExpertiseid);";

        //QUERY BIND EXECUTE RETURN
        self::$_db->query($sql);
        self::$_db->bind(":Agentid",$newAgentAreaExpertise->getAgentID());
        self::$_db->bind(":AreaExpertiseid",$newAgentAreaExpertise->getAreaExpertiseID());
        self::$_db->execute();
        
        return self::$_db->lastInsertedId();
    }
    //Get all Agent AreaExpertises
    static function getAgent_AreaExpertises() {
        $sql = "SELECT Distinct Agent.FirstName,Agent.LastName,AreaExpertise.AreaExpertiseShortName,AreaExpertise.AreaExpertiseLongName,
                        Agent_AreaExpertise.AgentID,Agent_AreaExpertise.AreaExpertiseID
                    FROM Agent join AreaExpertise 
                     join Agent_AreaExpertise
                        on Agent.AgentID=Agent_AreaExpertise.AgentID
                            and Agent_AreaExpertise.AreaExpertiseID = AreaExpertise.AreaExpertiseID;";

        //Prepare the Query
        self::$_db->query($sql);
        self::$_db->execute();
        //Return the results
        return self::$_db->resultset();
        //Return row
    }
}



?>