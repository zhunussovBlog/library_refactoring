<template>
	<div :class="modal ? 'd-flex justify-content-center bg-greyer padding mh-100 overflow-auto' :'padding'">
		<div class="d-flex align-items-start bg-white border-top py-4" :class="{'content px-5':modal}">
			<div class="mr-5" v-if="printing!='print'">
				<div class="image rounded bg-grey" :style="'background-image: url('+this.data.image+')'"></div>
				<div class="d-flex align-items-center cursor-pointer py-2 mt-2" @click="copyLink()">
					<Save />
					<span class="ml-2">{{$t('copy_link')}}</span>
				</div>
				<div class="d-flex align-items-center cursor-pointer py-2" @click="printPage()">
					<Print />
					<span class="ml-2">{{$t('print_page')}}</span>
				</div>
			</div>
			<div class="flex-fill">
				<div class="d-flex flex-fill">
					<div class="flex-fill">
						<div class="overflow-hidden title font-weight-bold font-size-24 cursor-pointer">{{data.title}}</div>
						<div class="text-grey mt-2">
							<div v-if="data.author">{{data.author}}, {{data.year}}</div>
						</div>
						<div class="d-flex text-center text-blue mt-3">
							<div class="rounded-lg bg-lightblue p-1 px-3" v-if="data.type">{{$t(data.type)}}</div>
							<div class="rounded-lg bg-lightblue p-1 px-3 ml-3" v-if="data.call_number">{{data.call_number}}</div>
						</div>
						<div class="mt-3" v-if="data.description">
							<div class="text-grey font-size-14">
								{{$t('description')}}
							</div>
							<div class="mt-1" v-html="data.description" />
						</div>
						<div class="mt-3" v-if="data.content">
							<div class="text-grey font-size-14">
								{{$t('content')}}
							</div>
							<div class="mt-1" v-html="data.content" />
							<div class="text-blue cursor-pointer font-weight-bold mt-2">
								<div @click="expandContent(data,true)" v-if="!contentExpanded">{{$t('expand')}}</div>
								<div @click="expandContent(data,false)" v-else>{{$t('shrink')}}</div>
							</div>
						</div>
					</div>
					<div class="text-center col-2 px-0">
						<div class="bg-lightgrey rounded-lg p-2 text-no-wrap">
							{{data.availability}}
							{{$t('availability')}}
						</div>
					</div>
				</div>
				<div class="title mt-4">
					<div class="text">
						{{$t('details')}}
					</div>
					<div class="tline"/>
				</div>
				<table class="table">
					<tbody>
						<tr v-for="(info,index) in new Array(Math.ceil(array_data.length/2))" :key="index">
							<td :colspan="array_data[(index*2)+1]==undefined ? '2':null">
								<div class="text-grey">
									{{$t(array_data[index*2].key)}}:
								</div>
								<div>
									{{array_data[index*2].value!=undefined ? array_data[index*2].value:$t('undefined')}}
								</div>
							</td>
							<td v-if="array_data[(index*2)+1]!=undefined">
								<div class="text-grey">
									{{$t(array_data[(index*2)+1].key)}}:
								</div>
								<div>
									{{array_data[(index*2)+1].value!=undefined ? array_data[(index*2)+1].value:$t('undefined')}}
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<!-- fixed stuff -->
		<div class="exit cursor-pointer" @click="closeModal()" v-if="modal">
			<X/>
		</div>
	</div>
