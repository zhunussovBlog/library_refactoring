<template>
	<div>
		<Tabs :components="components" class="relative padding padding-top"/>
		<Results />
	</div>
</template>
<script type="text/javascript">
// components

// search
import Tabs from '../../components/common/Tabs'
import booksAndMedia from './search/BooksAndMedia'
import eResources from './search/EResources'
//results
import Results from './results/Results'

export default{
	components:{Tabs,Results},
	data(){
		return{
			components:[
			{name:'books&media',component:booksAndMedia},
			{name:'eresources',component:eResources}
			]
		}
	}
}
</script>