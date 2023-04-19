vm_co = new Vue({
	el: '.vue_area_div',
	data: {
		TYPES	: js_types,
		upd_type: [],
		
    },
	mounted(){
		
	},
	methods: {
		update_type(index) {
			this.upd_type = this.TYPES[index];
			this.upd_type['INDEX'] = index;
		},
	}
});


function modal_element($type,$id)
{
	switch($type)
	{
		case "new_spec":
			var obj = {};
			obj.ID 	= $id;
			obj.NAME= $("#new_name").val();
			obj.CITY= $("#new_city").val();
			obj.STU	= 0;
			Vue.set(vm_co.TYPES, vm_co.TYPES.length, obj);
		break;
		case "upd_spec":
			var index = vm_co.upd_type['INDEX'];
			Vue.set(vm_co.TYPES[index], 'NAME', $("#upd_name").val());
			Vue.set(vm_co.TYPES[index], 'CITY', $("#upd_city").val());
		break;
		case "del_spec":
			var index = vm_co.TYPES['INDEX'];
			vm_co.TYPES.splice(index,1);
		break;
		
	}
}
