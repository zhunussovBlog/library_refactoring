<template>
	<div class="parent">
		<div class="row">
			<div class="filter-width align-items-center justify-content-center" v-if="mybook || myreserve">
				<div v-if="mybook">
					<div class="color-gray">{{$t('from')}}: </div>
					<div class="mt-5">{{data.issue_date}}</div>
					<div class="color-gray mt-10">{{$t('to')}}: </div>
					<div class="mt-5">{{data.due_date}}</div>
				</div>
				<div v-else>
					<div class="color-gray">{{$t('reserve_date')}}:</div>
					<div class="mt-5">{{data.action_date}}</div>
				</div>
			</div>
			<div class="mr-50">
				<div class="align-items-center">
					<Checkbox :checked="selected.all ? !selected.data.includes(data.id) : selected.data.includes(data.id)" @change="checkBook()"/>
					<div class="type border-radius ml-20 b-079" v-if="data.type">{{$t(data.type)}}</div>
					<span class="type border-radius ml-20 b-04"> {{data.availability}} {{$t('availability')}}</span>

				</div>
				<div class="image bg-gray mt-15 border-radius" :style="'background-image: url('+this.image+')'" />
			</div>
			<div class="mr-50 col flex-grow text-choosable n-06">
				<div class="row n-079">
					<div class="type border-radius" v-if="data.type">{{$t(data.type)}}</div>
					<div class="type border-radius ml-20" v-if="data.call_number">{{data.call_number}}</div>
				</div>
				<div class="mt-20 title n-079" @click="showDetails()">{{data.title}}</div>
				<div class="mt-10 color-gray">
					<div v-if="data.authors">{{$t('authors')}}: {{data.authors}}</div>
					<div v-if="data.publisher">{{$t('publisher')}}: {{data.publisher}}</div>
					<div v-if="data.year">{{$t('year')}}: {{data.year}}</div>
				</div>
			</div>
			<div class="col n-04 ml-auto">
				<div class="bg-light-gray border-radius align-items-center justify-content-center text-no-wrap button">
					<div class="font-size-2 color-dark-gray">
						<Cloud />
					</div>
					&nbsp;
					<span> {{data.availability}} {{$t('availability')}}</span>
				</div>
				<button class="bg-transparent border border-dark-gray color-gray mt-30" @click="showDetails()">{{$t('show_details')}}</button>
				<button class="bg-green color-white mt-15" @click="reserveButton()" v-if="mybook || myreserve">{{mybook||myreserve ? mybook ? $t('renew') : $t('cancel') :$t('reserve')}}</button>
			</div>
		</div>
		<div class="mt-15 title b-079">{{data.title}}</div>
		<button class="bg-transparent border border-dark-gray color-gray mt-15 b-04" @click="showDetails()">{{$t('show_details')}}</button>
	</div>
</template>
<script type="text/javascript">
// icons
import Cloud from '../../../assets/icons/Cloud'

// components
import Checkbox from '../../../components/common/Checkbox'

// mixins
import {goTo} from '../../../mixins/goTo'

export default{
	components:{Cloud,Checkbox},
	props:{
		data:Object,
		mybook:Boolean,
		myreserve:Boolean
	},
	mixins:[goTo],
	computed:{
		selected(){
			return this.$store.getters.selected;
		}
	},
	data(){
		return{
			image:''
		}
	},
	watch:{
		'data'(newValue,oldValue){
			this.getBookImage();
		}
	},
	methods:{
		showDetails(){
			let query={type:this.data.type_key,id:this.data.id};
			this.$store.commit('setMedia',query);
			this.$router.push({path:'full',query:query});
		},
		checkBook(){
			let id=this.data.id;
			if(this.selected.data.includes(id)){
				this.$store.state.selected.data=this.selected.data.filter(item=>item!=id);
			}
			else{
				this.$store.state.selected.data.push(id);
			}
		},
		getBookImage(){
			// we use fetch() because there's cors mistake when use this.$http
			fetch("https://www.googleapis.com/books/v1/volumes?q=isbn:"+this.data.isbn).then(response=>{
				response.json().then(data=>{
					try{
						this.image=data.items[0].volumeInfo.imageLinks.thumbnail;
					}catch(e){
						fetch("https://www.googleapis.com/books/v1/volumes?q=isbn:0"+this.data.isbn).then(response=>{
							response.json().then(data=>{
								try{
									this.image=data.items[0].volumeInfo.imageLinks.thumbnail;
								}catch(e){
									this.image='';
								}
							})
						})
					}
				})
			})
		}
		// this part is depricated
		// gotta add loading indicator later
		// this is about reserve button
		// reserveButton(){
		// 	if(this.myreserve){
		// 		this.$http.post('media/cancel-reserve', {
		// 			'reserve_id': this.data.id,
		// 		}).then(response => {
		// 			this.$store.commit('setReserves',this.$store.statereserves.filter(item=>item.lib_reserve_id!=id));
		// 		});
		// 	}
		// 	if(this.data.status==0){
		// 		let media={id:this.data.id,type:this.data.type};
		// 		if(media.type=='journal'){
		// 			media.issue_id=data.issue_id;
		// 		};
		// 		this.$http.post('media/reserve', {
		// 			media
		// 		}).then(response => {
		// 			this.$fire({
		// 				title:"Reserve",
		// 				text:"Successful!",
		// 				type: response.data.isReserve ? 'success' : 'error'
		// 			});;
		// 		}).catch(error=>{
		// 			this.$fire({
		// 				title:"Reserve",
		// 				text:'Uncaught problem',
		// 				type:'error'
		// 			})
		// 		});
		// 	}
		// }
	},
	created(){
		this.getBookImage();
	}
}
</script>
<style scoped>
.parent{
	padding: 1.25em 0;
	border:0.03125em solid #E5E5E5;
	border-left: none;
	border-right: none;
	/*animation: anim .3s;*/
}
.title{
	font-weight: 500;
	overflow: hidden;
}
.image{
	min-width:8.75em;
	max-width:8.75em;
	min-height:10em;
	max-height:10em;
	background-repeat: no-repeat;
	background-size: 100% 100%;
}
button{
	width:10em;
	padding:0;

}
.button,button{
	height: 3.125em;
}
@keyframes anim{
	0%{
		opacity: 0;
		transform: translateX(6.25em);
	}
	100%{
		opacity: 1;
		transform: translateX(0);
	}
}
</style>