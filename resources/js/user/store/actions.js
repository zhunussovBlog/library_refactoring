export default {
	emptyResults({commit}){
		commit('setResults',[]);
	},
	emptyFilters(store){
		store.state.filter={
			types:[],
			year:''
		};
	}
}
