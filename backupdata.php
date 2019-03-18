<?php 
$path = $_REQUEST['path'];
if(!file_exists($path)){
    $myfile = fopen($path."files.txt", "w") or die("Unable to open file!");
    $txt = "John Doe\n";
    fwrite($myfile, $txt);
    $txt = "Jane Doe\n";
    fwrite($myfile, $txt);
    fclose($myfile);
}