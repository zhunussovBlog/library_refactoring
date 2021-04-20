<template>
	<div class="mt-2 bg-white py-4 px-3">
		<Back />
		<div class="d-flex mt-2">
			<div class="p-3 rounded-lg bg-lightgrey">
				<div class="image" :style="'background-image: url('+backgroundImage+')'"/>
				<div class="mt-2 text-center">{{$t(info.type)}}</div>
			</div>
			<div class="bg-lightgrey rounded-lg p-3 ml-4 flex-1" v-if='user.info'>
				<div class="d-flex mt-2" v-for="(value,key,index) in objectWithoutKey(user.info,'user_cid') ">
					<div class="text-grey">{{capitalize($t(key))}}:</div>
					<div class="ml-2">{{value}}</div>
					&nbsp;
				</div>
			</div>
		</div>
        <button type="button" class="d-flex align-items-center" @click="testRequest">
            Get books from station
        </button>
		<div class="mt-4">
			<tabs :components="components" tabClasses="font-size-18 mr-3" :tabOnClick="tabOnClick"/>
		</div>
		<div class="mt-4">
			<table-div
			:heads="heads"
			:data="data"
			:selectable="selectable"
			:clickables="clickables"
			:sortable="false"
			:pagination="false"
			/>
		</div>
	</div>
</template>
<script type="text/javascript">
// components
import Back from '../../../components/common/Back'
import TableDiv from '../../../components/common/Table'
import Tabs from '../../../components/common/Tabs'
export default{
	props:{
		info:{
			type:Object,
			default(){
				return {}
			}
		}
	},
	computed:{
		selectable(){
			let selectable={
				available:false,
				button_title:'check_in'
			};
			if(this.state=='issuance'){
				selectable.available=true;
			}
			return selectable;
		},
		clickables(){
			let bool=false;
			if(this.state=='return'){
				bool=true;
			}
			return bool;
		},
		backgroundImage(){
			return this.user.photo
		},
		heads(){
			let heads=[];
			if(this.state=='issuance'){
				heads=[
				{
					name:'barcode',link:'barcode'
				},
				{
					name:'duration',link:'title'
				},
				{
					name:'title',link:'title'
				},
				{
					name:'author',link:'author'
				}
				]
			}
			else if(this.state=='return'){
				heads=[
				{
					name:'due_date',link:'due_date'
				},
				{
					name:'author',link:'author'
				},
				{
					name:'barcode',link:'barcode'
				},
				{
					name:'inventory_number',link:'inv_no'
				},
				{
					name:'title',link:'title'
				}
				]
			}
			else{
				heads=[
				{
					name:'due_date',link:'due_date'
				},
				{
					name:'author',link:'authors'
				},
				{
					name:'barcode',link:'barcode'
				},
				{
					name:'inventory_number',link:'inv_id'
				},
				{
					name:'title',link:'title'
				},
				{
					name:'status',link:'status'
				}
				]
			}
			return heads
		},
		data(){
			let data=[];
			if(this.state=='history'){
				data=this.user.history
			}
			return data;
		}
	},
	components:{Back,TableDiv,Tabs},
	data(){
		return{
			user:{},
			components:[
			{
				name:'issuance'
			},
			{
				name:'return'
			},
			{
				name:'history'
			}],
			state:'issuance',
		}
	},
	methods:{
		capitalize(string){
			return capitalize(string);
		},
		objectWithoutKey(string,key){
			return objectWithoutKey(string,key);
		},
		getInfo(){
			console.log(this.info)
			this.$http.get('service/user/'+this.info.type+'/'+this.info.id).then(response=>{
				this.user=response.data.res;
			}).catch(e=>{})
		},
		tabOnClick(tab){
			this.state=tab.name.toLowerCase();
		},
        testRequest() {
		    this.$http.post('http://localhost:44379/LibraryWebService.asmx/GetItemsStatus', {}, {
		        headers: {
		            'Content-Type': 'application/x-www-form-urlencoded'
                },
            }).then(response => {
		        console.log(response);
            }).catch(e => {
                console.log(e);
            })
        }
	},
	created(){
		this.getInfo();
	}
}
</script>
<style scoped>
.image{
	width:15.625em;
	height: calc(15.625em * 4/3);
	background-repeat: no-repeat;
	background-size: 100% 100%;
}
</style>
