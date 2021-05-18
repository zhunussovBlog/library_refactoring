<template>
	<form class="d-flex" @submit.prevent="loadResults()">
		<div class="bg-white mt-2 w-100 py-3 px-4">
			<form class="d-flex align-items-center sections" @submit.prevent="loadResults()">
				<!-- fu... luchshe sjuda ne smotret' -->
				<label>{{$t('section')}} : &nbsp;</label>
				<div class="border border-grey mr--1 text-center cursor-pointer" v-for="(type,index) in types" :key="index" @click="chooseType(type)" :class="[{'border-left-radius' : index==0},{'border-right-radius':index==types.length-1},{'border-orange text-orange':type.key==search_type},index==0 ? 'border-right-none' :'border-left-none']">{{$t(type.key)}}</div>
				<div class="input ml-4">
					<input-div classes="border-grey w-100" :search='true' :onSubmit="loadResults" v-model="users.search.add_options.all" :placeholder="$t(search_type=='student' ? 'user_id_user':'username_user')"/>
				</div>
				<div class="ml-1 h-100">
					<button type="submit" class="bg-orange h-100">{{$t('search')}}</button>
				</div>
			</form>
			<div class="mt-5">
				<div v-if="users.searching">
					<table-div
					:heads="users.heads"
					:data="users.data.res"
					:service="service"
					:link="link"
					:commit="commit"
					:pagination="users.pagination"
					:sortable="false"
					/>
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

import {mapGetters} from 'vuex'

export default{
	mixins:[getResults,showModal,goTo],
	components:{'table-div':Table,PulseLoader,'input-div':Input,Dropdown},
	computed:{
		...mapGetters(['users'])
	},
	data(){
		return{
			loading:false,
			types:[{key:'student'},{key:'employee'}],
			search_type:'student',
			service:{
				available:true,
				func:this.serve,
				showMore:this.showit,
				icon:Book,
				title:'serve'
			},
			info:Info,
			commit:'users',
			link:'service'
		}
	},
	methods:{
		changeHeads(){
			let heads=[{name:'full_name',link:'full_name'},{name:'username',link:'username'}];
			if(this.search_type=='employee'){
				heads=heads.concat([{name:'degree',link:'degree_position'},{name:'department',link:'department'}]);
			}
			else{
				heads=heads.concat([{name:'faculty',link:'faculty'},{name:'degree',link:'degree'}]);
			}
			this.$store.state.users.heads=heads;
		},
		getTypes(){
			this.$http.get('/service/sort-fields').then(response=>{
			});
			this.$http.get('/service/search-fields').then(response=>{
			});
			this.$http.get('/service/filter-fields').then(response=>{
			});
		},
		loadResults(){
			let link='/user/'+this.search_type;
			this.$store.dispatch('setStore',{label:this.commit,data:{page:0}});
			this.getResults(this.link+link,this.commit,this.changeHeads,link+'/search');
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
			this.goTo('service',{info:info})
		},
		chooseType(type){
			this.search_type=type.key;
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
	border-radius: 0.3125em;

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

.mr--1{
	margin-right: -0.0625em;
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