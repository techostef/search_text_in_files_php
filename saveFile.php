
<?php
$save = $_POST["save"]==1?true:false;

if(isset($_POST["save"])){
    $myfile = fopen($_REQUEST['path'], "w") or die("Unable to open file!");
    $txt = $_POST['text'];
    fwrite($myfile, $txt);
    fclose($myfile);
}

?>
