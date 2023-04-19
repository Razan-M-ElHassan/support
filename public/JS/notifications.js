vm_profile = new Vue({
	el: '#profile_noti_area',
	
	data: {
		messages	: [],
		notification: [],
		new_msg		: 0,
		new_noti	: 0,
		timer		: '',
		
    },
	mounted(){
		if($('#profile_noti_area').length)
		{
			this.fetchData();  
			this.timer = setInterval(this.fetchData, 10000);  
		}
	},
	methods:{
		async fetchData() {  
			const res = await fetch(MAIN_URL+"profile/noti");  
			const data = await res.json();
			this.messages = data['MSG'];
			this.notification = data['NOTI'];
			this.new_msg = data['NEW_MSG'];
			this.new_noti = data['NEW_NOTI'];
		},
		async read_noti(id)
		{
			const res = await fetch(MAIN_URL+"profile/noti_read/"+id);  
			const data = await res.text();
		},
		async all_read()
		{
			const res = await fetch(MAIN_URL+"profile/noti_all_read/");  
			const data = await res.text();
			this.fetchData();
		}
	}
});

