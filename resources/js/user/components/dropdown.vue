<template>
	<div class="dropdown">
		<a class="link dropdown-toggle"  data-toggle="dropdown">
			<span v-if="title.uppercase">{{$t(title.link).toUpperCase()}}</span>
			<span v-else>{{$t(title.link)}}</span>
		</a>
		<div class="dropdown-menu" :class="menu_classes">
			<a :target="links ? '_blank':''" :href="item.link" class="dropdown-item link" v-for="(item,index) in data" :key="index" @click="on_click(item)">{{$t(item.name ? item.name:item)}}</a>
		</div>
	</div>
</template>
<script type="text/javascript">
	export default{
		props:{
			dropdown_classes:{
				type:[String,Array]
			},
			menu_classes:{
				type:[String,Array]
			},
			data:{
				type:Array
			},
			on_click:{
				type:Function,
				default(){
					return ()=>{};
				}
			},
			title:{
				type:[Object,String]
			},
			links:{
				type:Boolean
			}
		}
	}
</script>
<style scoped></style>