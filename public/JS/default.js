window.onerror = function(error) {
  // do something clever here
  alert(error); // do NOT do this for real!
};

//JS For Products Actions
$(document).ready(function()
{
	if( typeof get_ready == 'function')
	{
		get_ready();
	}
	
	//For Error Class style
	$('.err_notification').addClass(E_HIDE);
	
	get_model_default_functions();
	
	//set active menu
	var curr_url = window.location.href.split('#')[0];
	var url_arr = curr_url.split('/');
	if( $.isNumeric(url_arr[url_arr.length -1]))
	{
		var len = curr_url.length - url_arr[url_arr.length -1].length - 1;
		curr_url = curr_url.substr(0,len);
	}else if(curr_url == MAIN_URL+"/" || curr_url == MAIN_URL || curr_url.endsWith("dashboard")|| curr_url.endsWith("dashboard/") )
	{
		$(".dashboard_adv_search").removeClass('d-none');
	}
	
	//active link and permissions
	$("#nav-menu-links-list li").each(function(){
		if(!$(this).hasClass('dashboard_adv_search'))
		{
			var li = $(this).find('a').attr('href');
			if(li == curr_url || li+"/" == curr_url)
			{
				$(this).addClass('active');
			}else{
				$(this).removeClass('active');
			}
			
			//check permission
			var link_a = li.replace(MAIN_URL,'');
			link_a = link_a.split('/');
			var asd = 1;
			if(link_a.length == 1)
			{
				asd = vm_page_permission.h_access(link_a[0]);
			}else{
				asd = vm_page_permission.h_access(link_a[0],link_a[1]);
			}
			if(!asd)
			{
				$(this).addClass(E_HIDE);
			}
		}
	});
	
	//default year
	$year = new Date().getFullYear();
	$(".default_year_place").each(function(){
		if($(this).is("input"))
		{
			$(this).attr('max',$year);
		}else
		{
			$(this).html($year);
		}
	})
	
	upd_footer_size();
	
	//For Printing
	$('.print_button').click(function(){
		var mywindow= window.open("", "PRINT","height=400,width=600");
		
        mywindow.document.write("<head>"+document.head.innerHTML+"</head>");
        mywindow.document.write(document.getElementById('print_area').innerHTML);
		
		mywindow.focus();
		//mywindow.document.close();
        
        mywindow.print();
        mywindow.close();
	});
	
	//For Printing
	$('.excel_button').click(function(){
		var table_id = "print_area";
		//getting values of current time for generating the file name
		var postfix = 'Report_' + new Date().toLocaleDateString();
		
		//var postfix = day + "." + month + "." + year;
		//creating a temporary HTML link element (they support setting file names)
		var a = document.createElement('a');
		//getting data from our div that contains the HTML table
		var data_type = 'data:application/vnd.ms-excel';
		var table_div = document.getElementById(table_id);
		var table_html = table_div.outerHTML.replace(/ /g, '%20');
		a.href = data_type + ', ' + table_html;
		//setting the file name
		a.download = postfix + '.xls';
		//triggering the function
		a.click();
		//just in case, prevent default behaviour
		//e.preventDefault();
		return false;
	});
	
	//For Printing
	$('.pdf_button').click(function(){
		var table_id = "print_area";
		//getting values of current time for generating the file name
		var postfix = 'Report_' + new Date().toLocaleDateString();
		
		//var postfix = day + "." + month + "." + year;
		//creating a temporary HTML link element (they support setting file names)
		var a = document.createElement('a');
		//getting data from our div that contains the HTML table
		var data_type = 'data:application/pdf';
		var table_div = document.getElementById(table_id);
		var table_html = table_div.outerHTML.replace(/ /g, '%20');
		a.href = data_type + ', ' + table_html;
		//setting the file name
		a.download = postfix + '.pdf';
		//triggering the function
		a.click();
		//just in case, prevent default behaviour
		//e.preventDefault();
		return false;
	});
	
	
	
	
})

function upd_footer_size()
{
	//Get height
	var sidebar = $('.vue_area_div').height();
	var body = $('body').height();
	if(sidebar < 350 && body > sidebar )
	{
		$('#footer_area').addClass('fixed-bottom');
	}else
	{
		$('#footer_area').removeClass('fixed-bottom');
	}
}

//For Form Error 
function error_handler(data)
{
	try {
		var obj = JSON.parse(data);
		if ("Error" in obj)
		{
			var res = obj.Error;
			if(res == "No Certificate")
			{
				alert("Error Certificate");
			}else
			{
				var m;
				res = res.split("\n");
				res.forEach(function(item, index)
				{
					if(item.search("Data not saved") != -1)
					{
						$('#save_err').modal();
					}else if(item != "" && item.trim() != "")
					{
						item = item+"";
						m = item.split(":");
						if(m.length != 2)
						{
							alert(item);
						}else if(m[0]=="modal")
						{
							$('#'+m[0]).modal('show');
						}else
						{
							m[0] = m[0].replace("In Field ", "");
							m[0] = m[0].replace("في الحقل ", "");
							m[0] = m[0].replace(" ", "");
							if(m[1].search("Duplicate") != -1)
							{
								if($("#duplicate_"+m[0]).length)
								{
									$("#duplicate_"+m[0]).removeClass(E_HIDE);
								}else
								{
									alert("Duplicate in :"+m[0]);
								}
								
							}else{
								if($("#valid_"+m[0]).length)
								{
									$("#valid_"+m[0]).removeClass(E_HIDE);
									$("#valid_"+m[0]).html(m[1]);
								}else
								{
									alert("Error in :"+m[0]);
								}
							}
						}
					}
				})
			}
		}
	}
	catch(err) {
		alert(err.message+"\n\n\n"+data);
	}
} 

