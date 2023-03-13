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

    function __construct($username, $connection) {
        if(userExist($username)){
            $find = "SELECT * FROM users where email = '$username'";
            $findQuery = mysqli_query($connection, $find);
            if (mysqli_num_rows($findQuery) == 0) {
            } else {
                $row = mysqli_fetch_row($findQuery);
                $userInfo = $row;
                print_r($userInfo);
                $this->weight = $userInfo[5];
                $this->height = $userInfo[6];
                $this->activityFactor = $userInfo[7];
                $this->ncds = $userInfo[8];
                $this->gender = $userInfo[9];
                $this->age = $userInfo[10];
                $this->BMI = bmiCalculate($this->height, $this->weight );
                $this->TEE = TEE($this->weight,$this->height,$this->activityFactor,$this->gender,$this->age);
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


}
?>