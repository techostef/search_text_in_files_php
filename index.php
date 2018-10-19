<?php
// PHP File Tree Demo
// For documentation and updates, visit http://abeautifulsite.net/notebook.php?article=21

// Main function file
include("php_file_tree.php");
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Search</title>
		<link rel="shortcut icon" type="image/x-icon" href="loading.gif" />
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<link href="styles/default/default.css" rel="stylesheet" type="text/css" media="screen" />
		<link href="styles/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<style>
		.changeLinks{
			display: inline-block;
			margin: auto;
			width: fit-content !important;
			margin: 0;
		}
		</style>
		
		<!-- Makes the file tree(s) expand/collapsae dynamically -->
		<script src="jquery-1.3.2.js" type="text/javascript"></script>
		<script src="php_file_tree_jquery.js" type="text/javascript"></script>
		<script src="loadingO.js" type="text/javascript"></script>
	</head>

	<body>

		<div class="container">
			<div class="row">
			<div class="form-horizontal">
				<fieldset>

				<!-- Form Name -->
					<legend>Search System PHP</legend>

					<!-- Text input-->
					<div class="form-group">
						<label class="col-md-2 control-label" for="textinput">Text Search</label>  
						<div class="col-md-8">
							<input id="textsearch" name="textinput" type="text" placeholder="Text Search" class="form-control input-md">
						</div>
						
					</div>
					<div class="form-group">
						<div class="col-md-12">
							<button id="searchbutton" style="display:block;margin:auto" name="singlebutton" class="btn btn-primary">Search</button>
							
						</div>
					</div>

				</fieldset>
			</div>

			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-md-6">
				<h2>Result...</h2>
				<div class="resultSearch" style="width:100%">

				</div>
				</div>
				<div class="col-md-6">
				<h2>Browing... <button id="changeLinks" name="singlebutton" onclick="myFunction()" class="btn btn-primary changeLinks">Ganti Links</button></h2>
		
				<?php
				
				// This links the user to http://example.com/?file=filename.ext
				//echo php_file_tree($_SERVER['DOCUMENT_ROOT'], "http://example.com/?file=[link]/");

				// This links the user to http://example.com/?file=filename.ext and only shows image files
				//$allowed_extensions = array("gif", "jpg", "jpeg", "png");
				//echo php_file_tree($_SERVER['DOCUMENT_ROOT'], "http://example.com/?file=[link]/", $allowed_extensions);
				
				// This displays a JavaScript alert stating which file the user clicked on
				if(isset($_GET['path'])):
					echo php_file_tree($_GET['path'], "javascript:alert('You clicked on [link]');",true);
					?>
					<script>
					var url = window.location.protocol+"//"+window.location.hostname+window.location.pathname;
					function myFunction() {
						var txt;
						var person = prompt("Tolong Pilih Folder:", ".");
						if (person == null || person == "") {
							person = ".";
						}
						window.location = url+"?path="+person;
					}
					</script>
					<?php
				else:
				?>
				<script>
				var url = window.location.protocol+"//"+window.location.hostname+window.location.pathname;
				function myFunction() {
					var txt;
					var person = prompt("Tolong Pilih Folder:", ".");
					if (person == null || person == "") {
						person = ".";
					}
					window.location = url+"?path="+person;
				}
				myFunction();
				</script>
				<?php 
				endif
				
				
				?>
				</div>
			</div>
		</div>
		<script>
			var select = $(".targetSearch");
			var text = $("#textsearch");
			var searchbutton = $("#searchbutton");
			var content;
			var temp,a,arr,textsearch;
			function loopcheck(select,checked){
				select.parent().find("ul").find("input").each(function(){
					$(this).attr('checked',checked);
				})
				select.parent().find('ul').find("ul").each(function(){
					loopcheck($(this),checked);
				})
			}
			function searchText(){
				addLoading("Mohon Tunggu");
				arr = [];
				textsearch = text.val();
				select.each(function(){
					if($(this).attr('checked')){
						if($(this).attr('data-type')=='file'){
							arr.push($(this).attr('data-url'));
						}
					}
				})
				arr = JSON.stringify(arr);
				$.ajax({
					type:"POST",
					data:{i:arr,a:textsearch},
					url:"searchapi.php",
					success:function(data){
						console.log(data);
						data = JSON.parse(data);
						console.log(data);
						$(".resultSearch").html('');
						if(data.length>0){
							content = '';
							$.each(data,function(i,item){
								$.each(item,function(i1,item1){
									content+="<div class='col-md-12'>";
									temp = "Url:"+item1['File']+",Line:"+item1['Line'];
									content+=temp;
									content+="</div>";
								})
								
							})
							$(".resultSearch").html(content);
						}
						removeLoading();
					}
				})
			}
			select.click(function(){
				temp = $(this).attr('data-type');
				a = $(this).attr('checked');
				if(temp=='dir'){
					loopcheck($(this),a);
				}
			})
			text.keyup(function(e){
				if(e.which==13){
					searchText();
				}
			})
			searchbutton.click(function(){
				searchText();
			})
		</script>
	</body>
</html>
