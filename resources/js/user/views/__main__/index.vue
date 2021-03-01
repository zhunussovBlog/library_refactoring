<template>
	<div id="app" class="d-flex flex-column">
		<navbar />
		<router-view />
		<footer-div class="mt-auto" v-if="$route.meta.footer" />
	</div>
</template>
<script type="text/javascript">
	import Navbar from './navbar'
	import Footer from './footer'
	export default{
		components:{
			'footer-div':Footer,
			Navbar
		}
	}
</script>