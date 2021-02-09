<template>
    <div id="app" class="row">
        <!-- full page loader -->
        <div class="full-page-loader align-items-center justify-content-center" v-if="fullPageLoading">
            <clip-loader size="6.25em" color="#a4d9f6" borderWidth='0.5em'/>
        </div>

        <sidebar />
        
        <div id="main" class="transition col full-width">
            <navbar />
            <div class="main full-height">
                <router-view :key="$route.fullPath" class="route" />
            </div>
        </div>
    
    </div>
</template>
<script>
// importing bars
// all App related stuff -> things that are common for all templates -> they're located in components/App
import sidebar from './components/App/Sidebar/Sidebar'
import navbar from './components/App/Navbar/Navbar'

// loading indicator
import ClipLoader from 'vue-spinner/src/ClipLoader'

export default {
    components:{
        sidebar,
        navbar,
        ClipLoader
    },
    computed:{
        fullPageLoading(){
            return this.$store.getters.fullPageLoading;
        }
    },
    methods:{
        getAuth(){
            // checks if the user is logined
            this.$http.get('/auth/init').then(response => {
                this.$store.commit('setUser',response.data.user);
            }).catch(e=>{});
        },
        setGlobalLocale(){
            this.$i18n.locale=JSON.parse(localStorage.getItem('lang')) ?? 'en';
        }
    },
    created () {
        this.getAuth();
        this.setGlobalLocale();
    }
}
</script>
<style scoped>
.main{
    /*ok... this color does not repeat*/
    background-color: #E7E7E7;
}
.full-page-loader{
    position: fixed;
    top:0;
    left:0;
    height:100vh;
    width:100vw;
    background-color: rgba(0,0,0,0.30);
    z-index: 1000;
}
.route{
    min-height: 100%;
}
@import './assets/styles/style.css'
</style>
