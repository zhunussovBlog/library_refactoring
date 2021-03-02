<template>
	<form class="position-relative">
		<select-div :data="select_data" label="key" class="w-20 w-min-120 p-3 border-grey no-border-right no-border-right-radius border-width bg-white" v-model="type"/>
		<div id="warn-simple" class="warn">{{$t('at_least_2')}}</div>
		<autocomplete class="w-100 mr--5" input_classes="rounded-0 border-grey" :placeholder="$t('search_books&media',{type:$t(type.key+'_by')})" v-model="query" :results="autocomplete_results" :submit_method="search"/>
		<button type="submit" class="border-grey w-min-120">{{$t('search')}}</button>
	</form>
</template>
<script type="text/javascript">
	import SelectDiv from '../../../../../components/select'
	import autocomplete from '../../components/autocomplete'
	export default{
		components:{
			SelectDiv,
			autocomplete
		},
		data(){
			return{
				select_data:[{key:'default'}],
				query:'',
				type:'',
				autocomplete_results:[]
			}
		},
		watch:{
			query(newValue){
				this.getAutocomplete();
			}
		},
		methods:{
			getAutocomplete(){
				if(!this.$mobileCheck()){
					try{
						this.$store.getters.request.cancel();
					}
					catch(e){}
					this.$store.commit('setRequest',this.$http.CancelToken.source());
					if(this.query!='' && !this.$store.getters.loading){
						this.$http.get('media/autocomplete?value=' + this.query+'&key='+this.type.key+'&max='+10,{cancelToken:this.$store.getters.request.token})
						.then(response => {
							this.autocomplete_results = response.data.res;
						})
					}
				}
			},
			getSearchFields(){
				this.$http.get('media/search-fields').then(response=>{
					this.select_data=response.data.res.search_options;
					this.type=this.select_data[0];
				})
			},
			search(){
				this.results_shown=false;
			}
		},
		created(){
			this.getSearchFields();
		}
	}
</script>
