vm_visit_type = new Vue({
	el: '.vue_area_div',
	data: {
		backup_list	: js_backup_list,
		file_name	: "",
	},
	mounted(){
		
	},
	methods: {
		new_backup(){
			if(confirm('هل انت متأكد من انك تريد انشاء نسخة احتياطية؟'))
			{
				$.post(MAIN_URL+"backup/new_backup",{},function(data,status,xhr)
				{
					alert(data);
					location.reload();
				});
			}
		},
		del_upd(index){
			this.file_name = this.backup_list[index];
		},
		
		
	}
});


function modal_element($type,$id)
{
	if($type == "restore")
	{
		//alert($id);
	}else{
		location.reload();
	}
}

//submit modal form
$(document).on('submit','#restore_form', function (e)
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
			alert(x);
			close_form_dialog($("#"+$ID));
			$('#'+$model_id).modal('hide');
		},
		error:function(response,status,xhr){
			spinner.hide();
			alert("error "+JSON.stringify(response));
		},
		resetForm: true,
	});
	return false;
})