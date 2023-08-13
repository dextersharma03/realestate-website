<?php

class Agent {
    private $AgentID ;
    private $AreaExpertiseID;
    private $FirstName;
    private $LastName;
    private $Email;
//setters
    public function setAgentID(int $AgentID){
        $this->AgentID=$AgentID;
    }
    public function setAreaExpertiseID(int $AreaExpertiseID){
        $this->AreaExpertiseID=$AreaExpertiseID;
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
    
   //getters
   public function getAgentID():int{
    return $this->AgentID;
    }
    public function getAreaExpertiseID():int{
        if($this->AreaExpertiseID==null){
            $this->AreaExpertiseID=-1;
        }
        return $this->AreaExpertiseID;
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
    //JSON Serialization with std class
    public function jsonSerialize()
    {
        $obj = new stdClass;
        $obj->AgentID = $this->AgentID;
        $obj->AreaExpertiseID = $this->AreaExpertiseID;
        $obj->FirstName = $this->FirstName;
        $obj->LastName = $this->LastName;
        $obj->Email = $this->Email;
        return $obj;
    }


}

?>