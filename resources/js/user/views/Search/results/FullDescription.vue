<template>
	<div class="mt-30 mb-40 padding text-choosable">
		<div>
			<back/>
		</div>
		<div class="row flex-wrap">
			<div class="mt-10 mr-60">
				<div class="image bg-gray border-radius" :style="'background-image: url('+this.image+')'"/>
				<!-- this part is depricated for now -->
				<!-- <button class="bg-green color-white mt-15 full-width">{{$t('reserve')}}</button> -->
			</div>
			<div class="mt-10" v-if="Object.keys(data).length>0">
				<div v-for="(value,key,index) in objectWithoutKey(objectWithoutKey(objectWithoutKey(data,'id'),'type_key'),'status')" v-if="value!=null">
					<div class="color-gray">{{capitalize($t(key))}} :</div>
					<div>{{value}}</div>
					&nbsp;
				</div>
				<div  v-if='Object.keys(data).length>0'>
					<div class="color-gray">{{$t('link_to_book')}} :</div>
					<a target="_blank" :href="'http://library.sdu.edu.kz/full?type='+data.type_key+'&id='+data.id">http://library.sdu.edu.kz/full?type={{data.type_key}}&id={{data.id}}</a>
				</div>
			</div>
		</div>
		<div class="mt-10" v-if="description">
			<div class="color-gray">{{$t('description')}} :</div>
			<div>{{description}}</div>
		</div>
	</div>
</template>
<script type="text/javascript">
// mixins
import {goTo} from '../../../mixins/goTo'
import back from '../../../components/common/Back'
export default{
	mixins:[goTo],
	components:{back},
	data(){
		return{
			data:{},
			type:this.$store.state.media.type,
			id:this.$store.state.media.id,
			image:'',
			description:''
		}
	},
	methods:{
		capitalize(e){
			return capitalize(copy(e));
		},
		objectWithoutKey(obj,key){
			return objectWithoutKey(obj,key);
		},
		loadData(){
			this.$store.commit('setLoading',true);
			this.$http.get('media/show?id='+(this.$route.query.id || this.id)+'&type='+(this.$route.query.type || this.type)+'&lang='+this.$i18n.locale).then(response=>{
				this.data=response.data.res;
				// because there's cors mistake when use this.$http
				fetch("https://www.googleapis.com/books/v1/volumes?q=isbn:"+this.data.isbn).then(response=>{
					response.json().then(data=>{
						try{
							this.image=data.items[0].volumeInfo.imageLinks.thumbnail;
							this.description=data.items[0].volumeInfo.description;
						}catch(e){
							fetch("https://www.googleapis.com/books/v1/volumes?q=isbn:0"+this.data.isbn).then(response=>{
								response.json().then(data=>{
									try{
										this.image=data.items[0].volumeInfo.imageLinks.thumbnail;
										this.description=data.items[0].volumeInfo.description;
									}catch(e){}
								})
							})
						}
						this.$store.commit('setLoading',false);
					})
				})
			}).catch(error=>{
				this.$store.commit('setLoading',false);
				this.goTo('home');
			})
		}
	},
	created(){
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