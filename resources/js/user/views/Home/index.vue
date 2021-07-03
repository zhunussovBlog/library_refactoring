<template>
	<div>
		<!-- search -->
		<div class="d-flex flex-wrap flex-xl-nowrap bg-lightgrey padding py-5 bg-image home" :style="'background-image:url('+this.bgImage.src+')'">
			<div class="d-flex flex-column w-100 mt-5 align-items-center">
				<Search class="pt-4 pb-4 col-md-8 col-xl-6 px-0 flex-0 text-white" />
			</div>
		</div>
		<!-- upcoming events -->
		<div class="padding bg-white py-5">
			<div class="d-flex justify-content-between">
				<span class="font-size-32 font-weight-bold">{{$t('upcoming_events').toUpperCase()}}</span>
				<a href="https://sdu-kz.libguides.com/about_us/reports" target="_blank" class="d-flex align-items-center link text-blue">
					{{$t('lib_digest')}}
					<span class="ml-2 font-size-14">
						<right-normal />
					</span>
				</a> 
			</div>
			<div class="d-flex align-items-start mt-5 ">
				<div class="p-0 bg-white mr-5 rounded">
					<iframe class="no-border calendar-height" src="https://api3-eu.libcal.com/embed_mini_calendar.php?mode=month&iid=4105&cal_id=7853&l=5&tar=0&h=457&audience=&c=&z="/>
				</div>
				<slide-events v-if="!$mobileCheck()" :number="2" />
			</div>
		</div>
		<!-- library's video content -->
		<div class="position-relative bg-lightgrey padding py-5 overflow-hidden">
			<span class="font-size-32 font-weight-bold" v-html="$t('vid_content').toUpperCase()" />
			<div class="mt-3">
				{{$t('video_content')}}
			</div>
			<div class="d-flex justify-content-between mt-3">
				<div class="flex-wrap d-flex flex-xl-nowrap w-100 z-index-2">
					<iframe class="videos mr-3 w-100" src="https://www.youtube.com/embed/IS3jYEzgb4A" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					<iframe class="videos mr-3 mt-3 mt-xl-0 w-100" src="https://www.youtube.com/embed/KMGDDYt2Zvs" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div>
				<div class="d-none d-lg-flex align-items-center">
					<img class="videos_image" src="/images/Video.svg">
				</div>
			</div>
			<div class="mt-5">
				<a class="link text-blue" href="https://www.youtube.com/channel/UCmuuTTBkfi8aUgUc56VY8kA" target="_blank">
					{{$t('see_all_videos')}} 
					<span class="ml-2 "><right-normal /></span>
				</a>
			</div>
		</div>
		<!-- faq -->
		<div class="padding py-5 bg-white row flex-wrap justify-content-between">
			<div class="col-12 col-md-4">
				<div class="font-size-32 font-weight-bold">{{$t('faq').toUpperCase()}}</div>
				<div class="mt-5 font-weight-bold">{{$t('faq_question')}}</div>
				<div class="mt-1 font-size-14">{{$t('faq_answer')}}</div>
				<div class="mt-4">
					<div id="s-la-widget-7614" class="d-none mt-20 full-width width-100-lg s-la-widget s-la-widget-embed" :class="{'d-block':$i18n.locale=='en'}"></div>
					<div id="s-la-widget-7815" class="d-none mt-20 full-width width-100-lg s-la-widget s-la-widget-embed" :class="{'d-block':$i18n.locale=='ru'}"></div>
					<div id="s-la-widget-7814" class="d-none mt-20 full-width width-100-lg s-la-widget s-la-widget-embed" :class="{'d-block':$i18n.locale=='kz'}"></div>
				</div>
			</div>
			<div class="mt-3 col-12 col-md-6 mt-md-0">
				<div id="s-la-widget-7615" class="d-none no-border-top s-la-widget s-la-widget-embed" :class="{'d-block':$i18n.locale=='en'}"></div>
				<div id="s-la-widget-7792" class="d-none no-border-top s-la-widget s-la-widget-embed" :class="{'d-block':$i18n.locale=='ru'}"></div>
				<div id="s-la-widget-7809" class="d-none no-border-top s-la-widget s-la-widget-embed" :class="{'d-block':$i18n.locale=='kz'}"></div>
			</div>
		</div>
	</div>
</template>
<script type="text/javascript">
	// components
	import Search from '../Search/search'
	import SlideEvents from './components/slide_events'

	// icons
	import RightNormal from '../../../common/assets/icons/RightNormal'

	export default{
		components:{Search,RightNormal,SlideEvents},
		data(){
			return{
				bgImage:{
					src:''
				}
			}
		},
		methods:{
			async loadScript(src){
				let externalScript = document.createElement('script');
				externalScript.setAttribute('src',src);
				document.head.appendChild(externalScript);
			},
			setBgImage(){
				let date=new Date();
				let src='/bg-images/';
				src+=this.$pad(date.getMonth()+1,2)+'.';
				src+=Math.trunc(date.getDate()/7)+1;
				src+='.png';
				this.bgImage.src=src;
			},
			loadExternalLibGuideScripts(){
				let srcs=[];

				// faq ask 
				// en
				srcs[0]='https://sdu-kz.libanswers.com/1.0/widgets/7614'; 
				// ru
				srcs[1]='https://sdu-kz.libanswers.com/1.0/widgets/7815'; 
				// kz
				srcs[2]='https://sdu-kz.libanswers.com/1.0/widgets/7814'; 
				
				// faq questions
				// en
				srcs[3]='https://sdu-kz.libanswers.com/1.0/widgets/7615'; 
				// ru
				srcs[4]='https://sdu-kz.libanswers.com/1.0/widgets/7792'; 
				// kz
				srcs[5]='https://sdu-kz.libanswers.com/1.0/widgets/7809'; 
				
				// chat
				// en
				srcs[6]='https://sdu-kz.libanswers.com/load_chat.php?hash=591323eae0c67c543ac18bf22cf2e1a7'; 
				// ru
				srcs[7]='https://sdu-kz.libanswers.com/load_chat.php?hash=26182d2d0a7628dba14f5685b439f7b5'; 
				// kz
				srcs[8]='https://sdu-kz.libanswers.com/load_chat.php?hash=2bd2632bd2b55389a65a46993bf9f779';

				srcs.forEach(item=>{
					this.loadScript(item);
				});
			}
		},
		mounted(){
			this.loadExternalLibGuideScripts();
			this.setBgImage();
		}
	}
</script>
<style scoped>
.no-border{
	border:none;
}
.videos{
	height:18em;
}
.calendar-height{
	height:18.75em;	
}
.bg-image{
	background-repeat: no-repeat;
	background-size: 100% 100%;
}
.home{
	/* hard... minus navbar height */
	height:calc(100vh - 143px);
	min-height: 740px;
}
.videos_image{
	position: absolute;
	bottom:-40px;
	right:-40px;
	z-index: 1;
}
.z-index-2{
	z-index: 2;
}
</style>