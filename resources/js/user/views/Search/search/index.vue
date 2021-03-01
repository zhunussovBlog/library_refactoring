<template>
	<div>
		<tabs :components="components" class="position-relative" tabClasses="font-size-24 font-weight-bold mr-4" tabActiveClasses="text-orange"/>
	</div>
</template>
<script type="text/javascript">
// components
import tabs from '../../../components/tabs'
import gen_col from './general_collection'
import e_resources from './e_resources'

export default{
	components:{tabs},
	data(){
		return{
			components:[
			{name:'books&media',component:gen_col},
			{name:'eresources',component:e_resources}
			]
		}
	}
}
</script>