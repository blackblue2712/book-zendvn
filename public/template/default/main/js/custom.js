function getUrlVar(key){
	var result = new RegExp(key + "=([^&]*)", "i").exec(window.location.search); 
	return result && unescape(result[1]) || ""; 
}

//AJAX RELATED BOOK
function showRelateBook(url){
	$("#tab2-s").fadeIn("fast");
	$("#tab2").addClass("active");
	$("#tab1").removeClass("active");
	$("#tab1-s").css("display", "none");

	console.log(url);
	$("div#tab2-s").load(url);

	return false;
}

function changePage(page){
	$("input[name=filter_page]").val(page);
	$("#adminForm").submit();
}


$(document).ready(function() {

	/* This is basic - uses default settings */
	
	$("a#single_image").fancybox();
	
	/* Using custom settings */
	
	$("a#inline").fancybox({
		'hideOnContentClick': true
	});

	/* Apply fancybox to multiple items */
	
	$("a.group").fancybox({
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'speedIn'		:	600, 
		'speedOut'		:	200, 
		'overlayShow'	:	false
	});

	$("#tab1").click(function(){
		$("#tab1-s").fadeIn("fast");
		$('#tab1').addClass("active");
		$("#tab2").removeClass("active");
		$("#tab2-s").css("display", "none");
		return false;
	})

	// delete item
	$("a.delete_item").click(function(){
		var confirmDelete = confirm("Are you sure?");
		if(!confirmDelete) return false;
	})

	//change pass
	$("input[name=commit]").click(function(){
		var crPass = $("input[name=form[current_password]]").val();
		var nwPass = $("input[name=form[new_password]]").val();
		if(crPass.length == 0 || crPass.length == 0){
			$(".messageChange").html("Please fill out the form before change password");
			$(".messageChange").css({
				"color" 			: "#a94442",
   				"background-color" 	: "#f2dede",
    			"border-color"		: "#ebccd1",
			})
			
			$(".messageChange").slideDown().delay(1000).slideUp(300);
			return false;
		}
		
	})

});

function submitForm(url){
	$("#adminForm").attr("action", url);
	$("#adminForm").submit();
}

function showPassword(){
	$("input[type=password]").removeAttr("type");
}