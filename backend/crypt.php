<?php 

function encrypt_pw($password){
  $hash = password_hash($password,PASSWORD_DEFAULT);
  return $hash;
}

function validate_pw($password, $hash){
    $verify = password_verify($password, $hash);
    if ($verify) {
        return true;
    } else {
        return false;
    }
    // crypt($password, $hash);
    // $genHash = crypt($password, $hash);
    // debug_to_console($genHash);
    // if($genHash == $hash){
    //     return true;
    // }else{
    //     false;
    // }
}
?>