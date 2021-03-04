export const filters={
	methods:{
		setFilters(request){
			let filter=this.$store.getters.filter_search;
			let filters=[];

			if(filter.types.length>0){
				let types=[{key:'type_key',value:filter.types.map(type=>type.value)}];
				filters=filters.concat(types);
			}
			if(filter.languages.length>0){
				let languages=[{key:'language',value:filter.languages}];
				filters=filters.concat(languages);
			}
			if(filter.year.value!=''){
				let year=[{key:'year',value:filter.year.value}];
				filters=filters.concat(year);
			}

			if(filters.length>0){
				request.filter=filters;
			}
		}
	}
}