<?php
include 'backend/functions.php';

    final class DietYouTest extends \PHPUnit\Framework\TestCase{
        // $s = include "/backend/Equations.php";
        public function testbmiCalculate(){
            // $result = bmiCalculate(180,60);
            $this -> assertEquals(18.51851851851852, bmiCalculate(180,60) );
        }
        public function testTEE(){
            $this -> assertEquals(1736, TEE(65,180,1.2,"M",25));
        }
    }
?>