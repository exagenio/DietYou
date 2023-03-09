<?php
include 'backend/functions.php';

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
            $this -> assertEquals(2,406, TEE(100,180,1.2,"M",25));
        }
    }
?>