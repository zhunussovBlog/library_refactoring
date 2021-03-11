<template>
	<div>
		<div class="tabs position-relative" :class="tabsClasses" :style="tabsStyle">
			<div :ref="'tab-'+index" v-for="(tab,index) in tabs" @click="setActive(index,tab)" class="tab" :class="[activeTab==index ? 'text-orange '+tabActiveClasses : 'text-grey '+tabInactiveClasses,tabClasses]" :style="tabStyle">{{$t(tab.name)}}
			</div>
			<div ref="line" class="line" :class="lineClasses" :style="lineStyle"/>
		</div>
		<keep-alive>
			<component :is="tabs[activeTab].component" class="mt-4" :class="componentClasses" :style="componentStyle"/>
		</keep-alive>
	</div>
</template>
<script type="text/javascript">
	export default{
		props:{
			components:Array,
			tabsStyle:{type:[Array,String],default(){return ''}},
			tabStyle:{type:[Array,String],default(){return ''}},
			lineStyle:{type:[Array,String],default(){return ''}},
			componentStyle:{type:[Array,String],default(){return ''}},
			tabsClasses:{type:[Array,String],default(){return ''}},
			tabClasses:{type:[Array,String],default(){return ''}},
			lineClasses:{type:[Array,String],default(){return ''}},
			componentClasses:{type:[Array,String],default(){return ''}},
			tabActiveClasses:{type:String,default(){return ''}},
			tabInactiveClasses:{type:String,default(){return ''}},
			tabOnClick:Function

		},
		computed:{
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
			setActive(index,tab){
				try{
					this.tabOnClick(tab);
				}catch(e){}
				this.activeTab=index;
				this.moveLine(index);
			}
		},
		mounted(){
			this.setActive(this.activeTab);
		}
	}
</script>