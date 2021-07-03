<template>
	<div>
		<div class="d-flex justify-content-between padding flex-wrap">
			<div class="d-flex align-items-center text-darkblue">
				<span class="mr-2"><clock /></span>
				<span>{{$t('time',{time:time})}}</span>
				<div class="dot ml-3" :class="open ? 'bg-success': 'bg-danger'"></div>
			</div>
			<div class="d-flex align-items-center">
				<!-- languages dropdown -->
				<dropdown :data="langs" :on_click="setLang" menu_classes="dropdown-menu-right" :title="{link:$i18n.locale,uppercase:true}"/>
				<!-- login button if ur not logged in -->
				<div class="link bg-lightblue font-size-18 py-3 px-3 ml-3"  @click="showModal(login,{width:'300px',height:'300px'})" v-if="!logged">{{$t('login')}}</div>
				<!-- dropdown, in other cases -->
				<dropdown :data="dropdown_links" class="bg-lightblue font-size-18 py-3 px-3 ml-3" :title="{link:user.name}" menu_classes="dropdown-menu-right" v-else />
			</div>
		</div>
		<nav class="navbar navbar-expand-xl bg-blue navbar-dark padding py-2">
			<!-- logo -->
			<router-link class="cursor-pointer" :to="'/'+$i18n.locale">
				<img class="logo" src="/images/logo.svg">
			</router-link>
			<!-- appears only on screens smaller than xl -->
			
			<!-- main items -->
			<div class="collapse navbar-collapse flex-grow-0 m-auto" id="collapsibleNavbar">
				<ul class="navbar-nav">
					<li class="nav-item" v-for="(link,index) in lib_links" :key="index">
						<a :href="link.link" :target="link.target!=undefined ? link.target : '_blank'" class="nav-link link text-white text-nowrap font-weight-bold px-1">
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
			<div class="ml-auto mr-5 mr-xl-0 border border-white rounded-lg p-3 text-white cursor-pointer" @click="chatShown=!chatShown">
				ASK!
			</div>
			<div class="slide-out transition py-2 px-3 bg-blue rounded hidden" :class="{shown:chatShown}">
				<div class="align-self-start mt-40" style="z-index: 1;">
					<div class="d-none border border-width" id="libchat_591323eae0c67c543ac18bf22cf2e1a7" :class="{'d-block':$i18n.locale=='en'}"></div>
					<div class="d-none border border-width" id="libchat_26182d2d0a7628dba14f5685b439f7b5" :class="{'d-block':$i18n.locale=='ru'}"></div>
					<div class="d-none border border-width" id="libchat_2bd2632bd2b55389a65a46993bf9f779" :class="{'d-block':$i18n.locale=='kz'}"></div>
				</div>
			</div>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
				<span class="navbar-toggler-icon"></span>
			</button>
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
	import account_dropdown from './account_dropdown'

	import { mapGetters } from 'vuex'

	// icons
	import Clock from '../../../../common/assets/icons/Clock'
	
	export default{
		mixins:[links,langs,modal,account_dropdown],
		components:{
			dropdown,Clock
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

				this.time=begin.getHours() + ":" + this.$pad(begin.getMinutes(),2) + ' - ' + end.getHours() + ':' + this.$pad(end.getMinutes(),2);

				return begin<now && now<end; 
			}
		},
		data(){
			return{
				time:'',
				login:login,
				chatShown:false
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
.slide-out{
	position:absolute;
	top:200%;
}
.shown{
	right:0 !important;
}
.hidden{
	right:-340px;
}
</style>