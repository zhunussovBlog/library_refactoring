<template>
    <div class="d-flex">
		<div class="bg-white mt-2 w-100 py-3 px-4">
            <div class="mb-3">
                <back />
            </div>
            <div class="d-flex justify-content-between">
                <div>Management: {{info.title}}</div>
                <div class="d-flex">
                    <button class="outline-black mx-3">
                        <Print class="mr-2" />
                        Print call number
                    </button>
                    <button class="outline-black">
                        Preview
                    </button>
                    <button class="outline-black mx-3">
                        Import from WorldCat
                    </button>
                    <button class="outline-black" @click="saveXML()">
                        Export to XML
                    </button>
                </div>
            </div>
            <div class="d-flex mt-5">
                <div class="text-center px-2 py-3 border rounded">
                    <div class="text-grey font-size-14 py-2 my-1">
                        Section
                    </div>
                    <div class="py-2 my-1 cursor-pointer"
                        :class="{'px-3 border rounded border-orange text-orange':sectionSelected==index}"
                        @click="sectionSelected=section.section;tagSelected={}"
                        v-for="(section,index) in sectioned" :key="index">
                            {{section.section}}
                    </div>
                </div>
                <div class="p-3 ml-3 border rounded flex-fill ">
                    <div class="text-grey font-size-14 py-2 my-1">
                        Section tag
                    </div>
                    <div class="d-flex">
                        <div class="rounded px-3 py-2 font-weight-bold bg-lightgrey text-grey"
                            :class="[{'bg-orange text-white':tagSelected.field_code==tag.field_code},{'ml-2':index!=0}]"
                            @click="tagSelected=tag"
                            v-for="(tag,index) in sectioned[sectionSelected].tags" :key="index">
                                {{tag.field_code}}
                        </div>
                    </div>
                    <div class="text-center font-weight-bold">
                        {{tagSelected.title}}
                    </div>
                    <table class="table mt-3">
                        <thead>
                            <!-- <tr>
                                <th colspan="5" class="tline" />
                            </tr> -->
                            <tr>
                                <th>
                                    {{$t('title')}}
                                </th>
                                <th>
                                    {{$t('subtags')}}
                                </th>
                                <th>
                                    {{$t('ind1')}}
                                </th>
                                <th>
                                    {{$t('ind2')}}
                                </th>
                                <th>
                                    {{$t('data')}}
                                </th>
                                <th>
                                    &nbsp;
                                </th>
                            </tr>
                            <!-- <tr>
                                <th colspan="5" class="tline" />
                            </tr> -->
                        </thead>
                        <tbody>
                            <tr v-for="(info,index) in tagSelected.data" :key="index">
                                <td class="td_no_input w-25">
                                    <div v-if="info.is_added">
                                        &nbsp;
                                    </div>
                                    <div v-else>
                                        {{info.title}}
                                    </div>
                                </td>
                                <td class="little_td">
                                    <input type="text" class="little_input" v-model="info.field_code" disabled/>
                                </td>
                                <td class="little_td">
                                    <input type="text" class="little_input" v-model="info.ind1"/>
                                </td>
                                <td class="little_td">
                                    <input type="text" class="little_input" v-model="info.ind2"/>
                                </td>
                                <td class="w-50">
                                    <input type="text" class="w-100" v-model="info.data"/>
                                </td>
                                <td>
                                    <button class="outline-blue" @click="removeSubtag(info,index)" v-if="info.is_added || info.repeatable==undefined">-</button>
                                    <button class="outline-blue" @click="addSubtag(info,index)" v-if="info.repeatable==1">+</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="d-flex">
                        <button class="ml-auto width-unset" @click="save()">
                            {{$t('save')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
// components
import Back from '../../../components/common/Back.vue'
import Print from '../../../assets/icons/Print.vue'

// mixins
import {goTo} from '../../../mixins/goTo';
import {message_success,message_error} from '../../../mixins/messages';
import {download_file} from '../../../mixins/common';

export default {
    mixins:[goTo,message_error,message_success,download_file],
    props:{
        info:Object
    },
    components: { Back,Print },
    data(){
        return{
            edit_info:[],
            sectioned:[],
            commit:'cataloging',
            link:'cataloging/material',
            sectionSelected:0,
            tagSelected:{}
        }
    },
    methods:{
        getEditInfo(){
            // +this.info.id
            // +this.info.type_key+
            this.$store.commit('setFullPageLoading',true);
            this.$http.get(this.link+'/'+this.info.type_key+'/'+this.info.id).then(response=>{
                this.edit_info=response.data.res;
                this.divideIntoSections();
                this.divideIntoSubsections();
                this.$store.commit('setFullPageLoading',false);
            })
        },
        divideIntoSections(){
            let sections=[];

            //functions
            let findByChar=(array,char,toSearch)=>{
                for(let i =0; i<array.length;i++){
                    let elem=array[i];
                    if(elem[toSearch]==char){
                        return true
                    }
                }
                return false;
            }

            for(let i=0;i<this.edit_info.length;i++){

                let info=this.edit_info[i];
                let char=info.id.charAt(0);

                if(!findByChar(sections,char,'section')){
                    let section={section:char,info:[info]};
                    sections.push(section);
                }
                else{
                    sections[char].info.push(info);
                }
            }

            this.sectioned=sections;
        },
        divideIntoSubsections(){
            this.sectioned.forEach(section=>{
                section.tags=section.info.filter(elem=>elem.pid==undefined);
                section.tags.forEach(tag=>{
                    tag.selected=false;
                    tag.data=section.info.filter(elem=>elem.pid==tag.field_code)
                })
            })
        },
        addSubtag(info,index){
            let new_data=copy(info);
            new_data.ind1=''
            new_data.ind2=''
            new_data.data=''
            new_data.is_added=true;
            new_data.repeatable=0;
            
            this.tagSelected.data.splice(index+1, 0, new_data);
            
            let lindex=this.sectioned[this.sectionSelected].info.indexOf(info);
            
            this.sectioned[this.sectionSelected].info.splice(lindex+1,0,new_data);
        },
        removeSubtag(info,index){
            this.tagSelected.data.splice(index, 1);

            let lindex=this.sectioned[this.sectionSelected].info.indexOf(info);
            
            this.sectioned[this.sectionSelected].info.splice(lindex,1);
        },
        save(){
            this.$store.commit('sestFullPageLoading',true);
            let joinSections=()=>{
                let res=[];
                this.sectioned.forEach(section=>{
                    section.info.forEach(data=>{
                        if(data.is_added){
                            delete data.is_added;
                            console.log(data);
                        }
                        if(data.pid==undefined){
                            data.data=null;
                        }
                    })
                    res=res.concat(section.info);
                })
                return res
            };
            let res = joinSections();

            this.$http.post(this.link+'/'+this.info.type_key+'/'+this.info.id+'/edit',{data:res}).then(response=>{
                this.message_success('edit',response);
                this.tagSelected={};
                this.getEditInfo();
            }).catch(e=>{
                this.message_error('edit',e);
            }).then(()=>{
                this.$store.commit('sestFullPageLoading',false);
            })
        },
        saveXML(){
            this.$http.get(this.link+'/export/'+this.info.type_key+'/'+this.info.id).then(response=>{
                this.download_file('xml_'+response,this.info.title,'xml');
            })
        }
    },
    created(){
        if(!this.info){
            this.goTo('cataloging_search');
        }else{
            this.getEditInfo();
        }
    }
}
</script>
<style scoped>
/* table {
	border-collapse: separate;
    border-spacing:2em .875em;
} */

td{
	border: none;
    /* border-radius: .3125em;
    
	padding: 1em 1.25em; */
}

th {
	text-align: left;
	font-weight: 500;
    border: 1px solid #E8E8E8 !important;
    border-left:none !important;
    border-right:none !important;
}
/* .tline{
    border-top:0.0625em solid #E8E8E8 !important;
    padding:0;
} */
input{
    width:unset;
}
input,input:disabled{
    border-color: inherit;
}
.little_td{
    width:7%;
}
.little_input{
    width:2.5em;
    padding-left: .125em;
    padding-right: .125em;
    text-align: center;
}
.td_no_input{
    border:1px solid #E8E8E8;
    border-left:none;
    border-radius: .3125em;
	padding: 1em 1.25em;
}
</style>