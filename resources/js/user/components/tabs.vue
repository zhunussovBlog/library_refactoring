<template>
	<div>
		<div class="d-flex position-relative" :class="mainClasses">
			<div :ref="'tab-'+index" v-for="(tab,index) in tabs" :key="index" @click="on_click(tab);setActive(index)" class="cursor-pointer transition mr-3 mb-3" :class="[tabClasses,(activeTab==index ? tabActiveClasses : tabInactiveClasses)]">{{$t(tab.name)}}
			</div>
			<div ref="line" class="bg-orange position-absolute transition line" :class="lineClasses"/>
		</div>
		<!-- booksandmedia & eresources -->
		<keep-alive >
			<component :is="tabs[activeTab].component" class="mt-3" :class="componentClasses"/>
		</keep-alive>
	</div>
</template>
<script type="text/javascript">
	export default{
		props:{
			components:Array,
			mainClasses:{
				type:[Array,String]
			},
			tabClasses:{
				type:String
			},
			tabActiveClasses:{
				type:String
			},
			tabInactiveClasses:{
				type:String
			},
			lineClasses:{
				type:[Array,String]
			},
			componentClasses:{
				type:[Array,String]
			},
			on_click:{
				type:Function,
				default(){
					return ()=>{};
				}
			}

		},
		watch:{
			tabs(){
				let items = [];
				this.components.forEach(tab=>{
					let component={};
					component.name=JSON.parse(JSON.stringify(this.$t(tab.name)));
					component.component=tab.component;
					items.push(component);
				});
				setTimeout(()=>{this.moveLine(this.activeTab)},50);
				return items;
			}
		},
		data(){
			return{
				activeTab:0,
				tabs:this.components
			}
		},
		methods:{
			moveLine(index){
				try{
					let parent=this.$refs['tab-'+index][0];
					let child=this.$refs['line'];
					child.style.left=parent.offsetLeft+'px';
					child.style.width=parent.offsetWidth+'px';
				}catch(error){}
			},
			setActive(index){
				this.activeTab=index;
				this.moveLine(index);
			}
		},
		mounted(){
			this.setActive(this.activeTab);
		}
	}
</script>
<style type="text/css">
.line{
	height:0.3125em;
	/*emaa naugad*/
	bottom: 0.3125em;
}
</style>