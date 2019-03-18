<?php
/*
	
	== PHP FILE TREE ==
	
		Let's call it...oh, say...version 1?
	
	== AUTHOR ==
	
		Cory S.N. LaViska
		http://abeautifulsite.net/
		
	== DOCUMENTATION ==
	
		For documentation and updates, visit http://abeautifulsite.net/notebook.php?article=21
		
*/
global $listFolder ;


function php_file_tree($directory, $return_link, $withFile=false,$extensions = array()) {
	// Generates a valid XHTML list of all directories, sub-directories, and files in $directory
	// Remove trailing slash
	$code = "<ul class='php-file-tree'>";
	$code .= "<li class=\"pft-directory\" >";
	$code .= "<input data-type='dir' type='checkbox' class='targetSearch' data-url='.'>";
	$code .= "<div class='iconDirectory'></div><label id='directoryUtama' href=\"#\">Semua</label>";
	if( substr($directory, -1) == "/" ) $directory = substr($directory, 0, strlen($directory) - 1);
	$code .= php_file_tree_dir($directory, $return_link,$withFile, $extensions);
	$code .= "</li>";
	$code .= "</ul>";
	return $code;
}

function php_file_tree_dir($directory, $return_link, $withFile=true,$extensions = array(), $first_call = true) {
	// Recursive function called by php_file_tree() to list directories/files
	$exceptionFile = array(
		'zip','rar','7zip','bak','jpg','jpeg','png','gif'
	);
	$exceptionFolder = array(
		'node_modules'
	);
	// Get and sort directories/files
	if( function_exists("scandir") ) $file = scandir($directory); else $file = php4_scandir($directory);
	natcasesort($file);
	// Make directories first
	$files = $dirs = array();
	foreach($file as $this_file) {
		if( is_dir("$directory/$this_file" ) ) $dirs[] = $this_file; else $files[] = $this_file;
	}
	$file = array_merge($dirs, $files);
	
	// Filter unwanted extensions
	if( !empty($extensions) ) {
		foreach( array_keys($file) as $key ) {
			if( !is_dir("$directory/$file[$key]") ) {
				$ext = substr($file[$key], strrpos($file[$key], ".") + 1); 
				if( !in_array($ext, $extensions) ) unset($file[$key]);
			}
		}
	}
	$php_file_tree = '';
	
	if( count($file) > 2 ) { // Use 2 instead of 0 to account for . and .. "directories"
		$php_file_tree = "<ul";
		// if( $first_call ) { $php_file_tree .= " class=\"php-file-tree\""; $first_call = false; }
		$php_file_tree .= ">";
		foreach( $file as $this_file ) {
			if( $this_file != "." && $this_file != ".." ) {
				if( is_dir("$directory/$this_file")&&in_array($this_file,$exceptionFolder)==false) {
					// Directory
					$php_file_tree .= "<li class=\"pft-directory\">";
					$php_file_tree .= "<input data-type='dir' type='checkbox' class='targetSearch' data-url='".$directory."/".$this_file."'>";
					$php_file_tree .= "<div class='iconDirectory'></div><label href=\"#\">" . htmlspecialchars($this_file) . "</label>";
					$php_file_tree .= php_file_tree_dir("$directory/$this_file", $return_link ,$withFile,$extensions, false);
					$php_file_tree .= "</li>";
				} else {
					// File
					// Get extension (prepend 'ext-' to prevent invalid classes from extensions that begin with numbers)
					
					if(checkExt($directory."/".$this_file,$exceptionFile)){
						if($withFile){
							$ext = "ext-" . substr($this_file, strrpos($this_file, ".") + 1); 
							$link = str_replace("[link]", "$directory/" . urlencode($this_file), $return_link);
							$link = str_replace("\\", '/', $link);
							$php_file_tree .= "<li class=\"pft-file " . strtolower($ext) . "\"><input type='checkbox' data-type='file' class='targetSearch' data-url='".$directory."/".$this_file."'><div class='iconFile pft-file " . strtolower($ext) . "'></div><label class=\"openTextEditor\" data-text=\"$link\" style='cursor:pointer'>" . htmlspecialchars($this_file) . "</label></li>";
						}
					}
					
				}
			}
		}
		$php_file_tree .= "</ul>";
	}
	return $php_file_tree;
}

function checkExt($ext,$except=false){
	$file_parts = pathinfo($ext);

	if($except!=false){
		if(isset($file_parts['extension'])){
			if (in_array($file_parts['extension'], $except)){
				return false;
			}else{
				return true;
			}
		}else{
			return false;
		}
		
	}else{
		return true;
	}
}

// For PHP4 compatibility
function php4_scandir($dir) {
	$dh  = opendir($dir);
	while( false !== ($filename = readdir($dh)) ) {
	    $files[] = $filename;
	}
	sort($files);
	return($files);
}