</template>
<script type="text/javascript">
	import {goTo} from '../../mixins/goTo'
	import {getBookImage} from '../../mixins/search'

	import RightLittle from '../../assets/icons/RightLittle'
	import X from '../../assets/icons/X'
	import Save from '../../assets/icons/Save'
	import Print from '../../assets/icons/Print'

	export default{
		props:{
			modal:Boolean,
			id:[String,Number]
		},
		mixins:[goTo,getBookImage],
		components:{RightLittle,X,Save,Print},
		data(){
			return{
				data:{
					image:'',
					isbn:'',
					description:'',
					content:''
				},
				array_data:[],
				xml:[],
				link:'',
				contentExpanded:false,
				printing:false
			}
		},
		methods:{
			expandContent(data,bool){
				if(this.xml && data.content){
					if(bool){
						data.content=this.getFromCatalog(this.xml,'505.a').split('--').join('<br>');
						this.contentExpanded=true;
					}
					else{
						data.content=data.content.split(/--|<br>/).splice(0,2).join('--')
						this.contentExpanded=false;
					}
				}
			},
			closeModal(){
				this.$emit('close');
				document.documentElement.classList.remove('overflow-hidden');
			},
			copyLink(){
				var copyText = document.createElement('input');
				copyText.value=this.link;
				document.body.appendChild(copyText);

				copyText.select();
				copyText.setSelectionRange(0, 99999); /* For mobile devices */
				try{
					document.execCommand("copy");
					alert('Copied successfully '+copyText.value);
				}catch(e){
					alert('Something went wrong');
				}
				
				document.body.removeChild(copyText);
			},
			printPage(){
				if(!this.printing){
					let routeData = this.$router.resolve({name: 'full', query: {id: this.data.id,mode:'print',contentExpanded:this.contentExpanded}});
					window.open(routeData.href, '_blank');
					return 0;
				}
				window.print();
			},
			capitalize(s){
				let string = s.slice();
				if (typeof string !== 'string') return ''
					return string.charAt(0).toUpperCase() + string.slice(1)
			},
			objectWithoutKey(object,key){
				const {[key]: deletedKey, ...otherKeys} = object;
				return otherKeys;
			},
			loadData(){
				this.$store.commit('setFullPageLoading',true);
				this.$http.defaults.baseURL = window.configs.baseURL;
				this.$http.get('/api/media/show/'+this.id).then(response=>{
					this.xml=response.data.xmlInfo;
					this.data= Object.assign(this.data,this.importFromXML(response));
					this.data.link=this.link;
					this.array_data=this.convertToArray(objectWithoutKey(this.data,['id','type_key','issn','status','availability','image','description','content']));
					try{
						this.getBookImage(this.data,!this.data.description);
					}catch(e){}
				}).catch(error=>{
					console.error(error);
				}).then(()=>{
					this.$store.commit('setFullPageLoading',false);
					this.$http.defaults.baseURL = window.configs.baseURL + window.configs.api;
				}).then(()=>{
					if(this.printing){
						this.expandContent(this.data,this.$route.query.contentExpanded=='true');
					}
				}).then(()=>{
					if(this.printing){
						this.printPage();
						window.close();
					}
				});
			},
			importFromXML(response){
				// need to have image in data
				let data=response.data.res;
				let xml=response.data.xmlInfo;
				if(xml){
					data.description=this.getFromCatalog(xml,'520.a');
					let moreDescription=this.getFromCatalog(xml,'520.b');
					if(moreDescription){
						data.description+='<br>'+moreDescription;
					}
					data.content=this.getFromCatalog(xml,'505.a');
					this.expandContent(data,false);
					data.attribution=this.getFromCatalog(xml,'245.c');				
				}
				
				return data;
			},
			getFromCatalog(xml,code){
				let data=xml.find(elem=>elem.id==code);
				return data ? data.data : null;
			},
			convertToArray(object){
				var arr=[];
				for(let key in object){
					let obj={key:key,value:object[key]}
					arr.push(obj)
				}
				return arr;
			},
		},
		created(){
			if(!this.id){
				this.id=this.$route.query.id;
				if(!this.id){
					this.goTo('home');
				}
			}

			this.link=window.location.protocol+'//'+window.location.hostname+'/'+this.$i18n.locale+'/full?id='+this.id;

			if(!this.printing){
				this.printing=this.$route.query.mode;
			}

			this.loadData();
		}
	}
</script>
<style scoped>
.image{
	min-width:12em;
	max-width:12em;
	min-height:15em;
	max-height:15em;
	background-repeat: no-repeat;
	background-size: 100% 100%;
}
.bg-greyer{
	background: rgba(0,0,0, 0.3 ) !important;
}
.exit{
	color:white;
	position: absolute;
	top:10%;
	right:4%;
}
.title{
	display:flex;
	align-items:flex-end;
}
.title>.text{
	padding-right:.3125em;
	font-size:1.5em;
}
.title>.tline{
	height:1px;
	flex:1;
	background:#DADADA;
	margin-bottom:.5em;
}
td{
	border-top: none;
	padding-left: 0;
}

.mh-100{
	min-height: 100%;
}

.content{
	padding-top: 5% !important;
	max-width:1120px;
	width:100%;
	min-height: 100vh;
	height:100%;
}
</style>