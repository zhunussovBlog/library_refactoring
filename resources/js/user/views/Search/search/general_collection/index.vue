<template>
	<div>
		<keep-alive>
			<component :is="components[num].component" class="d-flex mb-3" />
		</keep-alive>
		<u class="link ml-2 font-weight-bold" @click="move(components[num].num)" v-if="!$mobileCheck()">
			{{$t(components[num].name)}}
		</u>
	</div>
</template>
<script type="text/javascript">
	import simple from './simple'
	import advanced from './advanced'
	export default{
		data(){
			return{
				num:0,
				components:[
				{
					component:simple,
					num:1,
					name:'advanced_search'
				},
				{
					component:advanced,
					num:0,
					name:'simple_search'
				}
				]
			}
		},
		methods:{
			move(num){
				this.num=num;
			}
		}
	}
</script>
