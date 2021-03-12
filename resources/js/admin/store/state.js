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
			id:null,
			sup_id:null,
			status_key:[],
			cost:{},
			invoice_date:{},
			create_date:{},
			edit_date:{}
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
			publisher_id:null,
			pub_year:null,
			pub_city:null,
			supplier_id:null,
			sup_type:null,
			location:null,
			item_type:null,
			user_cid:null,
			create_date:{},
			cost:{},
		},
		search_options:[{key:'author',operator:'and'}],
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
		search:{
			name:null
		},
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
		search:{
			name:null
		},
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