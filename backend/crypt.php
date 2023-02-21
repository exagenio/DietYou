<?php 

function validate_pw($password, $hash){
    crypt($password, $hash);
    $genHash = crypt($password, $hash);
    debug_to_console($genHash);
    if($genHash == $hash){
        return true;
    }else{
        false;
    }
}
?>