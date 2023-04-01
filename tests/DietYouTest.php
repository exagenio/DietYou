<?php
include 'backend/functions.php';
// include 'backend/db.php';
// include 'backend/db.php';

    final class DietYouTest extends \PHPUnit\Framework\TestCase{
        // $s = include "/backend/Equations.php";
        public function testbmiCalculate(){
            // $result = bmiCalculate(180,60);
            $this -> assertEquals(18.51851851851852, bmiCalculate(180,60) );
        }
        
        public function testTEEMale(){
            $this -> assertEquals(1986, TEE(65,180,1.2,"M",25));
        }

        public function testTEEFemale(){
            $this -> assertEquals(1786.8, TEE(65,180,1.2,"F",25));
        }

        public function testTEEOverWeight(){
            $this -> assertEquals(2406, TEE(100,180,1.2,"M",25));
        }

        public function testProtienCalculate(){
            $this -> assertEquals(90.0, ProteinCalculator(1800));
        }
        public function testCarbCalculate(){
            $this -> assertEquals(330.82500000000005, carbCalculator(2406));
        }
        public function testFatCalculate(){
            $this -> assertEquals(66.83333333333333, FatCalculator(2406));
        }

        
        public function testAllergyFliter(){
            $connection = mysqli_connect("localhost","root", "root","dietYou");
            $username = "shabeerox@gmail.com";
            $expectedResult = array("milk", "butter", "cheese", "galactose");
            $actualResult = allergyFilter($connection, $username);
            $this->assertEquals($expectedResult, $actualResult);

            // Test with user who has fructose intolerance allergy
            $username = "tharindu";
            $expectedResult = array("apple", "pear", "honey", "corn syrup");
            $actualResult = allergyFilter($connection, $username);
            $this->assertEquals($expectedResult, $actualResult);

            // Test with user who has no allergies
            $username = "ranvinu";
            $expectedResult = array();
            $actualResult = allergyFilter($connection, $username);
            $this->assertEquals($expectedResult, $actualResult);
        }
        
    }
