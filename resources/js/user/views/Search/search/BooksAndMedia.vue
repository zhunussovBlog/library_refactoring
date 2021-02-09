<template>
	<keep-alive>
		<SimpleSearch :method="changeTab" v-if="tabActive==0"/> 
		<AdvancedSearch :method="changeTab" v-if="tabActive==1"/> 
	</keep-alive>
</template>
<script type="text/javascript">
// simple search div
import SimpleSearch from './SimpleSearch'
// advanced search div
import AdvancedSearch from './AdvancedSearch'
export default{
	components:{SimpleSearch,AdvancedSearch},
	data(){
		return {
			tabActive: 0,
			tabs:[{name:this.$t('simple_search_capital'),},{name:this.$t('advanced_search_capital'),}]
		}
	},
	methods:{
		changeTab(number){
			this.tabActive=number;
		},
	}
}
</script>
<style scoped>
.main{
	display: flex;
	flex-direction: column;
}
</style>