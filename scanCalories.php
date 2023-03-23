<?php
  // Path to Rscript executable
  $rscript_path = "Rscript";
  
  // R script file path
  $rscript_file = "MLModels/R_OCR.R ";
  
  // Arguments to pass to R script
  $arg1 = "MLModels/calorie_table.png";
  
  // Command to execute
  $command = "{$rscript_path} {$rscript_file} {$arg1}"; 
?>
<?php
// outputs the username that owns the running php/httpd process
// (on a system with the "whoami" executable in the path)
$output=null;
$retval=null;
exec($command, $output, $retval);
echo "Returned with status $retval and output:\n";
print_r($output);
?>