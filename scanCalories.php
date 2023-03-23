<?php
  // Path to Rscript executable
  $rscript_path = "Rscript";
  
  // R script file path
  $rscript_file = "test.R";
  
  // Arguments to pass to R script
  $arg1 = "argument1";
  $arg2 = "argument2";
  
  // Command to execute
  $command = "{$rscript_path} {$rscript_file}";
  
  // Execute R script and capture output
// exec("Rscript test.r", $output, $t);



  
?>
<?php
// outputs the username that owns the running php/httpd process
// (on a system with the "whoami" executable in the path)
$output=null;
$retval=null;
exec('Rscript MLModels/R_OCR.R 2>&1', $output, $retval);
echo "Returned with status $retval and output:\n";
print_r($output);
?>