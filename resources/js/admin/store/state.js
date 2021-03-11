export default {
	user:{},

	fullPageLoading:false,

	// every page with the table follows like the same stucture
	// it has: 
	//	data 			--> the data in table
	// 	searching 		--> if you could see the table : true means table is visible
	// 	sort_by 		--> if the table is sortable by backend - this is what ur searching with
	// 	sorting_fields 	--> if the table is sortaable by backend - these are sorting fields
	// 	per_page 		--> number of resluts per page ( may later turn it to some configuration and display the same number of results per page for all pages )
	// 	page 			--> the page ur currently on

	// addititional: ( on items and batches )
	// 	search 			--> what ur searching with


	batches:{
		search:{
			batch_id:null,
			sup_id:null,
			statuses:[],
			from_cost:null,
			until_cost:null,
			start_date:null,
			end_date:null
		},
		data:[],
		searching:false,
		sort_by:{},
		sorting_fields:{
			fields:[],
			modes:[]
		},
		per_page:10,
		page:0
	},
	
	items:{
		search:{
			search_options:[{key:'author',operator:'and'}],
			publisher_id:null,
			pub_year:null,
			pub_city:null,
			supplier_id:null,
			sup_type:null,
			from_cost:null,
			until_cost:null,
			start_date:null,
			end_date:null,
			item_type:null,
			user_cid:null,
			location:null
		},
		search_fields:[],
		data:[],
		searching:false,
		sort_by:{},
		sorting_fields:{
			fields:[],
			modes:[]
		},
		per_page:10,
		page:0,
	},
	
	publishers:{
		data:[],
		searching:false,
		sort_by:{},
		sorting_fields:{
			fields:[],
			modes:[]
		},
		per_page:10,
		page:0,
	},
	
	suppliers:{
		data:[],
		searching:false,
		sort_by:{},
		sorting_fields:{
			fields:[],
			modes:[]
		},
		per_page:10,
		page:0,
	},
	
	users:{
		data:[],
		heads:[],
		searching:false,
		sort_by:{},
		sorting_fields:{
			fields:[],
			modes:[]
		},
		per_page:10,
		page:0,
	},
	most_read:{
		data:[],
		searching:false,
		sort_by:{},
		sorting_fields:{
			fields:[],
			modes:[]
		},
		per_page:10,
		page:0,
	},
	
	books_history:{
		data:[],
		searching:false,
		sort_by:{},
		sorting_fields:{
			fields:[],
			modes:[]
		},
		per_page:10,
		page:0,
	},
	books_inv_number:{
		data:[],
		searching:false,
		sort_by:{},
		sorting_fields:{
			fields:[],
			modes:[]
		},
		per_page:10,
		page:0,
	},
	print_barcode:{
		data:[],
		searching:false,
		sort_by:{},
		sorting_fields:{
			fields:[],
			modes:[]
		},
		per_page:10,
		page:0,
	}
}