<template>
	<div class="parent bg-darkblue">
		<div class="padding justify-content-between color-white flex-wrap col-04 align-items-center-04">
			<!-- logo -->
			<div class="text-center-04">
				<img class="logo cursor-pointer" src="../../../assets/images/logo.svg" @click="scrollTo('app');"/>
				<div class="mt-40 color-light-gray font-size-0875">
					<span>{{$t('SDU')}}</span>
					<br>
					<span class="font-weight-500">{{$t('kaskelen')}}</span>
				</div>
			</div>
			<!-- links -->
			<div class="col justify-content-between n-1k">
				<div class="link" v-for="(link,index) in links" @click="goTo(link.name)">{{$t(link.name)}}</div>
			</div>
			<!-- contacts -->
			<div class="col justify-content-between n-07 text-choosable">
				<div>{{$t('contacts')}}</div>
				<div class="mt-20 color-light-gray font-size-0875" v-for="(value,key,index) in contacts">
					<div><span v-if="!(key=='place' || key=='address')">{{$t(key)}}: </span>{{$t(value)}}</div>
				</div>
			</div>
			<!-- follow us -->
			<div class="mt-10-04 text-center-04">
				<div>{{$t('follow_us')}}</div>
				<div class="row mt-20">
					<a :href="icon.link" v-for="(icon,index) in icons" class="icon_wrapper color-blue bg-white align-items-center justify-content-center mr-20 transition" target="_blank">
						<component :is="icon.component" class="icon"/>
					</a>
				</div>
			</div>
		</div>

		<div class="height-1 full-width bg-unclear mt-50" />

		<div class="row justify-content-center mt-20 color-light-gray">{{$t('allRightsReserved',{year:year})}}</div>
	</div>
</template>
<script type="text/javascript">
// mixins
import {scrollTo,goTo} from '../../../mixins/goTo'
import links from '../../../mixins/links'

// icons
import Instagram from '../../../assets/icons/Instagram'
import Telegram from '../../../assets/icons/Telegram'
import Youtube from '../../../assets/icons/Youtube'
export default{
	mixins:[scrollTo,goTo,links],
	components:{Instagram,Telegram,Youtube},
	computed:{
		year(){
			return new Date().getFullYear();
		}
	},
	data(){
		return{
			contacts:{
				place:'SDUlibrary',
				address:'SDUaddress',
				phone:'+7 747 672 84 17',
				email:'library@sdu.edu.kz'

			},
			icons:[
			{component:Telegram,link:'https://t.me/sdu_library'},
			{component:Instagram,link:'https://instagram.com/sdu_library?igshid=1spec8pmcepnw'},
			{component:Youtube,link:'https://www.youtube.com/channel/UCmuuTTBkfi8aUgUc56VY8kA'}
			]
		}
	}
}
</script>
<style scoped>
.parent{
	width: 100%;
	padding-top: 3.75em;
	padding-bottom:1.25em;
}
.logo{
	width: 7.5em;
}
.icon_wrapper{
	width: 2.5em;
	height:2.5em;
	border-radius: 50%;
	cursor: pointer;
}
.icon{
	font-size:1.4em;
}
.icon_wrapper:hover{
	transform:rotate(180deg);
	background:#FF9D29;
}
.icon_wrapper:hover > .icon{
	transform:rotate(180deg);
	font-size: 1.6em;
	color:white;
}
.bg-unclear{
	background-color: #4763AB;
}
</style>