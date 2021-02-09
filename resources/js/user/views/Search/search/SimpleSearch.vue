<template>
	<div class="main mb-40 relative">
		<form class="justify-content-between flex-wrap-sm" @submit.prevent="getResults()">
			<div id='warn-simple' class="warn">{{$t('at_least_2')}}</div>
			<inputAutocomplete class="searchInput mr--5" :warn="warn" v-model="search" :submitMethod="getResults" :inputStyles="inputStyles" :selectStyles="selectStyles"/>
			<button class="searchButton" type="submit">{{$t('search')}}</button>
		</form>
		<div class="link" :class="{'color-white' : $route.meta.backgrounded}" @click="method(1)">
			<span>
				<Blocks />
			</span> &nbsp;
			{{$t('advanced_search')}}
		</div>
	</div>
</template>
<script>
// @/components/common/SearchInputAutocomplete <- this is where it is from
import inputAutocomplete from '../../../components/common/InputAutocomplete'

// encodeURIComponent, validate if string is bigger than 2 and show warning
import {encode,validate,warn} from '../../../mixins/validation'
import {scrollTo,goTo} from '../../../mixins/goTo'


// icons
import Blocks from '../../../assets/icons/Blocks'
export default{
	mixins:[encode,validate,warn,scrollTo,goTo],
	components:{inputAutocomplete,Blocks},
	props:{
		// this is advanced search link function
		method:Function
	},
	computed:{
		inputStyles(){
			let ans='border-top-right-radius:0;border-bottom-right-radius:0;';
			return (window.innerWidth > 420 ? ans: '') +(this.$route.meta.backgrounded ? 'border-color:transparent;':'');
		},
		selectStyles(){
			return this.$route.meta.backgrounded ? 'border-top:none;border-bottom:none;border-left:none;' : '';
		}
	},
	data(){
		return{
			search:{}
		}
	},
	methods:{
		getResults(){
			let query=this.search.query;
			let type =this.search.type.key;
			let search={query:query,type:type};
			let queries=[search];
			if(this.validate(query,false) && !this.$store.getters.loading){
				this.warn('simple',false);
				this.$store.commit('setLoading',true);
				this.$store.commit('setResults',{});
				this.$store.commit('setQueries',copy(queries));
				this.$http.post('media/search/simple',{queries}).then(response => {
					this.$store.commit('setSearchType','simple');
					this.$store.commit('setLoading',false);
					this.$store.commit('setResults',response.data.res);
					this.$store.commit('setFilters',response.data.filter);
					if(this.$route.name=="home"){
						this.goTo('search');
					}
					setTimeout(()=>{this.scrollTo('results')},100);
				}).catch((error)=>{
					this.$store.commit('setLoading',false);
					this.$store.commit('setResults',{});
					if(this.$route.name=="home"){
						this.goTo('search');
					}
					setTimeout(()=>{this.scrollTo('results')},100);
				});
			}
			else{
				this.warn('simple',true);
			}
		}
	}
}
</script>
<style scoped>
.searchInput{
	width: 100%;
}
/*well, later gotta import it in one css file with advanced search styles*/
.link{
	margin-top: 2.7vh;
}
button{
	padding-left: 2.5em;
	padding-right: 2.5em;
}
.warn{
	top:-1.4375em;
}
.mr--5{
	margin-right: -0.3125em;
}
</style>
