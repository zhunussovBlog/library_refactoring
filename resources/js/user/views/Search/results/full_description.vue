<template>
	<div class="mt-4 mb-5 padding">
		<div class="d-flex">
			<div class="border border-grey rounded-lg text-grey d-flex align-items-center cursor-pointer px-2 py-1" @click="$router.go(-1);">
				<span class="rotate"><right-little/></span>
				<span>{{$t('back')}}</span>
			</div>
		</div>
		<div class="d-flex flex-wrap">
			<div class="mt-2 mr-5">
				<div class="image bg-grey rounded" :style="'background-image: url('+this.info.image+')'"/>
			</div>
			<div class="mt-2" v-if="Object.keys(data).length>0">
				<div class="mb-2" v-for="(value,key,index) in objectWithoutKey(objectWithoutKey(objectWithoutKey(data,'id'),'type_key'),'status')" v-if="value!=null">
					<div class="text-grey">{{capitalize($t(key))}} :</div>
					<div>{{value}}</div>
				</div>
				<div  v-if='Object.keys(data).length>0'>
					<div class="text-grey">{{$t('link_to_book')}} :</div>
					<a target="_blank" :href="'http://library.sdu.edu.kz/full?id='+data.id">http://library.sdu.edu.kz/full?4id={{data.id}}</a>
				</div>
			</div>
		</div>
		<div class="mt-2" v-if="info.description">
			<div class="text-grey">{{$t('description')}} :</div>
			<div>{{info.description}}</div>
		</div>
	</div>
</template>
<script type="text/javascript">
	import {goTo} from '../../../mixins/goTo'
	import {getBookImage} from '../../../mixins/search'

	import RightLittle from '../../../assets/icons/RightLittle'

	export default{
		mixins:[goTo,getBookImage],
		components:{RightLittle},
		data(){
			return{
				data:{},
				id:'',
				info:{
					image:'',
					isbn:'',
					description:''
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
				this.$http.get('media/show/'+(this.id)).then(response=>{
					this.data=response.data.res;
					this.info.isbn=this.data.isbn
					try{
						this.getBookImage(this.info,true);
					}catch(e){}
				}).catch(error=>{
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
</style>