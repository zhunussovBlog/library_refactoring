<template>
    <main-body/>
</template>
<script>
import MainBody from './views/__main__'
export default {
    components:{
        MainBody
    },
    methods:{
        getAuth(){
            // checks if the user is logined
            this.$http.get('/user').then(response => {
                this.$store.commit('setUser',response.data.res.user);
            }).catch(e=>{});
        },
        setGlobalLocale(){
            this.$i18n.locale=JSON.parse(localStorage.getItem('lang')) ?? window.configs.default_lang;
        }
    },
    created () {
        this.getAuth();
        this.setGlobalLocale();
    }
}
</script>
<style scoped>
@import './assets/styles/style.css'
</style>