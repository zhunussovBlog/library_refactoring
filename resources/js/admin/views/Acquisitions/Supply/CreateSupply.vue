<template>
	<form @submit.prevent="save()">
		<div class="title">{{$t((edit ?'edit':'create')+'_supplier') }}</div>
		
		<div class="row">
			<div class="pad">
				<input type="string" :placeholder="$t('name')" v-model="supply.name" required />
				<label class="placeholder required"></label>
			</div>
			<div class="pad">
				<input type="string" :placeholder="$t('bin')" v-model="supply.bin"/>
			</div>
		</div>
		<div class="row">
			<div class="pad">
				<input type="string" :placeholder="$t('commercial_name')" v-model="supply.com_name"/>
			</div>
		</div>
		<div class="subtitle">{{$t('contact')}}</div>
		<div class="row">
			<div class="pad">
				<input type="string" :placeholder="$t('address')" v-model="supply.address"/>
			</div>
			<div class="pad">
				<input type="string" :placeholder="$t('email')" v-model="supply.email" />
			</div>
		</div>
		<div class="row">
			<div class="pad">
				<input type="string" :placeholder="$t('phone')" v-model="supply.phone"/>
			</div>
			<div class="pad">
				<input type="string" :placeholder="$t('fax')" v-model="supply.fax"/>
			</div>
		</div>
		<div class="justify-content-end">
			<div class="pad">
				<button type="submit">{{$t('save')}}</button>
			</div>
			<div class="pad">
				<button type="button" class="cancel-button" @click="cancel">{{$t('cancel')}}</button>
			</div>
		</div>
	</form>
</template>
<script type="text/javascript">
// mixins
import {getAllData,last} from '../../../mixins/common'
export default{
	mixins:[last,getAllData],
	props:{
		edit:Boolean,
		data:Object,
		afterSave:Function,
	},
	data(){
		return{
			supply:{
				name:null,
				bin:null,
				com_name:null,
				address:null,
				email:null,
				phone:null,
				fax:null
			}
		}
	},
	methods:{
		save(){
			if(!this.$store.state.fullPageLoading){
				this.$store.commit('setFullPageLoading',true);
				this.supply.sup_name=this.supply.name;
				if(this.edit){
					this.supply.sup_id=this.data.id;
					this.editIt();
				}
				else{
					this.createIt();
				}
			}
		},
		cancel(){
			this.$emit('close');
		},
		editIt(){
			this.$http.put('/supplier/update',this.supply).then(response=>{
				this.$store.commit('setFullPageLoading',false);
				try{
					this.last('/supplier','suppliers');
				}catch(e){};
				this.$fire({
					title:"Edit",
					text:messages.success(response),
					type:"success",
					timer:1700
				});
				this.$emit('close');
			}).catch(error=>{
				let message = error.response ? error.response.data.error.message : 'Uncaught problem';
				this.$store.commit('setFullPageLoading',false);
				this.$fire({
					title:"Edit",
					text: messages.error(error),
					type:"error",
				});
			})
		},
		createIt(){
			this.$http.post('/supplier/create',this.supply).then(response=>{
				this.$store.commit('setFullPageLoading',false);
				try{
					this.afterSave(response.data.success.id);
				}catch(e){}
				try{
					this.getAllData(false,'','/supplier','suppliers',10);
				}catch(e){}
				this.$fire({
					title:"Create",
					text:messages.success(response),
					type:"success",
					timer:1700
				});
				this.$emit('close');
			}).catch(error=>{
				this.$store.commit('setFullPageLoading',false);
				this.$fire({
					title:"Create",
					text:messages.error(error),
					type:"error",
				});
			})
		}
	},
	created(){
		if(this.edit){
			this.supply=copy(this.data);
		}
	}
}
</script>
<style scoped>
.row>div{
	width:100%;
}
.pad{
	margin-top:1em;
}
</style>