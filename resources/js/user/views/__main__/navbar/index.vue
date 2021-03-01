<template>
	<div>
		<div class="d-flex justify-content-between padding flex-wrap">
			<div class="d-flex align-items-center">
				<span>{{$t('time',{time:time})}}</span>
				<div class="dot ml-3" :class="open ? 'bg-success': 'bg-danger'"></div>
			</div>
			<div class="d-flex align-items-center">
				<!-- languages dropdown -->
				<dropdown :data="langs" :on_click="setLang" menu_classes="dropdown-menu-right" :title="{link:$i18n.locale,uppercase:true}"/>
				<!-- login button if ur not logged in -->
				<div class="link bg-lightblue font-size-18 py-3 px-3 ml-3"  @click="showModal(login,{width:'300px'})" v-if="!logged">{{$t('login')}}</div>
				<!-- name, in other cases -->
				<div class="link bg-lightblue font-size-18 py-3 px-3 ml-3" v-else>{{user.name}}</div>
			</div>
		</div>
		<nav class="navbar navbar-expand-xl bg-blue navbar-dark padding py-2">
			<!-- logo -->
			<router-link :to="{name:'home'}">
				<img class="logo" src="images/logo.svg">
			</router-link>
			<!-- appears only on screens smaller than xl -->
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
				<span class="navbar-toggler-icon"></span>
			</button>
			<!-- main items -->
			<div class="collapse navbar-collapse flex-grow-0 m-auto" id="collapsibleNavbar">
				<ul class="navbar-nav">
					<li class="nav-item" v-for="(link,index) in lib_links" :key="index">
						<a :href="link.link" :target="link.target!=undefined ? link.target : '_blank'" class="nav-link link text-white text-nowrap font-weight-bold">
							<!-- if link is a dropdown -->
							<span v-if="link.dropdown==undefined">{{$t(link.name).toUpperCase()}}</span>
							<!-- in other cases -->
							<span v-else>
								<dropdown :data="link.dropdown.links" :links="true" :title="{uppercase:true,link:link.name}"/>
							</span>
						</a>
					</li>
				</ul>
			</div>  
		</nav>
	</div>
</template>
<script type="text/javascript">
	// components
	import dropdown from '../../../components/dropdown'

	import login from './login'
	
	// mixins
	import links from '../../../mixins/links'
	import langs from '../../../mixins/langs'
	import modal from '../../../mixins/modal'

	import { mapGetters } from 'vuex'
	
	export default{
		mixins:[links,langs,modal],
		components:{
			dropdown
		},
		computed:{
			...mapGetters(['logged','user']),
			open(){
				let begin_hours=9;
				let begin_miutes=0;
				let end_hours=18;
				let end_miutes=0;

				let now= new Date();
				let begin= new Date();
				let end= new Date();

				begin.setHours(begin_hours);
				begin.setMinutes(begin_miutes);

				end.setHours(end_hours);
				end.setMinutes(end_miutes);

				this.time=begin.getHours() + ":" + begin.getMinutes() + ' - ' + end.getHours() + ':' + end.getMinutes();

				return begin<now && now<end; 
			}
		},
		data(){
			return{
				time:'',
				login:login
			}
		},
		methods:{
			showLogin(){
				
			}
		}
	}
</script>
<style scoped>
.dot{
	border-radius: 50%;
	height: .5em;
	width: .5em;
}
</style>