<template>
	<div class="mt-10 bg-white pd-30-15">
		<div class="align-items-center">
			<Back />
			<span class="ml-20 font-size-1125 color-gray">Serving: &nbsp;</span>
			<span class="font-size-1125">{{info.name+' '+info.surname}}</span>
		</div>
		<div class="height-1 full-width mt-20"></div>
		<div class="mt-20">
			<span class="font-size-125 font-weight-500">Books to be given</span>
			<table-div :selectable="selectable" :sortable="false" :pagination="false" :clickables="false"></table-div>
		</div>
	</div>
</template>
<script type="text/javascript">
// components
import Back from '../../../components/common/Back'
import Table from '../../../components/common/Table'

// mixins
import {goTo} from '../../../mixins/goTo'
export default{
	mixins:[goTo],
	components:{Back,'table-div':Table},
	data(){
		return{
			selectable:{available:true,button_title:'check_in'}
		}
	},
	created(){
		this.info={};
	}
}
</script>
<style scoped>
.height-1{
	background-color: #E8E8E8;
}
</style>