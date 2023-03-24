<?php
include "backend/functions.php";
class User{
    private $TEE;
    private $BMI;
    private $height;
    private $weight;
    private $activityFactor;
    private $ncds;
    private $age;
    private $gender;
    private $requiredCarbs;
    private $requiredProtein;
    private $requiredFat;
    private $planDate;
    private $countries;
    private $preferences;

    function __construct($username, $connection) {
        if(userExist($username)){
            $find = "SELECT * FROM users where email = '$username'";
            $findQuery = mysqli_query($connection, $find);
            if (mysqli_num_rows($findQuery) == 0) {
                //redirect login
            } else {
                $row = mysqli_fetch_row($findQuery);
                $userInfo = $row;
                // print_r($userInfo);
                $this->weight = $userInfo[5];
                $this->height = $userInfo[6];
                $this->activityFactor = $userInfo[7];
                $this->ncds = $userInfo[8];
                $this->gender = $userInfo[9];
                $this->age = $userInfo[10];
                $this->BMI = bmiCalculate($this->height, $this->weight );
                $this->TEE = TEE($this->weight,$this->height,$this->activityFactor,$this->gender,$this->age);
                $this->requiredCarbs = carbCalculator($this->TEE);
                $this->requiredFat = fatCalculator($this->TEE);
                $this->requiredProtein = ProteinCalculator($this->TEE);
                $this->age = $userInfo[10];
                $this->age = $userInfo[10];
                $this->planDate = $userInfo[15];
                $this->countries = $userInfo[13];
                $this->preferences = $userInfo[12];
            }
        }
    }

    public function getTEE(){
        return $this->TEE;
    }

    public function getBMI(){
        return $this->BMI;
    }

    public function getHeight(){
        return $this->height;
    }

    public function getWeight(){
        return $this->weight;
    }

    public function getActivityFactor(){
        return $this->activityFactor;
    }

    public function getNcds(){
        return $this->ncds;
    }

    public function getGender(){
        return $this->gender;
    }

    public function getAge(){
        return $this->age;
    }

    public function getCarbs(){
        return $this->requiredCarbs;
    }

    public function getProtein(){
        return $this->requiredProtein;
    }

    public function getFat(){
        return $this->requiredFat;
    }
    
    public function getPlanDate(){
        return $this->planDate;
    }
    public function getCountries(){
        return $this->countries;
    }
    public function getPreferences(){
        return $this->preferences;
    }

}
?>