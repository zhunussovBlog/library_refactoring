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
			add_options:{
				id:null,
				sup_id:null,
				status_key:[],
				cost:{},
				invoice_date:{},
				create_date:{},
				edit_date:{}
			}
		},
		data:[],
		searching:false,
		sort_by:{},
		sorting_fields:{
			fields:[],
			modes:[]
		},
		statuses:[],
		per_page:10,
		page:0,
		request:{},
		pagination:true
	},
	
	items:{
		search:{
			add_options:{
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
		},
		search_default:[{key:'author',operator:'and'}],
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
		pagination:true
	},
	
	publishers:{
		search:{
			add_options:{
				name:null
			}
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
		pagination:true
	},
	
	suppliers:{
		search:{
			add_options:{
				name:null
			}
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
		pagination:true
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
		pagination:true
	},
	most_read:{
		search:{
			add_options:{
				borrow_date:{}
			}
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
		pagination:true
	},
	
	books_history:{
		search:{
			add_options:{
				barcode:null,
				id:null,
				author:null,
				title:null
			},
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
		pagination:true
	},
	books_inv_number:{
		search:{
			add_options:{
				inventory_no:null,
				rownum:null
			}
		},
		all:[],
		data:[],
		searching:false,
		sort_by:{},
		sorting_fields:{
			fields:[],
			modes:[]
		},
		per_page:10,
		page:0,
		pagination:true
	},
	print_barcode:{
		search:{
			search_options:[
			{key:'barcode',value:{}},
			{key:'title'},
			{key:'author'}
			]
		},
		search_default:[
		{key:'barcode',value:{}},
		{key:'title'},
		{key:'author'}
		],
		data:[],
		searching:false,
		sort_by:{},
		sorting_fields:{
			fields:[],
			modes:[]
		},
		per_page:10,
		page:0,
		pagination:true
	}
}