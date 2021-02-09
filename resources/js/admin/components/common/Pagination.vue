<template>
	<form @submit.prevent='move(move_page)' class="align-items-center">
		<div>
			<!-- whoash! I couldn't do " data.from ?? 0 "  -->
			{{$t('showing_pages',{total:data.total,from:data.from ? data.from : 0,to:data.to ? data.to : 0})}}
		</div>
		<div class="align-items-center ml-20">
			<button type="button" class="button left_button bg-light-gray" :class="data.current_page==1 ? 'color-gray cursor-unset':'color-black cursor-pointer'" @click="move(data.current_page-1)">
				<span>
					<ArrowDown />
				</span>
			</button>
			<button type="button" class="button right_button bg-light-gray ml-1" :class="data.current_page==data.last_page ? 'color-gray cursor-unset':'color-black cursor-pointer'" @click="move(data.current_page+1)">
				<span>
					<ArrowDown />
				</span>
			</button>
			<form @submit.prevent="move(move_page)" class="align-items-center ml-20">
				<input type="text" v-model='move_page' class="left_button forth border-gray" :placeholder="$t('page')"/>
				<button type="submit" class="right_button width-unset border-gray bg-gray">{{$t('move_to')}}</button>
			</form>
		</div>
	</form>
</template>
<script type="text/javascript">
// mixins
import {last} from "../../mixins/common"

//icons
import ArrowDown from "../../assets//icons/ArrowDown"
export default{
	mixins:[last],
	props:{
		link:String,
		commit:String
	},
	components:{ArrowDown},
	computed:{
		data(){
			return this.$store.state[this.commit].data.res;
		}
	},
	data(){
		return{
			move_page:''
		}
	},
	methods:{
		move(num){
			if(num>0 && num<=this.data.last_page){
				this.last(this.link,this.commit,num);
			};
		}
	}
}
</script>
<style scoped>
.ml-1{
	margin-left: .1em;
}

.current{
	border:0.125em solid gray;
}

.button{
	padding:0;
	width:2.5em;
	height:2.5em;
}

.left_button{
	border-top-right-radius: 0;
	border-bottom-right-radius: 0;
}

.left_button > span > * {
	transform: rotate(-90deg);
}

.right_button > span > * {
	transform: rotate(90deg);
}

.button > span > * {
	font-size: 1.5em
}

.right_button{
	border-top-left-radius: 0;
	border-bottom-left-radius: 0;
}

input{
	border-right:none;
}

</style>