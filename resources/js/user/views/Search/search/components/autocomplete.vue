<template>
	<form @submit.prevent="submitting()" @keyup="onKeyPress($event)">
		<input type="text" autocomplete="off" class="h-100 w-100" 
		:class="input_classes"
		:placeholder="placeholder || $t('search')"
		@input="showResults()"
		@blur="Choose($event)"
		v-model="query"
		/>
		<div ref="results" class="position-absolute results bg-white shadow-sm w-100 mt-2">
			<div class="p-2" :class="{'bg-lightgrey':chooseIndex==index}" @mouseover='chooseIndex=index' v-for="(result,index) in results" :key="index" @click="Choose();resultsClose()">
				<div class="d-flex">
					<span class="ellipsis mr-10">
						{{result.result}}
						<span v-if="result.title">, {{result.title}}</span>
						<span v-if="result.year">, {{result.year}}</span>
					</span>
					<span class="ml-auto cursor-pointer align-items-center" @click="move(result)"><book /> &nbsp;--></span>
				</div>
			</div>
		</div>
	</form>
</template>
<script type="text/javascript">
// Sublime text 3
import {goTo} from '../../../../mixins/goTo'

// icons
import Book from '../../../../assets/icons/Book'
export default{
	model: {
		prop: 'value',
		event: 'input'
	},
	props:{
		placeholder:String,
		value:[Object,String],
		submit_method:Function,
		input_classes:[String,Array]
	},
	mixins:[goTo],
	components:{Book},
	watch:{
		'value'(newVal){
			this.query=newVal.query;
		}
	},
	data: () => {
		return {
			query:'',
			chooseIndex:null,
			results:[]
		};
	},
	methods:{
		showResults(){
			const query = this.query;
			let value={query:query,type:this.type};
			this.$emit('input',value);
			if(!this.$mobileCheck()){
				try{
					this.$store.state.request.cancel();
				}
				catch(e){
					console.error(e);
				}
				this.$store.commit('setRequest',this.$http.CancelToken.source());
				if(query!='' && !this.$store.state.loading){
					var q =encodeURIComponent(query);
					this.$http.get('media/autocomplete?query=' + q+'&type='+this.type.key,{cancelToken:this.$store.state.request.token})
					.then(response => {
						this.results = response.data.res;
					})
					.then(()=>{
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
				this.$store.state.request.cancel();
			}
			catch(e){
				console.error(e);
			}
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
					console.error(e);
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
.results{
	min-width: 25em;
    top: 102%;
    left: 0;
    z-index: 1000;
    overflow: hidden;
    overflow-y: auto;
    max-height: 0;
}
input::placeholder{
	color: #9C9FA7, 100%;
}
</style>
