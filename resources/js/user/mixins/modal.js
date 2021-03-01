export default{
	methods:{
		showModal( component,props ){
            let width=props ? props.width ?? '66.5%' : '66.5%';
			this.$modal.show(component,props,{
                width:width,
                classes:['rounded'],
                styles:'padding:0.9375em;',
                shiftY:0.3
            },{});
		}
	}
}