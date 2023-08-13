<?php
class AgentDAO  {

    //Hold the $_db in a variable.
    private static $_db;

    static function initialize()    {
      //Create the PDOService instance locally, be sure to specify the class.
      self::$_db=new PDOService('Agent');
    }
    //Create a new Agent
    static function createAgent(Agent $newAgent) {

        //Create means INSERT
        $sql="INSERT INTO Agent (FirstName,LastName,Email)
        VALUES (:firstname,:lastname,:email);";

        //QUERY BIND EXECUTE RETURN
        self::$_db->query($sql);
        self::$_db->bind(":firstname",$newAgent->getFirstName());
        self::$_db->bind(":lastname",$newAgent->getLastName());
        self::$_db->bind(":email",$newAgent->getEmail());
        self::$_db->execute();
        
        return self::$_db->lastInsertedId();
    }
    //Get an Agent by id
    static function getAgent(int $AgentID)  {

        //Gget means get one
        $sql="SELECT * FROM Agent WHERE AgentID=:Agentid;";

        //QUERY, BIND, EXECUTE, RETURN
        self::$_db->query($sql);
        self::$_db->bind(":Agentid",$AgentID);
        self::$_db->execute();
        return self::$_db->singleResult();    
    }
    //Get an Agent by fullname
    static function getAgentByName(string $firstName, string $lastName){
        $sql = "SELECT * FROM Agent where FirstName=:firstname AND LastName=:lastname;";
        self::$_db->query($sql);
        self::$_db->bind(":firstname", $firstName);
        self::$_db->bind(":lastname", $lastName);
        self::$_db->execute();
        return self::$_db->singleResult();
    }
    //Get all Agents
    static function getAgents() {

        //No parameters so no bind
        $sql="SELECT * FROM Agent;";
        self::$_db->query($sql);
        
        //Prepare the Query
        //execute the query
        self::$_db->execute();
        //Return results
        return self::$_db->resultSet();
    }
    //Update an Agent
    static function updateAgent (Agent $AgentToUpdate) {
            //update means UPDATE query
        $sql = "UPDATE Agent SET FirstName=:firstname,LastName=:lastname,Email=:email
                WHERE AgentID=:Agentid;";
            
        self::$_db->query($sql);

        self::$_db->bind(":firstname",$AgentToUpdate->getFirstName());
        self::$_db->bind(":lastname",$AgentToUpdate->getLastName());
        self::$_db->bind(":email",$AgentToUpdate->getEmail());
        self::$_db->bind(":Agentid",$AgentToUpdate->getAgentID());
        self::$_db->execute();
        return self::$_db->rowCount();


        //QUERY BIND EXECUTE RETURN THE RESULTS


    }
    //Delete an Agent by id
    static function deleteAgent(int $AgentID) {


        $sql="DELETE FROM Agent WHERE AgentID=:Agentid;";
        self::$_db->query($sql);
        self::$_db->bind(":Agentid",$AgentID);
        self::$_db->execute();
        return self::$_db->rowCount();
       

    }
   

}


?>