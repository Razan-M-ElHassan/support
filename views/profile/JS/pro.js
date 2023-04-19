vm_staff = new Vue({
	el: '.vue_area_div',
	data: {
		info: js_info,
		specialist	: js_specialist,
		items		: js_items,
    },
	mounted(){
		
	},
	computed: {
		image_files: function(){
			return this.info.FILES.filter((sch,index)=>{
				return (sch.FILE_TYPE.match('image'))
			});
		},
		other_files: function(){
			return this.info.FILES.filter((sch,index)=>{
				return (!sch.FILE_TYPE.includes('image'))
			});
		},
	},
	methods: {
		onSubmitupd(){
			var vu = this;
			var theform = $("#staff_form");
			theform.find(".err_notification").addClass(E_HIDE);
				
			theform.ajaxSubmit({ 
				target:   '#targetLayer', 
				beforeSubmit: function() {
					form_progress(0);
				},
				uploadProgress: function (event, position, total, percentComplete){	
					form_progress(percentComplete);
				},
				success:function (){
					form_progress(100);
					var x = $('#targetLayer').html();
					try {
						var obj = JSON.parse(x);
						if ("Error" in obj)
						{
							error_handler(x);
						}else if("id" in obj && obj.id != 0)
						{
							alert("Data has been updated")	
						}else
						{
							alert(x);
						}
					}
					catch(err) {
						alert(err.message+"\n"+x);
					}
				},
				error:function(response,status,xhr){
					alert("error "+response);
				},
				resetForm: false
			});
			
		},
		del_img(index)
		{
			var conf = confirm("Are You sure for Deleting The file :"+this.info.FILES[index].NAME);
			if(conf)
			{
				var csr = $("#csrf").val();
				var th = this;
				$.post(MAIN_URL+"profile/del_img",{csrf:csr,file:this.info.FILES[index].NAME},function(data,status,xhr){
					try {
						alert(data);
						if(data == "The file has been deleted")
						{
							var m_ind = $("#upd_index").val();
							th.info.FILES.splice(index,1)
						}
					}
					catch(err) {
						alert(err.message+"\n"+data);
					}
				});
			}
		},
		other_item(id){
			var w = this.info.OTH_DATA.filter((sch,index)=>{
				return (sch.IT == id)
			});
			if(w.length)
			{
				return w[0].VAL;
			}else
			{
				return "";
			}
		},
	}
});
