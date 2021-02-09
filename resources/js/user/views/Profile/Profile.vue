<template>
	<div class="mt-20">
		<div class="padding title font-size-2">
			{{$t('personal_cabinet')}}
		</div>
		<Tabs class="padding mt-20" :components="components"  tabClasses="font-weight-normal font-size-125 color-gray" tabActiveClasses="color-black" lineStyle="height:0.25em;"/>
	</div>
</template>
<script type="text/javascript">
// components
import Tabs from '../../components/common/Tabs'
export default{
	components:{Tabs},
	data(){
		return{
			components:[
			{name:'my_books',component:null},
			{name:'my_reserves',component:null}
			]
		}
	}
}	
</script>
<style scoped></style>