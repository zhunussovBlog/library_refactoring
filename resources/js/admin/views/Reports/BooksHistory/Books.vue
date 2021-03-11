<template>
	<div class="p-2">
		<div class="bg-white p-3 rounded-lg">
			<Tabs :components="components" tabClasses="mr-3 font-size-20" tabInactiveClasses="text-black" lineStyle="height:4px;bottom:-4px"/>
		</div>
	</div>
</template>
<script type="text/javascript">
// components
import Tabs from '../../../components/common/Tabs'

import History from './History'
import InventoryNumber from './InventoryNumber'

export default {
	components:{
		Tabs,
	},
	data(){
		return{
			components:[
			{
				name:'books',
				component:History,
			},
			{
				name:'inventory_number',
				component:InventoryNumber,
			}
			]
		}
	},
}		
</script>