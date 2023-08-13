<?php

class Agent_AreaExpertise{
    //Attributes
    private $AgentID;
    private $AreaExpertiseID;

    //Setters

    public function setAgentID(int $AgentID){
        $this->AgentID=$AgentID;
    }
    public function setAreaExpertiseID(int $AreaExpertiseID){
        $this->AreaExpertiseID=$AreaExpertiseID;
    }

    //Getters

    public function getAgentID():int{
        return $this->AgentID;
        }
    public function getAreaExpertiseID():int{
         return $this->AreaExpertiseID;
        }
}

?>