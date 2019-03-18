<?php 
$data = "";
$show = false;
$save = $_POST["save"]==1?true:false;

if(isset($_POST["save"])){
    $myfile = fopen($_REQUEST['path'], "w") or die("Unable to open file!");
    $txt = $_POST['text'];
    fwrite($myfile, $txt);
    fclose($myfile);
}
if(isset($_REQUEST['path'])){
    $data = file_get_contents($_REQUEST['path']);
    true;
}

?>
<style>
    body{
        overflow:hidden;
    }
    textarea{
        border:unset;
    }
    textarea:focus {
        outline: none !important;
    }
</style>
<script src="jquery.js" type="text/javascript"></script>
<form action="saveFile.php" method="POST">
<input type="hidden" name="save" value="1">
<input type="hidden" name="path" value="<?php echo $_REQUEST['path']?>">
<input type="hidden" name="bg" value="<?php echo $_REQUEST['bg']?>">
<input type="hidden" name="color" value="<?php echo $_REQUEST['color']?>">
<textarea spellcheck="false" name="text" style="width:100%;height:100vh"><?php echo $data?></textarea>
<button id="submitbtn" type="submit" style="display:none"></button>
</form>
<script>
    document.addEventListener('keyup', function(e) {
        e.preventDefault();
		if (e.ctrlKey && e.shiftKey && e.which == 83 ) {
            $("#submitbtn").click();
		}
		// if (e.which == 77) {
		// 	alert("M key was pressed");
		// } else if (e.ctrlKey && e.which == 66) {
		// 	alert("Ctrl + B shortcut combination was pressed");
		// }else  else if (e.ctrlKey && e.altKey && e.which == 89) {
		// 	alert("Ctrl + Alt + Y shortcut combination was pressed");
		// } else if (e.ctrlKey && e.altKey && e.shiftKey && e.which == 85) {
		// 	alert("Ctrl + Alt + Shift + U shortcut combination was pressed");
		// }
	});
</script>
<script>
    jQuery(document).ready(function($){
        var bg = "<?php echo $_REQUEST['bg'];?>";
        var color = "<?php echo $_REQUEST['color'];?>";
        $("body").css({"background":bg,"color":color});
        $("textarea").css({"background":bg,"color":color});
    })
</script>