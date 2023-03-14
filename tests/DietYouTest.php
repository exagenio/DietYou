<?php
include 'backend/functions.php';
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
            $this -> assertEquals(360.9, carbCalculator(2406));
        }
        public function testFatCalculate(){
            $this -> assertEquals(53.46666666666667, FatCalculator(2406));
        }
        
        // public function testAllergyFliter(){
        //     $this -> assertEquals(,allergyFilter($connection,"Shabeer"));
        // }
        
    }
