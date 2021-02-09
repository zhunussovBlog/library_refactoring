<template>
	<form class="search" @submit.prevent="getResults()">
		<input class="searchInput" :style="inputStyles" v-model="search" :placeholder="$t('search_eresources')"/>
		<button class="bg-orange border-radius searchButton" type="submit">{{$t('search')}}</button>
	</form>
</template>
<script type="text/javascript">
	import {warn} from "../../../mixins/validation"
	export default{
		mixins:[warn],
		computed:{
			inputStyles(){
				// let ans='border-top-right-radius:0;border-bottom-right-radius:0;';
				return (this.$route.meta.backgrounded ? 'border-color:transparent;':'');
			}
		},
		data(){
			return{
				search:''
			}
		},
		methods:{
			getResults(){
				alert("This feature is not currently available");
			}
		}
	}
</script>
<style scoped>
/*a little different from simple search ... but just a little*/
.search{
	display: flex;
	justify-content: space-between;
}
.searchInput{
	width: 100%;
	margin-right: 1.4vw;
}
button,input{
	font-size: 1.125em;
	line-height: 1.3125em;
}
input{
	padding:1.125em;
}
button{
	padding-left: 2.5em;
	padding-right: 2.5em;
	color:white;
/*	border-top-left-radius:0;
	border-bottom-left-radius:0;*/
}
</style>