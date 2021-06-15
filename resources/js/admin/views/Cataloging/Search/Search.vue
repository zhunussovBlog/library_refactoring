    <template>
    <div class="d-flex">
        <div class="bg-white mt-2 w-100 py-3 px-4">
        <form class="d-flex" @submit.prevent="loadResults()">
            <div class="select position-relative">
                <select class="no_border_right h-100" v-model="cataloging.search.add_options.type">
                    <option v-for="(type,index) in types" :key="index" :value="type.type">{{type.type_title}}</option>
                </select>
                <label class="placeholder">{{$t('type')}}</label>
            </div>
            <div class="flex-fill col-6 mx-3">
                <input-div :search='true' :placeholder="$t('search_cataloging')" :onSubmit="loadResults" v-model="cataloging.search.add_options.query"/>
            </div>
            <div class="ml-auto">
                <button type="submit" class="px-5">{{$t('search')}}</button>
            </div>
        </form>
        <div class="mt-5">
            <div v-if="cataloging.searching">
                <table-div  
                class="mt-5" 
                :heads="heads"
                :data="cataloging.data.res" 
                :showMore="showMore" 
                :link="link" 
                :commit="commit"
                :pagination="cataloging.pagination"
                :sortable="false"
                :custom_func="custom_func"
                />
            </div>
        </div> 
    </div>
    </div>
</template>
<script>
import { mapGetters } from 'vuex';
import InputDiv from "../../../components/Input.vue";
import TableDiv from '../../../components/Table'
import More from '../../../components/More'

import showModal from '../../../mixins/showModal'
import {getResults} from '../../../mixins/common'
import {goTo} from '../../../mixins/goTo'

export default{
    components: { InputDiv,TableDiv },
    mixins:[getResults,showModal,goTo],
    computed:{
        ...mapGetters(['cataloging'])
    },
    data(){
        return{
            heads:[
            {name:'isbn',link:'isbn'},
            {name:'call_number',link:'call_number'},
            {name:'title',link:'title'},
            {name:'author',link:'author'},
            {name:'publishers',link:'publisher'},
            {name:'year',link:'year'}
            ],
            link:'/cataloging/material',
            commit:'cataloging',
            showMore:{
                available:true,
                func:this.showit
            },
            custom_func:{
                available:true,
                class:'outline-green',
                func:this.editRec,
                title:'edit_rec'
            },
            types:[],
            More
        }
    },
    methods:{
        getSearchTypes(){
            this.$http.get(this.link+'/types').then(response=>{
                this.types=response.data.res;
            })
        },
        loadResults(){
			this.$store.dispatch('setStore',{label:this.commit,data:{page:0}});
			this.getResults(this.link,this.commit);
		},
        showit(info){
            let heads=[
            {
            name:'author',
            link:'author'
            },
            {
                name:'title',
                link:'title' 
            },
            {
                name:'publisher',
                link:'publisher'  
            },
            {
                name:'isbn',
                link:'isbn'   
            },
            {
                name:'call_number',
                link:'call_number'   
            },
            {
                name:'type',
                link:'type'   
            },
            {
                name:'year',
                link:'year'   
            }
            ];
            let props={
            data:info,
            heads:heads,
            custom_func:{
                title:'edit_rec',
                func:this.editRec
            },
            width:'35%'
        };
        this.showModal(this.More,props);
        },
        editRec(info){
            this.goTo('cataloging_edit',{info});
        }
    },
    created(){
        this.getSearchTypes();
    }
}
</script>