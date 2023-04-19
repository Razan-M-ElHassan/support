var curr_url;
//JS For dep Actions
$(document).ready(function(){
	if($("#error_msg").length)
	{
		var m = $('#error_msg').html();
		if(m != "")
		{
			alert(m);
			//$('#err_'+m).modal('show');
		}
	}
})

//forget submit
$(document).on('submit','#forget_form', function (e) 
{
	var postData = $('#forget_form').serializeArray();
	
	$.post($('#forget_form').attr('action'),postData)
    .done(function(data,status,xhr)
	{
		try {
			var obj = JSON.parse(data);
			
			if ("Error" in obj)
			{
				error_handler(data);
			}else
			{
				$('#forget_req').modal('show');
			}
		}
		catch(err) {
			alert(err.message+"\n"+data);
        }	
	});
	return false;
	
})

//reset pass submit
$(document).on('submit','#reset_form', function (e) 
{
	var postData = $('#reset_form').serializeArray();
	$.post($('#reset_form').attr('action'),postData,function(data,status,xhr)
	{
		try {
			var obj = JSON.parse(data);
			
			if ("Error" in obj)
			{
				error_handler(data);
			}else
			{
				$('#reset_req_modal').modal('show');
			}
		}
		catch(err) {
			alert(err.message+"\n"+data);
		}
	})
	return false;
})

$('#reset_req_modal').on('hide.bs.modal', function () {
	location.replace(MAIN_URL+'login');
})
