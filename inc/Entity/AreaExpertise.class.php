<?php

Class AreaExpertise    {
  
    // //Attributes
    private $AreaExpertiseID;
    private $AreaExpertiseShortName;
    private $AreaExpertiseLongName;

    //Setters
    public function setAreaExpertiseID(int $AreaExpertiseID){
        $this->AreaExpertiseID=$AreaExpertiseID;
    }
    public function setAreaExpertiseShortName(string $shortName){
        $this->AreaExpertiseShortName=$shortName;
    }
    public function setAreaExpertiseLongName(string $longName){
        $this->AreaExpertiseLongName=$longName;
    }

    //Getters 
    public function getAreaExpertiseID():int{
        return $this->AreaExpertiseID;
    }
    public function getAreaExpertiseShortName():string{
        return $this->AreaExpertiseShortName;
    }
    public function getAreaExpertiseLongName():string{
        return $this->AreaExpertiseLongName;
    }
    //JSON Serialization with std class
    public function jsonSerialize()
    {
        $obj = new stdClass;
        $obj->AreaExpertiseID = $this->AreaExpertiseID;
        $obj->AreaExpertiseShortName = $this->AreaExpertiseShortName;
        $obj->AreaExpertiseLongName = $this->AreaExpertiseLongName;
        return $obj;
    }

}

?>