<template>
	<div class="main mb-40">
		<form id="advanced" @submit.prevent="getResults()">
			<div class="row relative" v-for="(input,index) in inputs" :key="index" :class="{'mt-20':index!=0}">
				<div :id="'warn-'+index" class="warn">{{$t('at_least_2')}}</div>
				<inputAutocomplete class="full-width" v-model="input.search" :submitMethod="getResults" :inputStyles="inputStyles" :selectStyles="selectStyles"/>
				<Select v-model="inputs[index+1].operator" class="select ml-20 border-orange bg-white" :data="operations" v-if="index<(inputs.length-1)" :style="inputStyles"/>
				<button type="button" class="addButton ml-20" @click="addItem()" v-if="!(index<(inputs.length-1)) && index<maximum-1"> + </button>
			</div>
			<div class="justify-content-between flex-wrap mt-20">
				<button type="button" @click="clear()">{{$t('reset')}}</button>
				<button type="submit" >{{$t('search')}}</button>
			</div>
		</form>
		<u class="link" :class="{'color-white' : $route.meta.backgrounded}" @click="method(0)">{{$t('simple_search')}}</u>
	</div>
</template>
<script type="text/javascript">
// validate inputs for 2 characters and warn
import {validate,warn} from '../../../mixins/validation'
import {scrollTo,goTo} from '../../../mixins/goTo'

// components
import inputAutocomplete from '../../../components/common/InputAutocomplete'
import Select from '../../../components/common/Select'
export default{
	mixins:[validate,warn,scrollTo,goTo],
	props:{
		// methods is to switch to simple search
		method:Function,
		maximum:{
			type:[Number,String],
			default(){
				return 5
			}
		}
	},
	components:{inputAutocomplete,Select},
	computed:{
		inputStyles(){
			return this.$route.meta.backgrounded ? 'border-color:transparent;':'';
		},
		selectStyles(){
			return this.$route.meta.backgrounded ? 'border-top:none;border-bottom:none;border-left:none;' : '';
		}
	},
	data(){
		return{
			operations:['and','or','not'],
			inputs:[{search:{}},{search:{},operator:'and'}]
		}
	},
	methods:{
		addItem(){
			if(this.inputs.length<this.maximum){
				this.inputs.push({search:{},operator:'and'});
			}
		},
		clear(){
			this.inputs=[{search:{}},{search:{},operator:'and'}];
		},
		getResults(){
			let valid=0;
			// idet validaciya kazhdogo inputa
			for(let index =0;index<this.inputs.length;index++){
				let item=this.inputs[index];
				try{
					if(item.search!=null){
						item.query=item.search.query;
						item.type=item.search.type.key;
					}
					if(this.validate(item.query,false)){
						this.warn(index,false);
						valid+=1;
					}
					else{
						this.warn(index,true);
					}
					item=objectWithoutKey(this.inputs[index],'search');
				}catch(e){
					this.warn(index,true);
				}
			}
			console.log(this.inputs);
			if(valid==this.inputs.length && !this.$store.getters.loading){
				this.$store.commit('setQueries',copy(this.inputs));
				this.$store.commit('setLoading',true);
				this.$store.commit("setResults",{});
				this.$http.post('media/search/advanced',{queries:this.inputs},)
				.then(response => {
					this.$store.commit('setResults',response.data.res);
					this.$store.commit('setFilters',response.data.filter);
					if(this.$route.name=="home"){
						this.goTo('search');
					}
					this.$store.commit('setLoading',false);
					setTimeout(()=>{this.scrollTo('results')},100);
				})
				.catch((error)=>{
					this.$store.commit('setResults',{});
					if(this.$route.name=="home"){
						this.goTo('search');
					}
					this.$store.commit('setLoading',false);
					setTimeout(()=>{this.scrollTo('results')},100);
				});
			}
		}
	},
	activated(){
		this.$store.commit('setSearchType','advanced');
	},
	deactivated(){
		this.$store.commit('setSearchType','simple');
	}
}
</script>
<style scoped>
.row{
	width:100%;
	min-width: 14.0625em;
}
.warn{
	top:-1.125em;
}
/*smth shared among with simple search vue component*/
.link{
	margin-top: max(1.25em,2.7vh);
}
button{
	line-height: 1.3125em;
	color:white;
}
.select,.addButton{
	min-width: 13%;
}
.select{
	border-width: 0.125em;
}
</style>
