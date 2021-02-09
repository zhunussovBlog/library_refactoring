<template>
	<form class="inputMain" @submit.prevent="submitting()" @keyup="onKeyPress($event)">
		<div class="row">
			<Select class="select border-orange bg-white" :data="selectData" label="key" v-model="type" @change="showResults()" :style="selectStyles"/>
			<div class="relative full-width row">
				<input
				type="text"
				name="search"
				v-model="query"
				:placeholder="placeholder ||this.$mobileCheck() ? $t('search') : $t('search_books&media',{type:$t(type.key+'_by')})"
				@input="showResults()"
				@blur="Choose($event)"
				autocomplete="off"
				class="no_left_border transition"
				:style="inputStyles"
				/>
				<span class="search_icon transition">
					<Search />
				</span>
			</div>
		</div>
		<div ref="results" class="results shadowed">
			<div class="result" :class="{hover:chooseIndex==index}" @mouseover='chooseIndex=index' v-for="(result,index) in results" @click="Choose();resultsClose()">
				<div class="row">
					<span class="text-no-wrap ellipsis mr-10">
						{{result.result}}
						<span v-if="result.title">, {{result.title}}</span>
						<span v-if="result.year">, {{result.year}}</span>
					</span>
					<span class="ml-auto cursor-pointer align-items-center" @click="move(result)"><Book/> &nbsp;--></span>
				</div>
			</div>
		</div>
	</form>
</template>
<script type="text/javascript">
// Sublime text 3
import {goTo} from '../../mixins/goTo'
import Select from './Select'

// icons
import Search from '../../assets/icons/Search'
import Book from '../../assets/icons/Book'
export default{
	model: {
		prop: 'value',
		event: 'input'
	},
	props:{
		placeholder:String,
		value:[Object,String],
		submitMethod:Function,
		inputStyles:[String,Array],
		selectStyles:[String,Array]
	},
	mixins:[goTo],
	components:{Select,Search,Book},
	computed:{
		selectData(){
			let types=[{key:'title'},{key:'author'},{key:'publisher'},{key:'isbn'},{key:'call_number'},{key:'all'}];
			this.type=types[0];
			return types;
		}
	},
	watch:{
		'value'(newVal,oldVal){
			this.query=newVal.query;
			if(newVal.type!=undefined && Object.keys(newVal.type).length>0){
				this.type=newVal.type;
			}
			else{
				this.type=this.selectData[0];
			}
		}
	},
	data: () => {
		return {
			query:'',
			results:[],
			type:'',
			chooseIndex:null
		};
	},
	methods:{
		async showResults(){
			const query = this.query;
			let value={query:query,type:this.type};
			this.$emit('input',value);
			if(!this.$mobileCheck()){
				try{
					this.$http.cancel();
				}
				catch(e){}
				this.$store.commit('setRequest',this.$http.CancelToken.source());
				if(query!='' && !this.$store.state.loading){
					var q =encodeURIComponent(query);
					this.$http.get('media/search/autocomplete?query=' + q+'&type='+this.type.key,{cancelToken:this.$store.state.request.token})
					.then(response => {
						this.results = response.data.res;
						this.resultsShow();
					}).catch((error)=>{
						this.resultsClose();
					});
				}
				else{
					this.resultsClose();
				}
			}
		},
		resultsClose(){
			this.chooseIndex=null;
			let doc=this.$refs.results;
			doc.style.maxHeight='0px';
		},
		resultsShow(){
			let doc=this.$refs.results;
			doc.style.maxHeight=(window.innerHeight-doc.getBoundingClientRect().top)+'px'; 
		},
		submitting(){
			try{
				this.$http.cancel();
			}
			catch(e){}
			if(this.submitMethod){
				this.submitMethod();
			}
		},
		onKeyPress(event){
			if(event.keyCode==38){
				if(this.chooseIndex==null){
					this.chooseIndex=0;

				}
				else{
					if(this.chooseIndex>0){
						this.chooseIndex-=1;
					}
				}
				this.Choose();
			}
			else if(event.keyCode==40){
				if(this.chooseIndex==null){
					this.chooseIndex=0;
				}
				else{
					if(this.chooseIndex<this.results.length-1){
						this.chooseIndex+=1;
					}
				}
				this.Choose();
			}
		},
		Choose(event){
			if(event){
				setTimeout(()=>{this.resultsClose()},200);
			}
			else{
				try{
					this.query = this.results[this.chooseIndex].result;
					let value={query:this.query,type:this.type};

					this.$emit('input',value);
				}catch(e){
				}
			}
		},
		move(result){
			console.log(result);
			this.$router.push({path:'/full?type='+result.type_key+'&id='+result.id});
		}
	}
}
</script>
<style scoped>
.inputMain{
	position: relative;
}
.results{
	width: 100%;
	min-width: 25em;
	/*this is hard /// got to improve (about 250px) */
	background: white;
	margin-top:0.3125em;
}
.result{
	padding:0.3125em;
}
.hover{
	background:#e4e4e4;
}
input{
	padding:1.125em;
	font-size: 1.125em;
	line-height: 1.3125em;
	min-width: 8.125em;
}

input::placeholder{
	color: #9C9FA7, 100%;
}
.no_left_border{
	border-left:none;
	border-top-left-radius: 0;
	border-bottom-left-radius: 0;
	padding-left:3.25em;
}

.search_icon{
	height: 100%;
	color: #9C9FA7;
	display: flex;
	align-items: center;
	position: absolute;
	left: 0;
	margin: 0 1.25em;
	font-size: 1.125em;
}

.select{
	width:20%;
	min-width: 8.125em;
	border-top-right-radius: 0;
	border-bottom-right-radius: 0;
	border-width: 0.125em;
}

input:focus,input:not(:placeholder-shown){
	padding-left: 1.125em;
}

input:focus ~ .search_icon,input:not(:placeholder-shown) ~ .search_icon{
	opacity: 0;
}

.ellipsis{
	width:90%;
	overflow: hidden;
	text-overflow: ellipsis;
}
</style>