//for Form Progress
function form_progress(percentage)
{
	$('#progress_area').val(percentage);
	if(percentage === 0)
	{
		$('#targetProgress').show();
	}else if(percentage == 100)
	{
		setTimeout(function() { $("#targetProgress").hide(); }, 1500);
	}
}

//clear form
function close_form_dialog(di)
{
	var ty = di.data('type');
	//if(ty.search('add') != -1 || ty.search('new') != -1 )
	//{
		di.find('input:not(.hid_info):not(:checkbox):not(:radio)').val('');
		di.find('select').val('');
		di.find('textarea').html('');
		di.find('textarea').val('');
		di.find('input:checkbox').prop('checked', false);
		di.find('input:radio').prop('checked', false);
		di.find('.err_notification').addClass(E_HIDE);
		di.find('.clear_form_area').html('');
		di.find('.range_input').html('');
		di.find('.form_images').attr('src','');
		
	//}
}

//_____________________________________Model Form
function get_model_default_functions()
{
	//open model
	$(".open_model").click(function(){
		$(this).find('.err_notification').addClass(E_HIDE);
		$id = $(this).attr("data-bs-target");
		$($id).modal('show');
	});
	
	$('.modal_with_form').on('show.bs.modal', function (event) {
		$(this).find('.err_notification').addClass(E_HIDE);
	});

	//close model
	$('.modal_with_form').on('hidden.bs.modal', function () {
		if(!$(this).hasClass('search_modal_status'))
		{
			$form = $(this).find('form');
			close_form_dialog($form);
		}
	});

}

var spinner = $('#loader');
//submit modal form
$(document).on('submit','.model_form', function (e)
{
	e.preventDefault();
    spinner.show();
	
	$(this).find(".err_notification").addClass(E_HIDE);
	$MSG 		= $(this).find('.form_msg').html();
	$model_id 	= $(this).attr('data-model');
	$ID 		= $(this).attr('id');
	$type 		= $(this).attr('data-type');
	$(this).ajaxSubmit({ 
		target:   '#targetLayer', 
		beforeSubmit: function() {
			
			//form_progress(0);
		},
		uploadProgress: function (event, position, total, percentComplete){	
			//form_progress(percentComplete);
		},
		success:function (){
			var x = $('#targetLayer').html();
			spinner.hide();
			try {
				var obj = JSON.parse(x);
				if ("Error" in obj)
				{
					error_handler(x);
				}else if("id" in obj && obj.id != 0)
				{
					modal_element($type,obj.id);
					close_form_dialog($("#"+$ID));
					$('#'+$model_id).modal('hide');
					if($MSG != "")
					{
						alert($MSG);
					}
					upd_footer_size();
					
				}else
				{
					spinner.hide();
					alert(x);
				}
			}
			catch(err) {
				alert(err.message+"\n"+x);
			}
		},
		error:function(response,status,xhr){
			spinner.hide();
			alert("error "+JSON.stringify(response));
		},
		resetForm: false
	});
	return false;
})

//_____________________________________End Model Form

//Range
$(document).on('mousemove','.range_input', function (e)
{
	$id = $(this).data('view');
	$("#"+$id).html($(this).val());
});

//Range
$(document).on('input', '.range_input', function() {
    $id = $(this).data('view');
	$("#"+$id).html($(this).val());
});

//loader
var myVar;

function MY_loader() {
	myVar = setTimeout(showPage, 300);
}


function showPage() {
	document.getElementById("loader").style.display = "none";
	x = document.getElementsByClassName("vue_area_div");
	for (i = 0; i < x.length; i++)
	{
		x[i].style.display = 'block';
	}
	
}

/*
//Date Picker
$('.datepicker').datepicker({
	dateFormat: 'yy-mm-dd',
	changeMonth: true,
	changeYear: true
});
*/
function ago($time)
{
	$periods = array("ثانية", "دقيقة", "ساعة", "يوم", "أسبوع", "شهر", "سنة", "عشر سنوات");
	$lengths = array("60","60","24","7","4.35","12","10");
	$now = time();
	$difference = $now - $time;
	$tense = "منذ";
	for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) 
	{
		$difference /= $lengths[$j];
	}
	$difference = round($difference);
	if($difference != 1) 
	{
		$periods[$j];
	}
	return "$difference منذ $periods[$j]";
}

function showPage() {
	document.getElementById("loader").style.display = "none";
	x = document.getElementsByClassName("vue_area_div");
	for (i = 0; i < x.length; i++)
	{
		x[i].style.display = 'block';
	}
	
}

function footer_position(data_length)
{
	if(data_length = 0)
	{
		$("#footer_area").css('position','fixed');
		$("#footer_area").css('bottom',0);
		$("#footer_area").css('left',0);
		$("#footer_area").css('right',0);
	}else
	{
		$("#footer_area").css = '';
	}
}

$(document).on('click', '.sel_lang', function() {
    $id = $(this).data('id');
	$.get(MAIN_URL+"home/lang/"+$id, function(data, status){
		location.reload();
	});
	
});

$(document).on('click', '.copy_to_clip', function() {
    $id = $(this).data('id');
	var copyText = document.getElementById($id);
	copyText.select();
	copyText.setSelectionRange(0, 99999); /* For mobile devices */
	navigator.clipboard.writeText(copyText.value);

	// Alert the copied text 
	alert("Copied the text: " + copyText.value);
	
});




