<template>
	<div id="navbar" class="align-items-center justify-content-between">
		
		<div class="align-items-center">
			<!-- hide sidebar button -->
			<div class="icon margin-right cursor-pointer" @click="hideSidebar()"><Bars /></div>
			
			<!-- those boxes that appear when u click on the navbar link -->
			<div class="font-size-125 align-items-center">
				<!-- first dropdown -> route parents -->
				<div class="relative" @focusout="first_shown=false" tabindex="2">
					<!-- the parent route name -->
					<!-- onclick it will show the first dropdown ( show (0 - > first ) ) -->
					<span class="link font-weight-500" @click="show(0)">{{$t(parentRoute.name)}}</span>

					<div class="dropdown border-radius bg-white shadowed pl-18 mt-10 ml-10" :class="{shown:first_shown}">
						<!-- routes only with a name are to be shown... so if you want to hide a route - you should just delete it's name -->
						<div class="link" v-for="(route,index) in allParentRoutes.filter(route=>route.name!=undefined)" @click="linkGoTo(route.name,0)">
							{{$t(route.name)}}
						</div>

					</div>
				</div>
				<!-- the divident that looks like this " > " -->
				<!-- is shown everytime except if the route has no children -->
				<span class="ml-10" v-if="!(parentRoute.meta.noChildren || currentRoute.meta.noChildren)"><ArrowDown class="left"/></span>

				<!-- second dropdown -> route children -->
				<!-- is shown everytime except if the route has no children -->
				<div class="relative ml-10" @focusout="second_shown=false" tabindex="3" v-if="!(parentRoute.meta.noChildren || currentRoute.meta.noChildren)">
					<!-- the current route name -->
					<!-- onclick it will show the second dropdown ( show (1 - > second ) ) -->
					<span class="link font-weight-500" @click="show(1)">{{$tc(currentRoute.name,10)}}</span>

					<div class="dropdown border-radius bg-white shadowed pl-18 mt-10" :class="{shown:second_shown}">
						<div class="link" v-for="(route,index) in allParentRoutes.filter(route=>route.name==parentRoute.name)[0].children" @click="linkGoTo(route.name,1)">
							{{$tc(route.name,10)}}
						</div>
					</div>
				</div>
			</div>

		</div>
		
		<div class="align-items-center">
			<!-- languages dropdown -->
			<Dropdown :itemOnClick="lanOnClick" :title="$i18n.locale.toUpperCase()" :items="languages" dropdownStyles="overflow:hidden;"/>
			<accountDropdown class="ml-10"/>
		</div>

	</div>
</template>
<script>
// components
import Dropdown from '../../common/Dropdown'
import accountDropdown from './Account'

// icons
import Bars from '../../../assets/icons/Bars'
import ArrowDown from '../../../assets/icons/ArrowDown'

// mixins
import {goTo} from '../../../mixins/goTo'
import setLocale from '../../../mixins/setLocale'

export default {
	mixins:[goTo,setLocale],
	components:{Dropdown,accountDropdown,Bars,ArrowDown},
	computed:{
		allParentRoutes(){
			return this.$router.options.routes;
		},
		parentRoute(){
			return this.$route.matched[0];
		},
		currentRoute(){
			return this.$route;
		}
	},
	data(){
		return{
			first_shown:false,
			second_shown:false,
			languages:[{name:'EN',locale:'en'},
			{name:'RU',locale:'ru'},{name:'KZ',locale:'kz'}]
		}
	},
	methods:{
		hideSidebar(){
			var sidebar=document.getElementById('sidebar');
			var main=document.getElementById('main');
			if(sidebar.offsetWidth==0){
				sidebar.classList.remove('text-no-wrap','sidebar_hidden');
				main.classList.remove('main_shown')
			}
			else{
				sidebar.classList.add('text-no-wrap','sidebar_hidden');
				main.classList.add('main_shwon')
			}
		},
		show(n){
			switch(n){
				case 0:
				this.first_shown=!this.first_shown
				break;
				case 1:
				this.second_shown=!this.second_shown
				break

			}
		},
		linkGoTo(link,n){
			try{
				this.goTo(link);
			}catch(e){}
			this.show(n);
		},

		// change language
		lanOnClick(locale){
			this.setLocale(locale.locale);
			this.$http.get('/locale/'+this.$i18n.locale);;
		}
	}
}
</script>
<style scoped>
#navbar{
	box-shadow: 0 0.125em 0.25em rgba(0, 0, 0, 0.25);
	min-height: 5em;
	height:8.72vh;
	z-index: 100;
	padding: 1.5625em;
}
.icon{
	padding:0.3125em 0.46875em;
	font-size: 1.73em;
}

.margin-right{
	/*at least ~20 px*/
	margin-right:max(2.7vh,1.25em);
}

.left{
	transform: rotate(90deg);
}

.shown{
	max-height: 11.25em;
}

.link{
	margin: 1.25em 0;
}

</style>