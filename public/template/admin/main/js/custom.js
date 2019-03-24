function ajaxChangeStatus(url){
	console.log(url);
	$.get(url, function(data){
		console.log(data);
		var classRemove  = "unpublish";
		var classAdd 	 = "publish";
		var element 	 = "a#status-" + data.id;

		if(data.status == 0){
			classRemove  = "publish";
			classAdd 	 = "unpublish";
		}
		$(element + " span").removeClass(classRemove).addClass(classAdd);
		$(element).attr("href", "javascript:ajaxChangeStatus('"+data.link+"')");
		
	},'json')
}

function ajaxACP(url){
	console.log(url);
	$.get(url, function(data){
		console.log(data);
		var classRemove  = "unpublish";
		var classAdd 	 = "publish";
		var element 	 = "a#group-acp-" + data.id;

		if(data.group_acp == 0){
			classRemove  = "publish";
			classAdd 	 = "unpublish";
		}
		$(element + " span").removeClass(classRemove).addClass(classAdd);
		$(element).attr("href", "javascript:ajaxACP('"+data.link+"')");
		
	}, 'json')
}

function ajaxSpecial(url){
	console.log(url);
	$.get(url, function(data){
		console.log(data);
		var classRemove  = "unpublish";
		var classAdd 	 = "publish";
		var element 	 = "a#special-" + data.id;

		if(data.special == 0){
			classRemove  = "publish";
			classAdd 	 = "unpublish";
		}
		$(element + " span").removeClass(classRemove).addClass(classAdd);
		$(element).attr("href", "javascript:ajaxSpecial('"+data.link+"')");
		
	}, 'json')
}

function submitForm(url){
	$("#adminForm").attr("action", url);
	$("#adminForm").submit();
}

//FILTER
function sortList(column, order){
	$("input[name=filter_column]").val(column);
	$("input[name=filter_column_dir]").val(order);
	$("#adminForm").submit();	
}

//CHANGE PAGE
function changePage(page){
	$("input[name=filter_page]").val(page);
	$("#adminForm").submit();
}



$(document).ready(function(){
	//CHECK ALL
	$("input[name=checkall-toggle]").change(function(){
		var isChecked = this.checked;
		$("#adminForm").find(":checkbox").each(function(){
			this.checked = isChecked;
		})
	})

	//SEARCH
	$("#filter-bar button[name=submit-keyword]").click(function(){
		$("#adminForm").submit();
	})

	$("#filter-bar button[name=clear-keyword]").click(function(){
		$("#filter-bar input[name=filter_search]").val("");
		$("#adminForm").submit();
	})

	//SELECT SORT
	$("#filter-bar select[name=filter_state]").change(function(){
		$("#adminForm").submit();
	})
	$("#filter-bar select[name=filter_acp]").change(function(){
		$("#adminForm").submit();
	})
	$("#filter-bar select[name=filter_group]").change(function(){
		$("#adminForm").submit();
	})
	$("#filter-bar select[name=filter_category]").change(function(){
		$("#adminForm").submit();
	})
	$("#filter-bar select[name=filter_special]").change(function(){
		$("#adminForm").submit();
	})

	//READ ONLY
	$("input.readonly").attr("readonly", false);

	$("#toolbar #toolbar-trash a.modal").click(function(){
		var flag = confirm("Are you suer?");
		if(flag == false) return false;
	})

	//Format price
	$("input#price").keyup(function(){
		var data = this.value;
		if(data.length > 3){
			console.log("1000");
		}
	})


	//scroll
	
    $("body, html").animate({
        scrollTop: 150,
    }, 700);

})