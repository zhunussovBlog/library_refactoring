<template>
	<div>
		<!-- backgrounded div -- search , we've got a navbar inside ... ) -->
		<div class="bg-white height-100vh relative col overflow-hidden">
			<!-- THIS IS DIFFICULT !!!  -->
			<div class="circle_wrapper" v-if="!$mobileCheck()">
				<transition name="fade">
					<img src="../../assets/images/SDU.jpg" key = 1 class="circle transition bg-image" v-if="searchType=='simple'"/>
					<div class="circle transition"/>
				</transition>
			</div>
			<Tabs :components="components" class="relative padding padding-top" :componentStyle="$mobileCheck() ? 'width:unset':'width:55%'" />
			<div class="padding padding-top padding-bottom align-self-start justify-content-between full-width align-items-center flex-wrap-lg" style="z-index: 1;">
				<div class="shadowed" id="libchat_591323eae0c67c543ac18bf22cf2e1a7"></div>
				<!-- <div class="padding-top pd-20 libOpen color-white border-radius mt-10-lg">
					<div class="align-items-center">
						{{$t(open ? 'library_open' :'library_closed')}} &nbsp;&nbsp;<span class="dot" :class="open ? 'bg-green': 'bg-red'"></span>
					</div>
					<div class="mt-10">
						<span>
							<Clock />
						</span>
						&nbsp;
						{{$t('monday-friday')}}
					</div>
				</div> -->
			</div>
		</div>
		<!-- upcoming events -->
		<div class="padding pt-80 pb-80 bg-light-gray">
			<div class="justify-content-between">
				<span class="font-size-2 font-weight-500">{{$t('upcoming_events').toUpperCase()}}</span>
				<!-- <div class="align-items-center color-blue">
					{{$t('see_all_events')}}
					&nbsp; 
					&nbsp; 
					<span class="font-size-0875">
						<RightNormal />
					</span>
				</div>  -->
			</div>
			<div class="mt-50 align-items-start">
				<iframe class="mr-100" src="https://api3-eu.libcal.com/embed_mini_calendar.php?mode=month&iid=4105&cal_id=7853&l=5&tar=0&h=457&audience=&c=&z="/>
				<!-- <SlidesEvents v-if="!$mobileCheck()" :number="2" /> -->
			</div>
		</div>
		<!-- library's video content -->
		<!-- <div class="bg-light-gray pt-80 pb-80 padding">
			<span class="font-size-2 font-weight-500" v-html="libVideoContent" />
			<div class="row mt-20">
				<div class="min-width-none col justify-content-between mr-100">
					<span>{{$t('video_content')}}</span>
					<SlidesVideos class="mt-20"/>
				</div>
				<div class="color-light-gray n-079">
					<img src="../../assets/images/Video.svg">
				</div>
			</div>
			<div class="mt-30 color-blue">
				{{$t('see_all_videos')}} 
				<span><RightNormal /></span>
			</div>
		</div> -->
		<!-- FAQ -->
		<div class="padding pt-80 pb-80 justify-content-between flex-wrap-lg">
			<div class="full-width pr-20 p-0-lg">
				<div class="font-size-2 font-weight-500">
					FAQ
				</div>
				<div class="mt-60 font-size-1125 font-weight-500">{{$t('faq_question')}}</div>
				<div class="mt-5 font-size-0875">{{$t('faq_answer')}}</div>
				<div id="s-la-widget-7614" class="mt-20 width-70 width-100-lg"></div>
			</div>
			<div class="full-width px-20 p-0-lg mt-10-lg">
				<div id="s-la-widget-7615"></div>
			</div>
		</div>
		<!-- footer -->
		<footer-div />
		<!-- fixed stuff -->
		<!-- <AskALibrarian v-if="!$mobileCheck()" /> -->
		<div id="s-lg-box-wrapper-18258677 "></div>
	</div>
</template>
<script type="text/javascript">
// common and app components
import Tabs from '../../components/common/Tabs'
import Navbar from '../../components/App/Navbar/Navbar'
import Footer from '../../components/App/Footer/Footer'

// search
import eResources from '../Search/search/EResources'
import booksAndMedia from '../Search/search/BooksAndMedia'

// icons
import Clock from '../../assets/icons/Clock'
import RightNormal from '../../assets/icons/RightNormal'
import CaretUp from '../../assets/icons/CaretUp'

// home components
import SlidesVideos from './SlidesVideos'
import SlidesEvents from './SlidesEvents'
import AskALibrarian from './AskALibrarian'

export default{
	components:{
		Tabs,
		Navbar,
		'footer-div':Footer,
		Clock,
		RightNormal,
		CaretUp,
		SlidesVideos,
		SlidesEvents,
		AskALibrarian
	},
	computed:{
		libVideoContent(){
			switch(this.$i18n.locale){
				case 'ru':
				return  this.$t('vid_content').toUpperCase()+'<span class="color-blue" >'+this.$t('libs').toUpperCase()+'</span>'
				break;
				default:
				return '<span class="color-blue" >'+this.$t('libs').toUpperCase() +'</span>' +this.$t('vid_content').toUpperCase();
				break;
			}
		},
		open(){
			let time=new Date().getHours();
			return (time >= 9 && time<= 18)
		},
		searchType(){
			return this.$store.getters.searchType;
		}
	},
	data(){
		return{
			components:[
			{name:'books&media',component:booksAndMedia},
			{name:'eresources',component:eResources}
			]
		}
	},
	methods:{
		loadScript(src){
			let externalScript = document.createElement('script');
			externalScript.setAttribute('src', src)
			document.head.appendChild(externalScript)
		},
		loadExternalLibGuideScripts(){
			let srcs=[];
			// faq questions 
			srcs[0]='https://sdu-kz.libanswers.com/1.0/widgets/7614';
			// faq answers
			srcs[1]='https://sdu-kz.libanswers.com/1.0/widgets/7615';
			// chat
			srcs[2]='https://sdu-kz.libanswers.com/load_chat.php?hash=591323eae0c67c543ac18bf22cf2e1a7';
			// ask us
			srcs[3]='https://sdu-kz.libanswers.com/load_chat.php?hash=e250e6e469c178c6e24700298be9a087';
			srcs.forEach(item=>{
				this.loadScript(item);
			});
		}
	},
	mounted(){
		this.loadExternalLibGuideScripts();
	}
}
</script>
<style scoped>
.height-100vh{
	min-height:min(100vh,800px);
}

.circle_wrapper{
	position: absolute;
	height: 100%;
	width: 100%;
	overflow: hidden;
	top:0;
}

.circle{
	width: 65vw;
	height: 65vw;
	min-width: 50em;
	min-height: 50em;
	border-radius: 50%;
	position: absolute;	
	top:-2.8vw;
	right:-25%;
	background-color: #082673;
}

.bg-image{
	height: 109%;
	width: unset;
	right:-6%;
	border-top-right-radius: 0;
	border-bottom-right-radius: 0;
}


.flex-1{
	margin-top:max(-19vh,-140px);
}

.libOpen{
	background-color: #082673;
	padding:1.25em 2.5em 1.25em 1.25em;
}
.dot{
	border-radius: 50%;
	height: .5em;
	width: .5em;
}
/*this is stroke stuff*/

iframe{
	border:none;
	height:300px;
}
/*!!!!!HATE THAT IMAGE OOOOO*/
@media screen and (max-width: 1000px){
	.circle_wrapper{
		display: none;
	}
}

.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
	opacity: 0;
}

</style>