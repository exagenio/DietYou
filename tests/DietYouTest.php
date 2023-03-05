<?php
include 'backend/functions.php';

    final class DietYouTest extends \PHPUnit\Framework\TestCase{
        // $s = include "/backend/Equations.php";
        public function testbmiCalculate(){
            // $result = bmiCalculate(180,60);
            $this -> assertEquals(18.51851851851852, bmiCalculate(180,60) );
        }
    }
?>