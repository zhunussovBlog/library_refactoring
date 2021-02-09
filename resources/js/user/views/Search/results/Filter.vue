<template>
	<div class="bg-light-gray border-radius border-box no-shrink filter-width filter-parent">
		<div class="font-weight-500">{{$t('filter')}}</div>
		<div class="mt-20">
			<div class="text-little color-gray">{{$t('types')}}: </div>
			<div class="row justify-content-between mt-10" v-for="(type,index) in data.types" :key="index">
				<div>{{$t(type.type)}}</div>
				<Checkbox @change="checkType(type)" :checked="filter.types.some(e => e.type_key == type.type_key)" :disabled="data.types.length<2"/>
				</div>
			</div>
			<!-- for now this part is depricated -->
			<!-- languages -->
			<!-- <div class="mt-20">
				<div class="text-little color-gray">{{$t('languages')}}: </div>
				<div class="row justify-content-between mt-10">
					<div>{{$t('english')}}</div>
					<Checkbox/>
				</div>
				<div class="row justify-content-between mt-10">
					<div>{{$t('russian')}}</div>
					<Checkbox/>
				</div>
				<div class="row justify-content-between mt-10">
					<div>{{$t('kazakh')}}</div>
					<Checkbox/>
				</div>
			</div> -->
			<div class="mt-20">
				<div class="text-little color-gray">{{$t('year')}}: </div>
				<Select class="mt-10 full-width border-dark-gray" :data="data.years" v-model="$store.state.filter.year" :defaultAll="true"/>
			</div>
			<div class="mt-20">
				<div class="justify-content-center align-items-center button color-orange cursor-pointer" :class="{shadowed:filtering}" @click="getResults()">
					<Refresh class="refresh"/> {{$t('apply')}}
				</div>
			</div>
		</div>
	</template>
	<script type="text/javascript">
// icons
import Refresh from '../../../assets/icons/Refresh'

// components
import Checkbox from '../../../components/common/Checkbox'
import Select from '../../../components/common/Select'

// mixins
import {encode} from '../../../mixins/validation'

export default{
	mixins:[encode],
	components:{Refresh,Checkbox,Select},
	computed:{
		data(){
			return this.$store.getters.filters;
		},
		filter(){
			return this.$store.getters.filter;
		},
		filtering(){
			return this.$store.getters.filtering;
		}
	},
	methods:{
		getResults(){
			this.$store.commit('setFiltering',true);
			this.$store.commit('setLoading',true);
			let filter=copy(this.filter);
			let types=[]
			filter.types.forEach(type=>{
				types.push(type.type_key);
			})
			filter.types=types;

			this.$http.post('media/search/filter',filter).then(response=>{
				this.$store.commit('setResults',response.data.res);
				this.$store.commit('setLoading',false);
			}).catch(error=>{
				this.$store.dispatch('emptyFilters');
				this.$store.commit('setLoading',false);
				this.$store.commit('setResults',{});
			});
		},
		checkType(type){
			let filter=this.filter;
			if(filter.types.some(e => e.type_key == type.type_key)){
				filter.types=filter.types.filter(item => item.type_key !== type.type_key);
			}
			else{
				filter.types.push(type)
			}
		}
	}
}
</script>
<style scoped>
select{
	border-style: none;
}
.button{
	height:2.5em;
	background-color: white
}
.refresh{
	font-size: 1.25em;
}
</style>