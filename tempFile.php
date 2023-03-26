$fish = [2402,2404,3006,3730];
$fish_str = ["seafood","squid","tuna","crab"];
//below code is the first column
//the below array only takes into consideration the food codes that has egg
$egg = [2502,3406,3706];
$egg_str = ["egg"]

//the below array only takes into consideration the food codes that has meat
$meat = [2002,2004,2006,2008,2010,2202,2204,2206,2604,3002,3004,3006,3602,3702,3704,3742];
$meat_str = ["meat","chicken","poultry","beef","pork","meatballs","turkey"]


//sweet and snack
$sw_sn = [5002,5004,5006,5008,5202,5204,5402,5404,5502,5504,5506,5702,5704,5802,5804,5806]
<?php 

//filteration for overweight  300 reduction
if(($folateReq) && ($vit_EReq) && ($vit_KReq) && ($potassium_Req) && ($seleniumReq) && ($sodiumReq) ){
      
    if($gender =="F"){
    
        if(($fiberReqF) && ($cholineReqW) && ($vit_AReqW) && ($zincReqW)){
            if($age>70){
            if(($calcium_Req70) && ($vit_b6ReqW50) && ($iron_Req50) && ($magenesium_Req30)){
                array_push($finalDPlans, $dietPlans[$i]);
            }
            }else if($age>50){
            if( ($calcium_Req50) && ($vit_b6ReqW50) && ($iron_Req50) && ($magenesium_Req30)){
                array_push($finalDPlans, $dietPlans[$i]);
            }
            }else if($age>30){
            if(($magenesium_Req30)){
                array_push($finalDPlans, $dietPlans[$i]);
            }
            }else if($age>19){
            array_push($finalDPlans, $dietPlans[$i]);
            }

        }
    }
    if($gender =="M"){
      
        if(($fiberReqM) && ($cholineReqM)  && ($vit_AReqM) && ($zincReqM)){
            $count++;
            if($age>70){
            if(($calcium_Req70) && ($vit_b6ReqM50) && ($iron_Req50) && ($magenesium_Req30)){
                array_push($finalDPlans, $dietPlans[$i]);
            }
            }else if($age>50){
            if( ($calcium_Req50) && ($vit_b6ReqM50) && ($iron_Req50) && ($magenesium_Req30)){
                array_push($finalDPlans, $dietPlans[$i]);
            }
            }else if($age>30){
            if(($magenesium_Req30)){
                array_push($finalDPlans, $dietPlans[$i]);
            }
            }else if($age>19){
            array_push($finalDPlans, $dietPlans[$i]);
            }
        }
    }
}

//filteration for overweight M 400 reduction

if(($folateReq)  && ($vit_KReq) && ($potassium_Req) && ($sodiumReq) ){
    if($gender =="F"){
    
      if(($fiberReqF) && ($cholineReqW) && ($vit_AReqW) && ($iron_ReqW) && ($zincReqW)){
        if($age>70){
          if(($calcium_Req70) && ($vit_b6ReqW50) && ($iron_Req50) && ($magenesium_Req30)){
            array_push($finalDPlans, $dietPlans[$i]);
          }
        }else if($age>50){
          if( ($calcium_Req50) && ($vit_b6ReqW50) && ($iron_Req50) && ($magenesium_Req30)){
            array_push($finalDPlans, $dietPlans[$i]);
          }
        }else if($age>30){
          if(($magenesium_Req30)){
            array_push($finalDPlans, $dietPlans[$i]);
          }
        }else if($age>19){
          array_push($finalDPlans, $dietPlans[$i]);
        }

      }
    }
    if($gender =="M"){
      
      if(($fiberReqM) && ($cholineReqM)){
        $count++;
        if($age>70){
          if(($calcium_Req70) && ($magenesium_Req30)){
            array_push($finalDPlans, $dietPlans[$i]);
          }
        }else if($age>50){
          if( ($calcium_Req50)  && ($magenesium_Req30)){
            array_push($finalDPlans, $dietPlans[$i]);
          }
        }else if($age>30){
          if(($magenesium_Req30)){
            array_push($finalDPlans, $dietPlans[$i]);
          }
        }else if($age>19){
          array_push($finalDPlans, $dietPlans[$i]);
        }
      }
    }
}

?>
