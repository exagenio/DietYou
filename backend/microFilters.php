<?php

function microFilter100($finalDPlans,$dietPlans, $age, $gender){
  for($i=0; $i<count($dietPlans); $i++){
    $fiber = 0;
    $folate = 0;
    $Vitamin_B6 = 0;
    $Vitamin_B12 = 0;
    $choline = 0;
    // $biotin = 0;
    $Vitamin_A = 0;
    $Vitamin_C = 0;
    $Vitamin_E = 0;
    $Vitamin_K = 0;
    $vitamin_D = 0;
    $calcium = 0;
    // $chromium = 0;
    // $iodine = 0;
    $iron = 0;
    $magnesium = 0;
    $potassium = 0;
    $selenium = 0;
    $sodium = 0;
    $zinc = 0;
    for($n=0; $n<2; $n++){
      for($j=0; $j<3; $j++){
        $sodium  += $dietPlans[$i][$n][$j]["sodium"];
        $fiber += $dietPlans[$i][$n][$j]["fiber_total_dietary_(g)"];
        $folate += $dietPlans[$i][$n][$j]["folate_food_(mcg)"];
        $Vitamin_B6 += $dietPlans[$i][$n][$j]["vitamin_B-6_(mg)"];
        $Vitamin_B12 += $dietPlans[$i][$n][$j]["vitamin_B-12_(mcg)"] + $dietPlans[$i][$n][$j]["vitamin_B-12_added(mcg)"];
        $choline += $dietPlans[$i][$n][$j]["choline_total_(mg)"];
        $Vitamin_A += $dietPlans[$i][$n][$j]["vitamin_A_RAE_(mcg_RAE)"];
        $Vitamin_C += $dietPlans[$i][$n][$j]["vitamin_C_(mg)"];
        $Vitamin_E += $dietPlans[$i][$n][$j]["vitamin_E_(alpha-tocopherol)_(mg)"];
        $Vitamin_K += $dietPlans[$i][$n][$j]["vitamin_K_(phylloquinone)_(mcg)"];
        $vitamin_D += $dietPlans[$i][$n][$j]["vitamin_D_(D2+D3)_(mcg)"];
        $calcium  += $dietPlans[$i][$n][$j]["calcium_(mg)"];
        $iron += $dietPlans[$i][$n][$j]["iron_(mg)"];
        $magnesium  += $dietPlans[$i][$n][$j]["magnesium_(mg)"];
        $potassium += $dietPlans[$i][$n][$j]["potassium_(mg)"];
        $selenium += $dietPlans[$i][$n][$j]["selenium_(mcg)"];
        $zinc += $dietPlans[$i][$n][$j]["zinc_(mg)"];
      }
    }
    $fiberReqM = ($fiber>=38*0.2)&&($fiber<=38*1.5);
    $fiberReqF = ($fiber>=25*0.2)&&($fiber<=25*1.5);

    $folateReq = ($folate>=400*0.2)&&($folate<=400*1.5);

    $vit_b6Req = ($Vitamin_B6>=1.3*0.2)&&($Vitamin_B6<=1.3*1.5);
    $vit_b6ReqW50 = ($Vitamin_B6>=1.7*0.2)&&($Vitamin_B6<=1.7*1.5);
    $vit_b6ReqM50 = ($Vitamin_B6>=1.5*0.2)&&($Vitamin_B6<=1.5*1.5);

    $vit_b12Req = ($Vitamin_B12 >= 2.4*0.2)&&($Vitamin_B12 <= 2.4*1.5);

    $cholineReqW = ($choline >=550*0.2)&&($choline <=550*1.5);
    $cholineReqM =($choline >=225*0.2)&&($choline <=225*1.5);

    $vit_AReqW = ($Vitamin_A >=700*0.2) && ($Vitamin_A <=700*1.5);
    $vit_AReqM = ($Vitamin_A >=900*0.2) && ($Vitamin_A <=900*1.5);

    $vit_EReq = ($Vitamin_E >=15*0.2)&& ($Vitamin_E <=15*1.5);

    $vit_KReq = ($Vitamin_E >=15*0.2) &&($Vitamin_K <=120*1.5);

    $vit_DReq = ($vitamin_D >= 15*0.2) && ($vitamin_D <= 15*1.5) ;
    $vit_DReq70 =($vitamin_D >= 20*0.2) && ($vitamin_D <= 20*1.5);

    $calcium_Req = ($calcium >= 1000*0.2) && ($calcium <= 1000*1.5);
    $calcium_Req50 = ($calcium >= 1000*0.2) && ($calcium <= 1000*1.5);
    $calcium_Req70 = ($calcium >= 1200*0.2) && ($calcium <= 1200*1.5);

    $iron_ReqW = ($iron >= 18*0.2) && ($iron <= 18*1.5);;
    $iron_ReqM = ($iron >= 8*0.2) && ($iron <= 8*1.5);
    $iron_Req50 = ($iron >= 8*0.2) && ($iron <= 8*1.5);;

    $magenesium_Req = ($magnesium >= 400*0.2) && ($magnesium <= 400*1.5);
    $magenesium_Req30 = ($magnesium >= 420*0.2) && ($magnesium <= 420*1.5);

    $potassium_Req =($potassium >= 3400*0.2) && ($potassium <= 3400*1.5);

    $seleniumReq =($selenium >= 55*0.2) && ($selenium <= 55*1.5);

    $sodiumReq = ($sodium >=2300*0.2) && ($sodium <=2300*1.5);

    $zincReqW =($zinc >= 8*0.2) && ($zinc <= 8*1.5);
    $zincReqM = ($zinc >= 11*0.2) && ($zinc <= 11*1.5);

    if(($folateReq) && ($vit_b12Req) && ($vit_EReq) && ($vit_KReq) && ($potassium_Req) && ($seleniumReq) && ($sodiumReq) ){
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
        
        if(($fiberReqM) && ($cholineReqM)  && ($vit_AReqM) && ($iron_ReqM) && ($zincReqM)){
          
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
  }
}

function microFilter75($finalDPlans,$dietPlans, $age, $gender){
  for($i=0; $i<count($dietPlans); $i++){
    $fiber = 0;
    $folate = 0;
    $Vitamin_B6 = 0;
    $Vitamin_B12 = 0;
    $choline = 0;
    // $biotin = 0;
    $Vitamin_A = 0;
    $Vitamin_C = 0;
    $Vitamin_E = 0;
    $Vitamin_K = 0;
    $vitamin_D = 0;
    $calcium = 0;
    // $chromium = 0;
    // $iodine = 0;
    $iron = 0;
    $magnesium = 0;
    $potassium = 0;
    $selenium = 0;
    $sodium = 0;
    $zinc = 0;
    for($n=0; $n<2; $n++){
      for($j=0; $j<3; $j++){
        $sodium  += $dietPlans[$i][$n][$j]["sodium"];
        $fiber += $dietPlans[$i][$n][$j]["fiber_total_dietary_(g)"];
        $folate += $dietPlans[$i][$n][$j]["folate_food_(mcg)"];
        $Vitamin_B6 += $dietPlans[$i][$n][$j]["vitamin_B-6_(mg)"];
        $Vitamin_B12 += $dietPlans[$i][$n][$j]["vitamin_B-12_(mcg)"] + $dietPlans[$i][$n][$j]["vitamin_B-12_added(mcg)"];
        $choline += $dietPlans[$i][$n][$j]["choline_total_(mg)"];
        $Vitamin_A += $dietPlans[$i][$n][$j]["vitamin_A_RAE_(mcg_RAE)"];
        $Vitamin_C += $dietPlans[$i][$n][$j]["vitamin_C_(mg)"];
        $Vitamin_E += $dietPlans[$i][$n][$j]["vitamin_E_(alpha-tocopherol)_(mg)"];
        $Vitamin_K += $dietPlans[$i][$n][$j]["vitamin_K_(phylloquinone)_(mcg)"];
        $vitamin_D += $dietPlans[$i][$n][$j]["vitamin_D_(D2+D3)_(mcg)"];
        $calcium  += $dietPlans[$i][$n][$j]["calcium_(mg)"];
        $iron += $dietPlans[$i][$n][$j]["iron_(mg)"];
        $magnesium  += $dietPlans[$i][$n][$j]["magnesium_(mg)"];
        $potassium += $dietPlans[$i][$n][$j]["potassium_(mg)"];
        $selenium += $dietPlans[$i][$n][$j]["selenium_(mcg)"];
        $zinc += $dietPlans[$i][$n][$j]["zinc_(mg)"];
      }
    }
    $fiberReqM = ($fiber>=38*0.2)&&($fiber<=38*1.5);
    $fiberReqF = ($fiber>=25*0.2)&&($fiber<=25*1.5);

    $folateReq = ($folate>=400*0.2)&&($folate<=400*1.5);

    $vit_b6Req = ($Vitamin_B6>=1.3*0.2)&&($Vitamin_B6<=1.3*1.5);
    $vit_b6ReqW50 = ($Vitamin_B6>=1.7*0.2)&&($Vitamin_B6<=1.7*1.5);
    $vit_b6ReqM50 = ($Vitamin_B6>=1.5*0.2)&&($Vitamin_B6<=1.5*1.5);

    $vit_b12Req = ($Vitamin_B12 >= 2.4*0.2)&&($Vitamin_B12 <= 2.4*1.5);

    $cholineReqW = ($choline >=550*0.2)&&($choline <=550*1.5);
    $cholineReqM =($choline >=225*0.2)&&($choline <=225*1.5);

    $vit_AReqW = ($Vitamin_A >=700*0.2) && ($Vitamin_A <=700*1.5);
    $vit_AReqM = ($Vitamin_A >=900*0.2) && ($Vitamin_A <=900*1.5);

    $vit_EReq = ($Vitamin_E >=15*0.2)&& ($Vitamin_E <=15*1.5);

    $vit_KReq = ($Vitamin_E >=15*0.2) &&($Vitamin_K <=120*1.5);

    $vit_DReq = ($vitamin_D >= 15*0.2) && ($vitamin_D <= 15*1.5) ;
    $vit_DReq70 =($vitamin_D >= 20*0.2) && ($vitamin_D <= 20*1.5);

    $calcium_Req = ($calcium >= 1000*0.2) && ($calcium <= 1000*1.5);
    $calcium_Req50 = ($calcium >= 1000*0.2) && ($calcium <= 1000*1.5);
    $calcium_Req70 = ($calcium >= 1200*0.2) && ($calcium <= 1200*1.5);

    $iron_ReqW = ($iron >= 18*0.2) && ($iron <= 18*1.5);;
    $iron_ReqM = ($iron >= 8*0.2) && ($iron <= 8*1.5);
    $iron_Req50 = ($iron >= 8*0.2) && ($iron <= 8*1.5);;

    $magenesium_Req = ($magnesium >= 400*0.2) && ($magnesium <= 400*1.5);
    $magenesium_Req30 = ($magnesium >= 420*0.2) && ($magnesium <= 420*1.5);

    $potassium_Req =($potassium >= 3400*0.2) && ($potassium <= 3400*1.5);

    $seleniumReq =($selenium >= 55*0.2) && ($selenium <= 55*1.5);

    $sodiumReq = ($sodium >=2300*0.2) && ($sodium <=2300*1.5);

    $zincReqW =($zinc >= 8*0.2) && ($zinc <= 8*1.5);
    $zincReqM = ($zinc >= 11*0.2) && ($zinc <= 11*1.5);

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
  }
}



function microFilter50($finalDPlans,$dietPlans, $age, $gender){
  for($i=0; $i<count($dietPlans); $i++){
    $fiber = 0;
    $folate = 0;
    $Vitamin_B6 = 0;
    $Vitamin_B12 = 0;
    $choline = 0;
    // $biotin = 0;
    $Vitamin_A = 0;
    $Vitamin_C = 0;
    $Vitamin_E = 0;
    $Vitamin_K = 0;
    $vitamin_D = 0;
    $calcium = 0;
    // $chromium = 0;
    // $iodine = 0;
    $iron = 0;
    $magnesium = 0;
    $potassium = 0;
    $selenium = 0;
    $sodium = 0;
    $zinc = 0;
    for($n=0; $n<2; $n++){
      for($j=0; $j<3; $j++){
        $sodium  += $dietPlans[$i][$n][$j]["sodium"];
        $fiber += $dietPlans[$i][$n][$j]["fiber_total_dietary_(g)"];
        $folate += $dietPlans[$i][$n][$j]["folate_food_(mcg)"];
        $Vitamin_B6 += $dietPlans[$i][$n][$j]["vitamin_B-6_(mg)"];
        $Vitamin_B12 += $dietPlans[$i][$n][$j]["vitamin_B-12_(mcg)"] + $dietPlans[$i][$n][$j]["vitamin_B-12_added(mcg)"];
        $choline += $dietPlans[$i][$n][$j]["choline_total_(mg)"];
        $Vitamin_A += $dietPlans[$i][$n][$j]["vitamin_A_RAE_(mcg_RAE)"];
        $Vitamin_C += $dietPlans[$i][$n][$j]["vitamin_C_(mg)"];
        $Vitamin_E += $dietPlans[$i][$n][$j]["vitamin_E_(alpha-tocopherol)_(mg)"];
        $Vitamin_K += $dietPlans[$i][$n][$j]["vitamin_K_(phylloquinone)_(mcg)"];
        $vitamin_D += $dietPlans[$i][$n][$j]["vitamin_D_(D2+D3)_(mcg)"];
        $calcium  += $dietPlans[$i][$n][$j]["calcium_(mg)"];
        $iron += $dietPlans[$i][$n][$j]["iron_(mg)"];
        $magnesium  += $dietPlans[$i][$n][$j]["magnesium_(mg)"];
        $potassium += $dietPlans[$i][$n][$j]["potassium_(mg)"];
        $selenium += $dietPlans[$i][$n][$j]["selenium_(mcg)"];
        $zinc += $dietPlans[$i][$n][$j]["zinc_(mg)"];
      }
    }
    $fiberReqM = ($fiber>=38*0.2)&&($fiber<=38*1.5);
    $fiberReqF = ($fiber>=25*0.2)&&($fiber<=25*1.5);

    $folateReq = ($folate>=400*0.2)&&($folate<=400*1.5);

    $vit_b6Req = ($Vitamin_B6>=1.3*0.2)&&($Vitamin_B6<=1.3*1.5);
    $vit_b6ReqW50 = ($Vitamin_B6>=1.7*0.2)&&($Vitamin_B6<=1.7*1.5);
    $vit_b6ReqM50 = ($Vitamin_B6>=1.5*0.2)&&($Vitamin_B6<=1.5*1.5);

    $vit_b12Req = ($Vitamin_B12 >= 2.4*0.2)&&($Vitamin_B12 <= 2.4*1.5);

    $cholineReqW = ($choline >=550*0.2)&&($choline <=550*1.5);
    $cholineReqM =($choline >=225*0.2)&&($choline <=225*1.5);

    $vit_AReqW = ($Vitamin_A >=700*0.2) && ($Vitamin_A <=700*1.5);
    $vit_AReqM = ($Vitamin_A >=900*0.2) && ($Vitamin_A <=900*1.5);

    $vit_EReq = ($Vitamin_E >=15*0.2)&& ($Vitamin_E <=15*1.5);

    $vit_KReq = ($Vitamin_E >=15*0.2) &&($Vitamin_K <=120*1.5);

    $vit_DReq = ($vitamin_D >= 15*0.2) && ($vitamin_D <= 15*1.5) ;
    $vit_DReq70 =($vitamin_D >= 20*0.2) && ($vitamin_D <= 20*1.5);

    $calcium_Req = ($calcium >= 1000*0.2) && ($calcium <= 1000*1.5);
    $calcium_Req50 = ($calcium >= 1000*0.2) && ($calcium <= 1000*1.5);
    $calcium_Req70 = ($calcium >= 1200*0.2) && ($calcium <= 1200*1.5);

    $iron_ReqW = ($iron >= 18*0.2) && ($iron <= 18*1.5);;
    $iron_ReqM = ($iron >= 8*0.2) && ($iron <= 8*1.5);
    $iron_Req50 = ($iron >= 8*0.2) && ($iron <= 8*1.5);;

    $magenesium_Req = ($magnesium >= 400*0.2) && ($magnesium <= 400*1.5);
    $magenesium_Req30 = ($magnesium >= 420*0.2) && ($magnesium <= 420*1.5);

    $potassium_Req =($potassium >= 3400*0.2) && ($potassium <= 3400*1.5);

    $seleniumReq =($selenium >= 55*0.2) && ($selenium <= 55*1.5);

    $sodiumReq = ($sodium >=2300*0.2) && ($sodium <=2300*1.5);

    $zincReqW =($zinc >= 8*0.2) && ($zinc <= 8*1.5);
    $zincReqM = ($zinc >= 11*0.2) && ($zinc <= 11*1.5);

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
          if($age>70){
            if(($calcium_Req70) && ($magenesium_Req30)){
                array_push($finalDPlans, $dietPlans[$i]);
            }
          }else if($age>50){
            if( ($calcium_Req50) && ($magenesium_Req30)){
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
  }
}




function microFilter30($finalDPlans,$dietPlans, $age, $gender){
  for($i=0; $i<count($dietPlans); $i++){
    $fiber = 0;
    $folate = 0;
    $Vitamin_B6 = 0;
    $Vitamin_B12 = 0;
    $choline = 0;
    // $biotin = 0;
    $Vitamin_A = 0;
    $Vitamin_C = 0;
    $Vitamin_E = 0;
    $Vitamin_K = 0;
    $vitamin_D = 0;
    $calcium = 0;
    // $chromium = 0;
    // $iodine = 0;
    $iron = 0;
    $magnesium = 0;
    $potassium = 0;
    $selenium = 0;
    $sodium = 0;
    $zinc = 0;
    for($n=0; $n<2; $n++){
      for($j=0; $j<3; $j++){
        $sodium  += $dietPlans[$i][$n][$j]["sodium"];
        $fiber += $dietPlans[$i][$n][$j]["fiber_total_dietary_(g)"];
        $folate += $dietPlans[$i][$n][$j]["folate_food_(mcg)"];
        $Vitamin_B6 += $dietPlans[$i][$n][$j]["vitamin_B-6_(mg)"];
        $Vitamin_B12 += $dietPlans[$i][$n][$j]["vitamin_B-12_(mcg)"] + $dietPlans[$i][$n][$j]["vitamin_B-12_added(mcg)"];
        $choline += $dietPlans[$i][$n][$j]["choline_total_(mg)"];
        $Vitamin_A += $dietPlans[$i][$n][$j]["vitamin_A_RAE_(mcg_RAE)"];
        $Vitamin_C += $dietPlans[$i][$n][$j]["vitamin_C_(mg)"];
        $Vitamin_E += $dietPlans[$i][$n][$j]["vitamin_E_(alpha-tocopherol)_(mg)"];
        $Vitamin_K += $dietPlans[$i][$n][$j]["vitamin_K_(phylloquinone)_(mcg)"];
        $vitamin_D += $dietPlans[$i][$n][$j]["vitamin_D_(D2+D3)_(mcg)"];
        $calcium  += $dietPlans[$i][$n][$j]["calcium_(mg)"];
        $iron += $dietPlans[$i][$n][$j]["iron_(mg)"];
        $magnesium  += $dietPlans[$i][$n][$j]["magnesium_(mg)"];
        $potassium += $dietPlans[$i][$n][$j]["potassium_(mg)"];
        $selenium += $dietPlans[$i][$n][$j]["selenium_(mcg)"];
        $zinc += $dietPlans[$i][$n][$j]["zinc_(mg)"];
      }
    }
    $fiberReqM = ($fiber>=38*0.2)&&($fiber<=38*1.5);
    $fiberReqF = ($fiber>=25*0.2)&&($fiber<=25*1.5);

    $folateReq = ($folate>=400*0.2)&&($folate<=400*1.5);

    $vit_b6Req = ($Vitamin_B6>=1.3*0.2)&&($Vitamin_B6<=1.3*1.5);
    $vit_b6ReqW50 = ($Vitamin_B6>=1.7*0.2)&&($Vitamin_B6<=1.7*1.5);
    $vit_b6ReqM50 = ($Vitamin_B6>=1.5*0.2)&&($Vitamin_B6<=1.5*1.5);

    $vit_b12Req = ($Vitamin_B12 >= 2.4*0.2)&&($Vitamin_B12 <= 2.4*1.5);

    $cholineReqW = ($choline >=550*0.2)&&($choline <=550*1.5);
    $cholineReqM =($choline >=225*0.2)&&($choline <=225*1.5);

    $vit_AReqW = ($Vitamin_A >=700*0.2) && ($Vitamin_A <=700*1.5);
    $vit_AReqM = ($Vitamin_A >=900*0.2) && ($Vitamin_A <=900*1.5);

    $vit_EReq = ($Vitamin_E >=15*0.2)&& ($Vitamin_E <=15*1.5);

    $vit_KReq = ($Vitamin_E >=15*0.2) &&($Vitamin_K <=120*1.5);

    $vit_DReq = ($vitamin_D >= 15*0.2) && ($vitamin_D <= 15*1.5) ;
    $vit_DReq70 =($vitamin_D >= 20*0.2) && ($vitamin_D <= 20*1.5);

    $calcium_Req = ($calcium >= 1000*0.2) && ($calcium <= 1000*1.5);
    $calcium_Req50 = ($calcium >= 1000*0.2) && ($calcium <= 1000*1.5);
    $calcium_Req70 = ($calcium >= 1200*0.2) && ($calcium <= 1200*1.5);

    $iron_ReqW = ($iron >= 18*0.2) && ($iron <= 18*1.5);;
    $iron_ReqM = ($iron >= 8*0.2) && ($iron <= 8*1.5);
    $iron_Req50 = ($iron >= 8*0.2) && ($iron <= 8*1.5);;

    $magenesium_Req = ($magnesium >= 400*0.2) && ($magnesium <= 400*1.5);
    $magenesium_Req30 = ($magnesium >= 420*0.2) && ($magnesium <= 420*1.5);

    $potassium_Req =($potassium >= 3400*0.2) && ($potassium <= 3400*1.5);

    $seleniumReq =($selenium >= 55*0.2) && ($selenium <= 55*1.5);

    $sodiumReq = ($sodium >=2300*0.2) && ($sodium <=2300*1.5);

    $zincReqW =($zinc >= 8*0.2) && ($zinc <= 8*1.5);
    $zincReqM = ($zinc >= 11*0.2) && ($zinc <= 11*1.5);

        //filteration for overweight  300 reduction
    if( (($folateReq) && ($vit_EReq) && ($vit_KReq) && ($potassium_Req) && ($seleniumReq) && ($sodiumReq))  || ($fiberReqF) ){
          
      if($gender =="F"){
      
          if(($fiberReqF) && ($cholineReqW) && ($vit_AReqW) && ($zincReqW)){
            array_push($finalDPlans, $dietPlans[$i]);
          }
      }
      if($gender =="M"){
        
        if( (($fiberReqM) && ($cholineReqM)  && ($vit_AReqM) && ($zincReqM)) || ($fiberReqM)){
          array_push($finalDPlans, $dietPlans[$i]);
        }
      }
    }
  }
}


function microFilter25($finalDPlans,$dietPlans, $age, $gender){
  for($i=0; $i<count($dietPlans); $i++){
    $fiber = 0;
    $folate = 0;
    $Vitamin_B6 = 0;
    $Vitamin_B12 = 0;
    $choline = 0;
    // $biotin = 0;
    $Vitamin_A = 0;
    $Vitamin_C = 0;
    $Vitamin_E = 0;
    $Vitamin_K = 0;
    $vitamin_D = 0;
    $calcium = 0;
    // $chromium = 0;
    // $iodine = 0;
    $iron = 0;
    $magnesium = 0;
    $potassium = 0;
    $selenium = 0;
    $sodium = 0;
    $zinc = 0;
    for($n=0; $n<2; $n++){
      for($j=0; $j<3; $j++){
        $sodium  += $dietPlans[$i][$n][$j]["sodium"];
        $fiber += $dietPlans[$i][$n][$j]["fiber_total_dietary_(g)"];
        $folate += $dietPlans[$i][$n][$j]["folate_food_(mcg)"];
        $Vitamin_B6 += $dietPlans[$i][$n][$j]["vitamin_B-6_(mg)"];
        $Vitamin_B12 += $dietPlans[$i][$n][$j]["vitamin_B-12_(mcg)"] + $dietPlans[$i][$n][$j]["vitamin_B-12_added(mcg)"];
        $choline += $dietPlans[$i][$n][$j]["choline_total_(mg)"];
        $Vitamin_A += $dietPlans[$i][$n][$j]["vitamin_A_RAE_(mcg_RAE)"];
        $Vitamin_C += $dietPlans[$i][$n][$j]["vitamin_C_(mg)"];
        $Vitamin_E += $dietPlans[$i][$n][$j]["vitamin_E_(alpha-tocopherol)_(mg)"];
        $Vitamin_K += $dietPlans[$i][$n][$j]["vitamin_K_(phylloquinone)_(mcg)"];
        $vitamin_D += $dietPlans[$i][$n][$j]["vitamin_D_(D2+D3)_(mcg)"];
        $calcium  += $dietPlans[$i][$n][$j]["calcium_(mg)"];
        $iron += $dietPlans[$i][$n][$j]["iron_(mg)"];
        $magnesium  += $dietPlans[$i][$n][$j]["magnesium_(mg)"];
        $potassium += $dietPlans[$i][$n][$j]["potassium_(mg)"];
        $selenium += $dietPlans[$i][$n][$j]["selenium_(mcg)"];
        $zinc += $dietPlans[$i][$n][$j]["zinc_(mg)"];
      }
    }
    $fiberReqM = ($fiber>=38*0.2)&&($fiber<=38*1.5);
    $fiberReqF = ($fiber>=25*0.2)&&($fiber<=25*1.5);

    $folateReq = ($folate>=400*0.2)&&($folate<=400*1.5);

    $vit_b6Req = ($Vitamin_B6>=1.3*0.2)&&($Vitamin_B6<=1.3*1.5);
    $vit_b6ReqW50 = ($Vitamin_B6>=1.7*0.2)&&($Vitamin_B6<=1.7*1.5);
    $vit_b6ReqM50 = ($Vitamin_B6>=1.5*0.2)&&($Vitamin_B6<=1.5*1.5);

    $vit_b12Req = ($Vitamin_B12 >= 2.4*0.2)&&($Vitamin_B12 <= 2.4*1.5);

    $cholineReqW = ($choline >=550*0.2)&&($choline <=550*1.5);
    $cholineReqM =($choline >=225*0.2)&&($choline <=225*1.5);

    $vit_AReqW = ($Vitamin_A >=700*0.2) && ($Vitamin_A <=700*1.5);
    $vit_AReqM = ($Vitamin_A >=900*0.2) && ($Vitamin_A <=900*1.5);

    $vit_EReq = ($Vitamin_E >=15*0.2)&& ($Vitamin_E <=15*1.5);

    $vit_KReq = ($Vitamin_E >=15*0.2) &&($Vitamin_K <=120*1.5);

    $vit_DReq = ($vitamin_D >= 15*0.2) && ($vitamin_D <= 15*1.5) ;
    $vit_DReq70 =($vitamin_D >= 20*0.2) && ($vitamin_D <= 20*1.5);

    $calcium_Req = ($calcium >= 1000*0.2) && ($calcium <= 1000*1.5);
    $calcium_Req50 = ($calcium >= 1000*0.2) && ($calcium <= 1000*1.5);
    $calcium_Req70 = ($calcium >= 1200*0.2) && ($calcium <= 1200*1.5);

    $iron_ReqW = ($iron >= 18*0.2) && ($iron <= 18*1.5);;
    $iron_ReqM = ($iron >= 8*0.2) && ($iron <= 8*1.5);
    $iron_Req50 = ($iron >= 8*0.2) && ($iron <= 8*1.5);;

    $magenesium_Req = ($magnesium >= 400*0.2) && ($magnesium <= 400*1.5);
    $magenesium_Req30 = ($magnesium >= 420*0.2) && ($magnesium <= 420*1.5);

    $potassium_Req =($potassium >= 3400*0.2) && ($potassium <= 3400*1.5);

    $seleniumReq =($selenium >= 55*0.2) && ($selenium <= 55*1.5);

    $sodiumReq = ($sodium >=2300*0.2) && ($sodium <=2300*1.5);

    $zincReqW =($zinc >= 8*0.2) && ($zinc <= 8*1.5);
    $zincReqM = ($zinc >= 11*0.2) && ($zinc <= 11*1.5);

        //filteration for overweight  300 reduction
    if(($folateReq) && ($vit_EReq) && ($vit_KReq) && ($potassium_Req) && ($seleniumReq) && ($sodiumReq) ){
      array_push($finalDPlans, $dietPlans[$i]);
    }
  }
}

?>