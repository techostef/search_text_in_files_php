$(document).ready( function() {
	
	// Hide all subfolders at startup
	$(".php-file-tree").find("UL").hide();
	
	// Expand/collapse on click
	$(".pft-directory A").click( function() {
		if($(this).parent().hasClass('active')){
			$(this).parent().removeClass('active');
		}else{
			$(this).parent().addClass('active');
		}
		$(this).parent().find("UL:first").slideToggle("medium");
		if( $(this).parent().attr('className') == "pft-directory" ) return false;
	});
});
