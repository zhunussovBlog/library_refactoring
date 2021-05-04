export default {
	// auth
	access_token:(state)=>{
		let token=localStorage.getItem('access_token');
		if(state.user!=null){
			if(state.user.access_token){
				token=state.user.access_token
			}
		}
		return token
	},
	
	// authorized user
	user:state=>state.user,

	fullPageLoading:state=>state.fullPageLoading,
	
	batches:state=>state.batches,
	
	items:state=>state.items,
	print_barcode:state=>state.print_barcode,
	
	publishers:state=>state.publishers,
	
	suppliers:state=>state.suppliers,

	most_read:state=>state.most_read,
	
	books_history:state=>state.books_history,
	books_inv_number:state=>state.books_inv_number,
	
	// service desk
	users:state=>state.users,
}
