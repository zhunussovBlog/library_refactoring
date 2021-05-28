<template>
<div class="bg-greyer padding">
	<div class="d-flex align-items-start bg-white border-top py-4 px-5">
		<div class="mr-5">
			<div class="image rounded bg-grey" :style="'background-image: url('+this.info.image+')'"></div>
		</div>
		<div class="flex-fill">
			<div class="d-flex flex-fill">
				<div class="flex-fill">
					<div class="overflow-hidden title font-weight-bold font-size-24 cursor-pointer">{{data.title}}</div>
					<div class="text-grey mt-2">
						<div v-if="data.author">{{data.author}}, {{data.year}}</div>
					</div>
					<div class="d-flex text-center text-blue mt-3">
						<div class="rounded-lg bg-lightblue p-1 px-3" v-if="data.type">{{$t(data.type)}}</div>
						<div class="rounded-lg bg-lightblue p-1 px-3 ml-3" v-if="data.call_number">{{data.call_number}}</div>
					</div>
				</div>
				<div class="text-center col-2 px-0">
					<div class="bg-lightgrey rounded-lg p-2 text-no-wrap">
						{{data.availability}}
						{{$t('availability')}}
					</div>
				</div>
			</div>
			<div class="mt-3" v-if="info.description">
				<div class="text-grey font-size-14">
					{{$t('description')}}
				</div>
				<div class="mt-1" >
					{{info.description}}
				</div>
			</div>
			<div class="mt-3" v-if="info.content">
				<div class="text-grey font-size-14">
					{{$t('content')}}
				</div>
				<div class="mt-1" >
					{{info.content}}
				</div>
			</div>
			<div class="title mt-4">
				<div class="text">
					{{$t('details')}}
				</div>
				<div class="tline"/>
			</div>
		</div>
	</div>
	<!-- fixed stuff -->
	<div class="exit cursor-pointer" @click="$emit('close')">
		<X/>
	</div>
</div>
</template>
<script type="text/javascript">
	import {goTo} from '../../../mixins/goTo'
	import {getBookImage} from '../../../mixins/search'

	import RightLittle from '../../../assets/icons/RightLittle'
	import X from '../../../assets/icons/X'

	export default{
		mixins:[goTo,getBookImage],
		components:{RightLittle,X},
		data(){
			return{
				data:{},
				id:'',
				info:{
					image:'',
					isbn:'',
					description:'',
					content:''
				}
			}
		},
		methods:{
			capitalize(s){
				let string = s.slice();
				if (typeof string !== 'string') return ''
					return string.charAt(0).toUpperCase() + string.slice(1)
			},
			objectWithoutKey(object,key){
				const {[key]: deletedKey, ...otherKeys} = object;
				return otherKeys;
			},
			loadData(){
				this.$store.commit('setFullPageLoading',true);
				this.$http.get('api/media/show/149293').then(response=>{
					this.data=response.data.res;
					this.info.isbn=this.data.isbn
					try{
						this.getBookImage(this.info,true);
					}catch(e){}
					console.log(this.info);
				}).catch(error=>{
					console.log(error);
					this.goTo('home');
				}).then(()=>{
					this.$store.commit('setFullPageLoading',false);
				});
			}
		},
		created(){
			this.id=this.$route.query.id;
			this.loadData();
		}
	}
</script>
<style scoped>
.image{
	min-width:12em;
	max-width:12em;
	min-height:15em;
	max-height:15em;
	background-repeat: no-repeat;
	background-size: 100% 100%;
}
.bg-greyer{
	background: #a2a6a8 !important;
}
.exit{
	color:white;
	position: fixed;
	top:10%;
	right:4%;
}
.title{
	font-size: 1.125em;
	display:flex;
	align-items:center;
}
.title>.text{
	padding:.3125em;
}
.title>.tline{
	height:1px;
	flex:1;
	background:#DADADA;
}
</style>