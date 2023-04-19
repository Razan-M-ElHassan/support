vm_landsearch = new Vue({
	el: '.vue_area_div',
	data: {
		staff		: [],
		upd_staff	: js_details,
		current_page: 1,
		page_no		: 0,
		page_limit	: js_page,
		specialist	: js_specialist,
		aarea		: js_area,
    },
	created: function() {
		this.onSubmitSearch();
		
    },

	mounted(){
		
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
		},
		
	},
	watch: {
		
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
				var x = vm_landsearch;
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
		}
	}
});

function modal_element($type,$id)
{
	
}
