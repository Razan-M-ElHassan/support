vm_request = new Vue({
	el: '.vue_area_div',
	data: {
		request		: [],
		msg_user	: [],
		current_page: 1,
		page_no		: 0,
		page_limit	: js_page,
		
		specialist	: js_specialist,
		upd_request	: js_details,
		aarea		: js_area,
		
		
	},
	mounted(){
		this.onSubmitSearch();
		
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
				var x = vm_request;
				var cu = $('#request_search').attr('action');
				$.post(cu,$('#request_search').serializeArray(),function(data,status,xhr){
					try {
						x.request = data.data;
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
		update_request(index){
			alert(index);
			this.upd_request = this.request[index];
			this.upd_request.INDEX = index;
		},
		active(index){
			var crt= $("#csrf").val();
			var id = this.request[index]['ID'];
				
			var active = this.request[index]['R_ACC'];
			var lib = this.request;
			$.post(MAIN_URL+"requests/active",{csrf:crt,id:id,current:active},function(data,status,xhr){
				try {
					var obj = JSON.parse(data);
					if ("Error" in obj)
					{
						alert("ll: "+obj.Error)
					}else
					{
						alert("تم قبول الطلب ");
						lib[index]['ACA'] = 1;
					}
				}
				catch(err) {
					alert(err.message+"\n\n\n"+data);
				}
			})
			
		},
		
		done(index){
			var crt= $("#csrf").val();
			var id = this.request[index]['ID'];
				
			var active = this.request[index]['R_ACC'];
			var lib = this.request;
			$.post(MAIN_URL+"requests/done",{csrf:crt,id:id,current:active},function(data,status,xhr){
				try {
					var obj = JSON.parse(data);
					if ("Error" in obj)
					{
						alert("ll: "+obj.Error)
					}else
					{
						alert("تم اقفال الطلب ");
						lib[index]['DON'] = 1;
					}
				}
				catch(err) {
					alert(err.message+"\n\n\n"+data);
				}
			})
			
		},
	}
});

function modal_element($type,$id)
{
	vm_request.onSubmitSearch();
}

