<template>
	<div class="mt-2 bg-white py-4 px-3">
		<Back />
		<div class="d-flex mt-2">
			<div class="d-flex flex-column">
				<div class="d-flex flex-column align-items-center p-3 px-5">
					<div class="imageWidth imageHeight image rounded" :style="'background-image: url('+backgroundImage+')'"/>
					<div class="mt-2 text-center">{{$t(info.type)}}</div>
				</div>
				<div class="d-flex flex-column bg-lightgrey p-2 px-5 mt-auto">
					<div class="d-flex justify-content-between imageWidth align-self-center" v-for="(value,key,index) in user.total" :key="index">
						<div :class="[{'green':index==0},{'orange':index==1},{'red':index==2}]">{{$t(key)+':'}}</div>
						<div>{{value}}</div>
					</div>
				</div>
			</div>
			<div class="d-flex bg-lightgrey rounded-lg p-3 ml-4 flex-fill" v-if='user.info'>
				<div class="w-100 mr-2">
					<div class="d-flex" :class="{'mt-3 mt-xl-5':index!=0}" v-for="(item,index) in user_info.leftArray" :key="index">
						<div class="text-grey">{{capitalize($t(item.key))}}:</div>
						<div class="ml-2">{{item.value}}</div>
						&nbsp;
					</div>
				</div>
				<div class="w-100">
					<div class="d-flex" :class="{'mt-3 mt-xl-5':index!=0}" v-for="(item,index) in user_info.rightArray" :key="index">
						<div class="text-grey">{{capitalize($t(item.key))}}:</div>
						<div class="ml-2">{{item.value}}</div>
						&nbsp;
					</div>
				</div>
			</div>
		</div>
		<div class="d-flex justify-content-between mt-4">
			<tabs :components="components" tabClasses="font-size-18 mr-3" :tabOnClick="tabOnClick"/>
			<div class="d-flex" v-if="state=='issuance'">
				<input-div :search="true" :placeholder="$t('barcode')"/>
				<button class="ml-3 width-unset">from RFID reader</button>
			</div>
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
import InputDiv from '../../../components/common/Input'
export default{
	components:{Back,TableDiv,Tabs,InputDiv},
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
			user_info:{
				leftArray:[],
				rightArray:[]
			}
		}
	},
	methods:{
		capitalize(string){
			return capitalize(string);
		},
		objectWithoutKey(string,key){
			return objectWithoutKey(string,key);
		},
		tabOnClick(tab){
			this.state=tab.name.toLowerCase();
		},
		makeUserInfo(){
			let even=[];
			let odd=[];
			let index=0;
			for(let [key,value] of Object.entries(objectWithoutKey(this.user.info,'user_cid'))){
				if(index%2==0){
					even.push({key:key,value:value});
				}
				else{
					odd.push({key:key,value:value});
				}
				index++
			}
			this.user_info.leftArray=even;
			this.user_info.rightArray=odd;
		},
		getInfo(){
			this.$http.get('service/user/'+this.info.type+'/'+this.info.id).then(response=>{
				this.user=response.data.res;
				this.makeUserInfo();
			}).catch(e=>{})
		},
		ajaxRequest() {
			const request = new XMLHttpRequest();

			const url = 'https://localhost:44379/LibraryWebService.asmx/GetItemsStatus';
			request.open('POST', url, true);
			request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			request.addEventListener("readystatechange", () => {
				if(request.readyState === 4 && request.status === 200) {
					console.log(request.responseText);
				}
			});

			request.send();
		}
	},
	created(){
		this.getInfo();
	}
}
</script>
<style scoped>
.image{
	background-repeat: no-repeat;
	background-size: 100% 100%;
}
.imageWidth{
	width:14em;
}
.imageHeight{
	height: calc(14em * 4/3);
}
.red{
	color:#FF0000;
}
.orange{
	color:#FF9D29;
}
.green{
	color:#00BB78;
}
</style>
