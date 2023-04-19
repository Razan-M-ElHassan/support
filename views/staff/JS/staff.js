vm_staff = new Vue({
	el: '.vue_area_div',
	data: {
		staff		: [],
		upd_staff	: js_details,
		msg_user	: [],
		current_page: 1,
		page_no		: 0,
		page_limit	: js_page,
		permission	: js_permission,
		specialist	: js_specialist,
		items		: js_items,
		countries	: js_countries,
		CURR_NAT	: "SA",
	},
	mounted(){
		this.onSubmitSearch();
	},
	computed: {
		image_files: function(){
			return this.upd_staff.FILES.filter((sch,index)=>{
				return (sch.FILE_TYPE.match('image'))
			});
		},
		other_files: function(){
			return this.upd_staff.FILES.filter((sch,index)=>{
				return (!sch.FILE_TYPE.includes('image'))
			});
		}
	},
	methods: {
		//For Paging:
		prev_page(){
			this.current_page --;
			if(this.current_page < 1)
			{
				this.current_page = 1;
			}
			this.onSubmitSearch();
		},
		next_page(){
			this.current_page ++;
			if(this.current_page > this.page_no)
			{
				this.current_page = this.page_no;
			}
			this.onSubmitSearch();
		},
		set_page(id=1){
			this.current_page = id;
			if(this.current_page > this.page_no)
			{
				this.current_page = this.page_no;
			}else if(this.current_page < 1)
			{
				this.current_page = 1;
			}
			this.onSubmitSearch();
		},
		set_first_page()
		{
			this.current_page = 1;
		},
		all_data(){
			this.current_page = 1;
			this.onSubmitSearch();
		},
		onSubmitSearch() {
			setTimeout(function(){
				var x = vm_staff;
				var cu = $('#Staff_search').attr('action');
				$.post(cu,$('#Staff_search').serializeArray(),function(data,status,xhr){
					try {
						x.staff = data.data;
						//set Pageing
						var total_no 	= data.total_no;
						if(total_no <= 0)
						{
							x.page_no = 0;
							return;
						}
						if(!$("#all_data").is(':checked'))
						{
							x.page_no		= total_no / x.page_limit;
							if(x.page_no != parseInt(x.page_no))
							{
								x.page_no = parseInt(x.page_no) + 1;
							}
						}else
						{
							x.page_no = 1;
						}
					}
					catch(err) {
						alert(err.message+"\n"+data);
					}
				},'JSON');
			},500);
			
		},
		update_staff(index){
			this.upd_staff = this.staff[index];
			this.upd_staff.INDEX = index;
		},
		other_item(stu,id){
			var w = stu.filter((sch,index)=>{
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
		active(index){
			var crt= $("#csrf").val();
			var id = this.staff[index]['ID'];
				
			var active = this.staff[index]['ACTIVE'] == 1;
			var lib = this.staff;
			$.post(MAIN_URL+"staff/active",{csrf:crt,id:id,current:active,oth_user:0},function(data,status,xhr){
				try {
					var obj = JSON.parse(data);
					if ("Error" in obj)
					{
						alert("ll: "+obj.Error)
					}else
					{
						alert("تم تنشيط / تجميد المستخدم ");
						lib[index]['ACTIVE'] = (lib[index]['ACTIVE'] == 1)?0:1;
					}
				}
				catch(err) {
					alert(err.message+"\n\n\n"+data);
				}
			})
			
		},
		change_msg(){
			var x = $("#msgs").prop('checked');
			$('.msgs').prop('checked',x);
		},
		message(){
			var no = $('.msgs:checked').length;
			if(no == 0)
			{
				alert('Please select User firstً');
				return;
			}
			this.msg_user.splice(0);
			x = this;
			$i = 0;
			
			$( ".msgs" ).each(function( index ) {
				if($(this).is(':checked'))
				{
					Vue.set(x.msg_user, $i, $(this).data('id'));
					$i += 1;
				}
			});
			
			$('#msg_staff').modal('show');
		},
		send_msg(){
			var postData = $('#msg_staff_form').serializeArray();
			x = this;
			$.post(MAIN_URL+"staff/msg_staff",postData,function(data,status,xhr)
			{
				try {
					var obj = JSON.parse(data);
					if ("Error" in obj)
					{
						error_handler(data);
					}else if("total" in obj && obj.total != 0)
					{
						alert("No of. "+obj.sms+" SMS Has been sent \n No of. "+obj.email+" Email Has been Sent \n");
						close_form_dialog($('#msg_staff_form'));
						x.msg_user.splice(0);
						$('#msg_staff').modal('hide');
					}else
					{
						alert(data);
					}
				}
				catch(err) {
					alert(err.message+"\n"+data);
				}
			})
		}
	}
});

function modal_element($type,$id)
{
	switch($type)
	{
		case "new":
		case "upd":
		case "del":
		case "freez":
			vm_staff.onSubmitSearch();
		break;
	}
}

//////////////////////////////////////////////////////MSG Staff
$(document).on('change','#msgs', function (e) 
{
	var x = $(this).prop('checked');
	$('.msgs').prop('checked',x);
})
//////////////////////////////////////////////////////End MSG Staff

