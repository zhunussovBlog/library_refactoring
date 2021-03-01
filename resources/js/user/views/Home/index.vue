<template>
	<div>
		<!-- search -->
		<div class="d-flex flex-wrap flex-xl-nowrap bg-lightgrey padding py-5 ">
			<div class="d-flex flex-column w-100">
				<Search class="pt-4 pb-4 col-md-12 col-xl-11 px-0 flex-0" />
				<div class="align-self-start mt-40" style="z-index: 1;">
					<div class="border 	border-width" id="libchat_591323eae0c67c543ac18bf22cf2e1a7"></div>
				</div>
			</div>
			<div class="col-12 col-xl-4 px-0 mt-3 mb-3">
				<div id="s-la-widget-7614" class="mt-20 full-width width-100-lg"></div>
				<div class="full-width">
					<div id="s-la-widget-7615" class="no-border-top"></div>
				</div>
			</div>
		</div>
		<!-- upcoming events -->
		<div class="padding py-5">
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
				<iframe class="mr-5 calendar" src="https://api3-eu.libcal.com/embed_mini_calendar.php?mode=month&iid=4105&cal_id=7853&l=5&tar=0&h=457&audience=&c=&z="/>
				<slide-events v-if="!$mobileCheck()" :number="2" />
			</div>
		</div>
		<!-- library's video content -->
		<div class="bg-lightgrey padding py-5">
			<span class="font-size-32 font-weight-bold" v-html="$t('vid_content').toUpperCase()" />
			<div class="mt-3">
				{{$t('video_content')}}
			</div>
			<div class="d-flex justify-content-between mt-3">
				<div class="flex-wrap d-flex flex-xl-nowrap w-100">
					<iframe class="videos mr-3 w-100" src="https://www.youtube.com/embed/IS3jYEzgb4A" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					<iframe class="videos mr-3 mt-3 mt-xl-0 w-100" src="https://www.youtube.com/embed/KMGDDYt2Zvs" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div>
				<div class="d-none d-lg-flex align-items-center">
					<img src="images/Video.svg">
				</div>
			</div>
			<div class="mt-5">
				<a class="link text-blue" href="https://www.youtube.com/channel/UCmuuTTBkfi8aUgUc56VY8kA" target="_blank">
					{{$t('see_all_videos')}} 
					<span class="ml-2 "><right-normal /></span>
				</a>
			</div>
		</div>
	</div>
</template>
<script type="text/javascript">
	// components
	import Search from '../Search/search'
	import SlideEvents from './components/slide_events'

	// icons
	import RightNormal from '../../assets/icons/RightNormal'

	export default{
		components:{Search,RightNormal,SlideEvents},
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
.calendar{
	border:none;
	height:300px;
}
.videos{
	height:18em;
}
</style>