<?php
// PHP File Tree Demo
// For documentation and updates, visit http://abeautifulsite.net/notebook.php?article=21

// Main function file
include("php_file_tree.php");
// include("backupdata.php");
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title id="Title">Search</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
		textarea{
			border:unset;
		}
		textarea:focus {
			outline: none !important;
		}
		#textareaEditor::-webkit-scrollbar {
			width: 1px;
		}
		
		#textareaEditor::-webkit-scrollbar-track {
			-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
		}
		
		#textareaEditor::-webkit-scrollbar-thumb {
			background-color: darkgrey;
			outline: 1px solid slategrey;
		}
		</style>
		
		<!-- Makes the file tree(s) expand/collapsae dynamically -->
		<script src="jquery.js" type="text/javascript"></script>
		<script src="styles/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="styles/js/component.js" type="text/javascript"></script>
		<script src="php_file_tree_jquery.js" type="text/javascript"></script>
		<script src="loadingO.js" type="text/javascript"></script>
		<!-- <script src="loadingO-v.0.3.js" type="text/javascript"></script> -->
	</head>

	<body>
		<div class="container">
			<div class="row">
			<div class="form-horizontal">
				<fieldset>
				<!-- Form Name -->

					<div class="col-md-12">Search System PHP</div>
					<div class="col-md-12">Theme</div>
					<div class="col-md-12">
						<div class="col-md-6 changeThemeBlack btn btn-primary" style="cursor:pointer">Theme Black</div>
						<div class="col-md-6 changeThemeWhite btn btn-default" style="cursor:pointer">Theme White</div>
					</div>
					<div class="col-lg-12 col-sm-12">
						<div class="btn-pref btn-group btn-group-justified btn-group-lg" role="group" aria-label="...">
							<div class="btn-group" role="group">
								<button type="button" id="stars" class="btn btn-primary" href="#tab1" data-toggle="tab">
									<div class="hidden-xs">Text in File</div>
								</button>
							</div>
							<div class="btn-group" role="group">
								<button type="button" id="favorites" class="btn btn-default" href="#tab2" data-toggle="tab">
									<div class="hidden-xs">File by Name</div>
								</button>
							</div>
						</div>

						<div class="tab-content well">
							<div class="tab-pane fade in active" id="tab1" style="padding:20px;">
								<div class="form-group">
									<label class="col-md-2 control-label" for="textinput" style="color:black !important">Text Search</label>  
									<div class="col-md-8">
										<input id="textsearch" value="" name="textinput" type="text" placeholder="Text Search" class="form-control input-md">
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-12">
										<button id="searchbutton" style="display:block;margin:auto" name="singlebutton" class="btn btn-primary">Search</button>
										
									</div>
								</div>
							</div>
							<div class="tab-pane fade in" id="tab2" style="padding:20px;">
								<div class="form-group">
									<label class="col-md-2 control-label" for="textinput" style="color:black !important">Name Search</label>  
									<div class="col-md-8">
										<input id="namesearch" name="textinput" type="text" placeholder="Text Search" class="form-control input-md">
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-12">
										<button id="searchNamebutton" style="display:block;margin:auto" name="singlebutton" class="btn btn-primary">Search</button>
										
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Text input-->
					

				</fieldset>
			</div>

			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h2>Result...</h2>
					<div class="resultSearch" style="width:100%"></div>
				</div>
				<div class="col-md-6">
					<h2>Browing... <button id="changeLinks" name="singlebutton" onclick="myFunction()" class="btn btn-primary changeLinks">Ganti Links</button></h2>
			
					<?php
					if(isset($_GET['path'])):
						echo php_file_tree($_GET['path'], "[link]",true);
						?>
						<script>
							jQuery(document).ready(function($){
								setTimeout(() => {
									$("#directoryUtama").click();
								}, 100);
							})
						</script>
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
		$(document).ready(function(){
			$(".changeThemeBlack").click(function (){
				$("body").css({"background":"#1f1f1f","color":"#cacaca"});
				$(".php-file-tree a").css({"color":"#cacaca"});
			});
			$(".changeThemeWhite").click(function (){
				$("body").css({"background":"white","color":"black"});
				$(".php-file-tree a").css({"color":"black"});
			});

			$(".changeThemeBlack").click();
		})
		</script>
		<script>
			var win2a=null;                  
			var win3a=null;  
			function bukadialog(md,th) {
				th = $(th);
				var bg = $("body").css("background");
				var color = $("body").css("color");
				md = window.location.protocol+"//"+window.location.hostname+window.location.pathname+"editFile.php?path="+md+"&bg="+bg+"&color="+color;
				var w=screen.width;
				var h=screen.height;                            
				var left = Math.ceil((screen.width-w)/2);
				var top = Math.ceil((screen.height-h)/2);
				lnk = md;      
				if(win2a) win2a.close();     
				win2a = window.open(lnk, "", 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
				win2a.onunload  = function(){
					var temp = th.text();
					if(temp.indexOf("changed !")==-1){
						temp +=" <span style='color:#ef3131'>changed !</span>";
						th.html(temp);
					}
				};
			}
		</script>
		<script>
		$(document).ready(function() {
			$(".btn-pref .btn").click(function () {
				$(".btn-pref .btn").removeClass("btn-primary").addClass("btn-default");
				// $(".tab").addClass("active"); // instead of this do the below 
				$(this).removeClass("btn-default").addClass("btn-primary");   
			});
		});
		</script>
		<script>
			var select = $(".targetSearch");
			var text = $("#textsearch");
			var searchbutton = $("#searchbutton");
			var content;
			var loadingVar;
			var loading=false;
			var loadingN=1;
			var loadingChar,nama;
			var temp,a,i,arr,arrLength,textsearch;
			function loopcheck(select,checked,index,max){
				if(index>=max){
					removeLoading();
				}
				setTimeout(() => {

					var length = select.parent().find("ul").find("input")?select.parent().find("ul").find("input").length:0;
					select.parent().find("ul").find("input").each(function(){
						$(this).prop('checked',checked);
					})
					if(length>=max){
						removeLoading();
					}
					select.parent().find('ul').find("ul").each(function(){
						loopcheck($(this),checked,index+length,max);
					})
				}, 200);
			}
			function changeTitle(){
				if(loading){
					loadingvar = setInterval(function(){
						loadingChar="";
						if(loadingN==4)loadingN=1;
						for(i=1;i<=loadingN;i++){
							loadingChar+=".";
						}
						$("#Title").text("Loading"+loadingChar);
						loadingN++;
					},500);
				}
			}
			function removeChangeTitle(){
				loadingvar = null;
				$("#Title").text("Done");
			}
			function searchlooping(arr,index,length){
				var item = arr[index];
				if(item){
					var persen = parseFloat(index/length)*100;
					if(index==0||index%5==0){
						addLoading(index+"/"+arr.length+" ("+persen+"%)");

					}
					$.ajax({
						type:"POST",
						data:{url:item,search:textsearch},
						url:"searchapi.php?act=searchsingle",
						success:function(data){
							data = JSON.parse(data);
							content = '';
							if(data!=0&&data.length>0){
								data = data[0];
								nama = data['File'];
								nama = nama.split('/');
								nama = nama[nama.length-1];
								
								content+=nama;
								content+="<div class='col-md-12'>";
								temp = "Url:"+data['File']+",Line:"+data['Line'];
								content+=temp;
								content+="</div><hr/>";
								document.querySelector(".resultSearch").innerHTML += content;
							}
							if(index==length-1){
								removeLoading();
							}
						}
					}).done(function(){
						searchlooping(arr,index+1);
						if(index==length-1){
							removeLoading();
						}
					})
				}else{
					removeLoading();
					return false;
				}
				
			}
			function searchText(){
				loading=true;
				changeTitle();
				arr = [];
				document.querySelector(".resultSearch").innerHTML = "";
				textsearch = text.val();
				if(textsearch==""){
					alert("Isi Search..");
					return false;
				}
				select.each(function(){
					if($(this).prop('checked')){
						if($(this).attr('data-type')=='file'){
							arr.push($(this).attr('data-url'));
						}
					}
				})
				arrLength = arr.length;
				searchlooping(arr,0,arr.length);
			}
			select.click(function(e){
				temp = $(this).attr('data-type');
				a = $(this).prop('checked');
				addLoading("Mohon Tunggu");
				var inputs = $(this).parent().find("input");
				if(temp=='dir'){
					loopcheck($(this),a,0,inputs.length-1);
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
