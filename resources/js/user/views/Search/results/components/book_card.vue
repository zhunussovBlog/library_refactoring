<template>
	<div class="d-flex border-top py-3">
		<div class="mr-5">
			<checkbox :checked="selected.data.includes(data.id)" @change="checkBook()"/>
			<div class="image rounded bg-grey mt-3" :style="'background-image: url('+this.info.image+')'"></div>
		</div>
		<div class="flex-grow-1">
			<div class="d-flex text-center text-blue">
				<div class="rounded-lg bg-lightblue p-1 px-3" v-if="data.type">{{$t(data.type)}}</div>
				<div class="rounded-lg bg-lightblue p-1 px-3 ml-3" v-if="data.call_number">{{data.call_number}}</div>
			</div>
			<div class="mt-3 overflow-hidden title font-weight-bold font-size-24 cursor-pointer" @click="showMore()">{{data.title}}</div>
			<div class="text-grey mt-2">
				<div v-if="data.author">{{$t('author')}}: {{data.author}}</div>
				<div v-if="data.publisher">{{$t('publisher')}}: {{data.publisher}}</div>
				<div v-if="data.year">{{$t('year')}}: {{data.year}}</div>
			</div>
		</div>
		<div class="text-center col-2 px-0">
			<div class="bg-lightgrey rounded-lg p-2 text-no-wrap">
				{{data.availability}}
				{{$t('availability')}}
			</div>
			<button class="bg-white border border-grey text-grey px-0 w-100 mt-4" @click="showMore()">{{$t('show_details')}}</button>
		</div>
	</div>
</template>
<script type="text/javascript">
	import Checkbox from '../../../../components/checkbox'
	import {getBookImage} from '../../../../mixins/search'

	import {mapGetters} from 'vuex'
	export default{
		components:{
			Checkbox
		},
		mixins:[getBookImage],
		props:{
			data:Object
		},
		data(){
			return{
				info:{
					image:'',
					isbn:''
				}
			}
		},
		computed:{
			...mapGetters(['selected'])
		},
		watch:{
			data(){
				this.info.isbn=this.data.isbn;
				this.getBookImage(this.info);
			}
		},
		methods:{
			checkBook(){
				let id=this.data.id;
				if(this.selected.data.includes(id)){
					this.selected.data=this.selected.data.filter(item=>item!=id);
				}
				else{
					this.selected.data.push(id);
				}
			},
			showMore(){
				this.$router.push({ path: 'full', query: { id: this.data.id }});
			}
		},
		created(){
			this.info.isbn=this.data.isbn;
			this.getBookImage(this.info);
		}
	}
</script>
<style scoped>
.image{
	min-width:8.75em;
	max-width:8.75em;
	min-height:10em;
	max-height:10em;
	background-size: 100% 100%;
}
.title{
	display: -webkit-box;
	-webkit-line-clamp: 2;
	-webkit-box-orient: vertical;
	text-overflow: ellipsis;
}
</style>