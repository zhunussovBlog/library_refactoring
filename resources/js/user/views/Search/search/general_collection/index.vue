<template>
	<div>
		<keep-alive>
			<component :is="components[num].component" class="d-flex" />
		</keep-alive>
		<div class="link mt-3" @click="move(components[num].num)">
			{{$t(components[num].name)}}
		</div>
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
