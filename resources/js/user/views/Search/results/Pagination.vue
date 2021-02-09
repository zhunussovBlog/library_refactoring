<template>
	<div id="pagination" class="row">
		<div class="align-items-center bg-light-gray border-radius plr-20 mr-20 mt-5" :class="{'n-06':noDesc}">
			<div :class="{'cursor-pointer':data.current_page!=1}" @click="movePrev()">
				<RightLittle class="rotate" :class="{'color-gray':data.current_page==1}"/>
			</div>
			<div class="relative align-items-center color-gray mlr-10">
				<div class="wrapper wrapperRect border-box transition" />
				<div class="wrapper" v-for="page in pages" @click="getResults(page);">{{page}}</div>
			</div>
			<div :class="{'cursor-pointer':data.current_page!=data.last_page}" @click="moveNext()">
				<RightLittle :class="{'color-gray':data.current_page==data.last_page}"/>
			</div>
		</div>
		<div class="align-items-center bg-light-gray border-radius plr-20 mt-5" :class="{'n-06':noForth}">
			<div>
				{{$t('to_page')}} : &nbsp;
			</div>
			<form @submit.prevent="getResults(inputPage);" class="align-items-center">
				<input class="border-radius border border-dark-gray color-dark-gray" type="text" v-model="inputPage"/>
				&nbsp;
				&nbsp;
				<button type="submit" class="color-black"><RightLong /></button>
			</form>
		</div>
	</div>
</template>
<script type="text/javascript">
// icons
import RightLittle from '../../../assets/icons/RightLittle'	
import RightLong from '../../../assets/icons/RightLong'

// mixins	
import {encode} from '../../../mixins/validation'
export default {
	props:{
		noDesc:Boolean,
		noForth:Boolean
	},
	mixins:[encode],
	components:{RightLittle,RightLong},
	computed:{
		pages(){
			let range=this.data.last_page>5 ? (window.innerWidth>500 ? 5 : 4) : this.data.last_page;
			return this.paginate(range);
		},
		data(){
			return this.$store.getters.results;
		},
		wrapperIndex(){
			return this.$store.getters.wrapperIndex;
		},
	},
	data(){
		return{
			inputPage:null
		}
	},
	methods:{
		moveRect(){
			try{
				let rects=document.getElementsByClassName('wrapperRect');
				for(let rect of rects){
					rect.style.left=rect.offsetWidth*this.wrapperIndex+'px';
				}
			}
			catch(e){
			}
		},
		moveNext(){
			this.getResults(this.data.current_page+1);
		},
		movePrev(){
			this.getResults(this.data.current_page-1);
		},
		getResults(page){
			if(!(page>this.data.last_page || page<1)){
				this.$store.commit('setLoading',true);
				let filtering=this.$store.state.filtering;
				let search='';
				if(filtering){
					search='filter'
				}
				else{
					search=this.$store.state.search_type;
				};
				this.$http.post('media/search/'+search,{page:page}).then(response=>{
						this.$store.commit('setResults',response.data.res);
						this.$store.commit('setLoading',false);
					})
			}
		},
		paginate(range){

			// found this code in internet 

			// https://codereview.stackexchange.com/questions/183417/pagination-algorithm-in-js
			
			let currentPage = this.data.current_page; 
			let totalPages  = this.data.last_page;  
			let start       = 1; 
			let paging = [];     

			if (currentPage < (range / 2) + 1 ) {
				start = 1;

			} else if (currentPage >= (totalPages - (range / 2) )) {
				start = Math.floor(totalPages - range + 1);

			} else {
				start = (currentPage - Math.floor(range / 2));
			}

			for (let i = start,move=0; i <= ((start + range) - 1); i++,move++) {
				if (i == currentPage) {
					if(move!=this.wrapperIndex){
						this.$store.commit('setWrapperIndex',move);
						this.moveRect();
					}
				}
				paging.push(i.toString());
			}
			return paging;
		}
	},
	mounted(){
		this.moveRect();
	}
}
</script>
<style scoped>
.wrapper{
	width:3.43em;
	height:3.125em;
	display: flex;
	align-items: center;
	justify-content: center;
	cursor: pointer;
}
.wrapperRect{
	position: absolute;
	top:0;
	left:0;
	border-radius: 0.3125em;
	border: 0.09375em solid #FF9D29;

}
input{
	min-width: 0;
	padding: 0;
	text-align: center;
	width: 3.75em;
	height:1.875em;
}
button{
	padding: 0;
	background-color: transparent;
	border-color: transparent;
}
</style>