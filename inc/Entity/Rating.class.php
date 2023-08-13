<?php
class Rating{

    //Attributes
private $RatingID;
private $AgentID;
private $AreaExpertiseID;
private $UserID;
private $Date;
private $Rating;
private $Review;
public $FirstName = "";
public $LastName = "";
public $AreaExpertiseShortName = "";



//Setters
public function setRatingID(int $ratingID){
    $this->RatingID=$ratingID;
}
public function setAgentID(int $AgentID){
    $this->AgentID=$AgentID;
}
public function setAreaExpertiseID(int $AreaExpertiseID){
    $this->AreaExpertiseID=$AreaExpertiseID;
}
public function setUserID(int $UserID){
    $this->UserID=$UserID;
}
public function setDate(string $date){
    $this->Date=$date;
}
public function setRating(int $rating){
    $this->Rating=$rating;
}
public function setReview(string $review){
    $this->Review=$review;
}
public function setFirstName(string $firstname){
    $this->FirstName = $firstname;
}
public function setLastName(string $lastname){
    $this->LastName = $lastname;
}
public function setAreaExpertiseShortName(string $AreaExpertiseshortname){
    $this->AreaExpertiseShortName = $AreaExpertiseshortname;
}

//getters
public function getRatingID():int{
   return $this->RatingID;
}
public function getAgentID():int{
    return $this->AgentID;
}
public function getAreaExpertiseID():int{
    return $this->AreaExpertiseID;
}
public function getUserID():int{
    return $this->UserID;
}
public function getDate(){
    return $this->Date;
}
public function getRating() :int{
    return $this->Rating;
}
public function getReview():string{
    return$this->Review;
}
public function getFirstName():string{
    return$this->FirstName;
}
public function getLastName():string{
    return$this->LastName;
}
//JSON Serialization with std class
public function jsonSerialize()
{
    $obj = new stdClass;
    $obj->RatingID = $this->RatingID;
    $obj->AgentID = $this->AgentID;
    $obj->AreaExpertiseID = $this->AreaExpertiseID;
    $obj->UserID = $this->UserID;
    $obj->Date = $this->Date;
    $obj->Rating = $this->Rating;
    $obj->Review = $this->Review;
    $obj->FirstName = $this->FirstName;
    $obj->LastName = $this->LastName;
    $obj->AreaExpertiseShortName = $this->AreaExpertiseShortName;
    return $obj;
}
}
?>