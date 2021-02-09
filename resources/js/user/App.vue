<template>
    <div id="app">
        <navbar/>
        <div class="loader" v-if="$store.getters.loading">
            <half-circle-spinner
            :animation-duration="1000"
            :size="80"
            class="spinner"
            color="#FF9D29"
            />
        </div>
        <div id="main">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
// in components/App there are only this page components
import Navbar from './components/App/Navbar/Navbar'

// loading indicator
import HalfCircleSpinner from 'epic-spinners/src/components/lib/HalfCircleSpinner'

export default {
    components:{
        Navbar,
        HalfCircleSpinner
    },
    beforeCreate(){
        if(this.$mobileCheck()) {
            let element = document.createElement("link");
            element.setAttribute("rel", "stylesheet");
            element.setAttribute("type", "text/css");
            element.setAttribute("href", "./css/responsive.css");
            document.getElementsByTagName("head")[0].appendChild(element);
        }
    },
    created() {
        this.$http.get('auth/init').then(response => {
            this.$store.commit('setUser',response.data.user);
        }).catch(e=>{
        });
        this.$i18n.locale=JSON.parse(localStorage.getItem('lang')) ?? 'en';
    },
}
</script>
<style>
.loader{
    position: fixed;
    top:0;
    z-index: 2000;
    width:100%;
    height:100%;
    background-color: rgba(0,0,0,0.45);
}
.spinner{
    position: absolute;
    pointer-events: none;
    top:calc(50% - 2.5em);
    left:calc(50% - 2.5em);
}
@import './assets/styles/style.css';
</style>
