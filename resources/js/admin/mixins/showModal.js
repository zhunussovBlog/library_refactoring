export default{
	methods:{
		showModal( component,props ){
            let width=props ? props.width ?? '66.5%' : '66.5%';
			this.$modal.show(component,props,{
                width:width,
                classes:['bigger-border-radius'],
                styles:'padding:1.5em;',
                shiftY:0.3
            },{});
		}
	}
}