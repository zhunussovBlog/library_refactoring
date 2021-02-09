<template>
	<div class="row">
		<div class="border-gray border-radius color-gray align-items-center cursor-pointer" @click="goBack()">
			<div class="rotate"><Right/></div>
			{{$t('back')}}
		</div>
	</div>
</template>
<script type="text/javascript">
// icons
import Right from '../../assets/icons/RightLittle'
export default{
	components:{Right},
	methods:{
		goBack(){
			this.$router.go(-1);
		}
	}
}
</script>
<style scoped>
.border-gray{
	padding:0.3125em 0.625em;
	border:0.0625em solid;
}
</style>