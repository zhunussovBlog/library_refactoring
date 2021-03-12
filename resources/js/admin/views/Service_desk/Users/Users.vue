<template>
	<form class="d-flex" @submit.prevent="loadResults()">
		<div class="bg-white mt-2 w-100 py-3 px-4">
			<form class="d-flex align-items-center sections" @submit.prevent="loadResults()">
				<!-- fu... luchshe sjuda ne smotret' -->
				<label>{{$t('section')}} : &nbsp;</label>
				<div class="border border-grey mr-1 text-center cursor-pointer" v-for="(type,index) in types" :key="index" @click="chooseType(type)" :class="[{'border-left-radius' : index==0},{'border-right-radius':index==types.length-1},{'border-orange text-orange':type.key==search.type},index==0 ? 'border-right-none' :'border-left-none']">{{$t(type.key)}}</div>
				<div class="input ml-4">
					<input-div classes="border-grey w-100" :search='true' :onSubmit="loadResults" v-model="search.query" :placeholder="$t(search.type=='student' ? 'user_id_user':'username_user')"/>
				</div>
				<div class="ml-1 h-100">
					<button type="submit" class="bg-orange h-100">{{$t('search')}}</button>
				</div>
				<div class="ml-auto h-100 d-flex align-items-center">
					<Dropdown title="Choose department"/>
				</div>
			</form>
			<div class="mt-5">
				<div v-if="searching">
					<table-div class="mt-5" :clickables="true" :heads="heads" :data="data.res" :service="service" link="/user" commit="users" :sortable="false"/>
				</div>
			</div>
		</div>
	</form>
</template>
<script type="text/javascript">
// components
import Table from '../../../components/common/Table'
import Input from '../../../components/common/Input'
import Dropdown from '../../../components/common/Dropdown'
import Info from './Info'

// loading indicator
import PulseLoader from 'vue-spinner/src/PulseLoader'

//mixins
import {getResults} from '../../../mixins/common'
import {goTo} from '../../../mixins/goTo'
import showModal from '../../../mixins/showModal'

// icons
import Book from '../../../assets/icons/Book'

export default{
	mixins:[getResults,showModal,goTo],
	components:{'table-div':Table,PulseLoader,'input-div':Input,Dropdown},
	computed:{
		data(){
			return this.$store.getters.users.data;
		},
		searching(){
			return this.$store.getters.users.searching;
		},
		heads(){
			return this.$store.getters.users.heads;
		}
	},
	data(){
		return{
			loading:false,
			types:[],
			search:{
				type:'',
				query:''
			},
			service:{
				available:true,
				func:this.serve,
				showMore:this.showit,
				icon:Book,
				title:'serve'
			},
			info:Info
		}
	},
	methods:{
		changeHeads(){
			let heads=[{name:'full_name',link:'full_name'},{name:'username',link:'username'}];
			if(this.search.type=='employee'){
				heads=heads.concat([{name:'degree',link:'degree_position'},{name:'department',link:'department'}]);
			}
			else{
				heads=heads.concat([{name:'faculty',link:'faculty'},{name:'status',link:'status'}]);
			}
			this.$store.state.users.heads=heads;
		},
		getTypes(){
			this.$http.get('/user/types').then(response=>{
				this.types=response.data.res;
				this.search.type=this.types[0].key;
			})
		},
		setLoading(bool){
			this.loading=bool;
		},
		setSearch(search){
			this.search=search;
		},
		loadResults(){
			this.$store.dispatch('setStore',{label:'users',data:{page:0}});
			this.getResults('/user',this.search,'users',this.changeHeads);
		},
		showit(info){
			let props={
				id:info.id,
				type:info.type,
				width:'56.25%'
			};
			this.showModal(this.info,props);
		},
		serve(info){
			this.$router.push({path:'service',params:{info:info}});
		},
		chooseType(type){
			this.search.type=type.key;
			this.search.query='';
		}
	},
	created(){
		this.getTypes();
	}
}
</script>
<style scoped>
/*I hate it !!!!!!!*/

.text-center{
	height: 100%;
	padding:0 2em;
	text-align: center;
	display: flex;
	align-items: center;
}

.pad{
	width:100%;
}

.border-left-none{
	border-left: none;
}

.border-right-none{
	border-right: none;
}

.border-orange{
	/*fu.... so bad code .... HATE IT!*/
	border-width:0.09375em;
	z-index: 1;
	rounded-lg: 0.3125em;

	/*never use !important ... do never!!!*/
	border-left:0.09375em solid #ff9d29 !important;
	border-right:0.09375em solid #ff9d29 !important;
}

.border-left-radius{
	border-top-left-radius: 0.3125em;
	border-bottom-left-radius: 0.3125em;
}

.border-right-radius{
	border-top-right-radius: 0.3125em;
	border-bottom-right-radius: 0.3125em;	
}

.mr-1{
	margin-right: -0.3125em;
}

.input{
	width:50%;
	height:100%;
}

.sections{
	height:2.5em;
}

.bg-orange{
	padding:0 1.5em;
}
</style>