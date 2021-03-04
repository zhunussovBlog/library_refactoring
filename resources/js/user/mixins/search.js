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
export const selectData={
	data(){
		return{
			select_data:[
			{
				key:'all',
				name:'all_search'
			},
			{
				key:'title',
				name:'title'
			},
			{
				key:'author',
				name:'author'
			},
			{
				key:'publisher',
				name:'publisher'
			},
			{
				key:'isbn',
				name:'isbn'
			},
			{
				key:'call_number',
				name:'call_number'
			}]
		}
	}
}
export const getBookImage={
	methods:{
		getBookImage(info,description){
			// we use fetch() because there's cors mistake when use this.$http
			fetch("https://www.googleapis.com/books/v1/volumes?q=isbn:"+info.isbn).then(response=>{
				response.json().then(data=>{
					try{
						info.image=data.items[0].volumeInfo.imageLinks.thumbnail;
						if(description){
							info.description=data.items[0].volumeInfo.description;
						}
					}catch(e){
						fetch("https://www.googleapis.com/books/v1/volumes?q=isbn:0"+info.isbn).then(response=>{
							response.json().then(data=>{
								try{
									info.image=data.items[0].volumeInfo.imageLinks.thumbnail;
									if(description){
										info.description=data.items[0].volumeInfo.description;
									}
								}catch(e){
									info.image='';
								}
							})
						})
					}
				})
			})
		}
	}
}