<template>
    <div id="navbar" class="padding color-white justify-content-between bg-darkblue">
        <div tabindex="0" class="relative b-1k" @focusout="showToggle=false">
            <div class="toggleButton" @click="toggleShow()">
                <Bars />
            </div>
            <toggleElement :show="showToggle" :close="closeToggle"/>
        </div>
        <router-link to="home">
            <img src="../../../assets/images/logo.svg" @click="goTo('home');"/>
        </router-link>
        <div class="align-items-center n-1k">
            <router-link :to="link.name" v-for="(link,index) in links" :key="index" class="link mr-20 font-weight-500 text-no-wrap" :class="{'color-orange':link.name==$route.name}" @click="goTo(link.link)">{{$t(link.name).toUpperCase()}}</router-link>
            <div class="link mr-20 font-weight-500" @click="goToSDU()">{{$t('about').toUpperCase()}}</div>
        </div>
        <div class="align-items-center">
            <languagesDropdown class="mr-20" />
            <accountDropdown class="n-1k mr-20" v-if="logged"/>
            <button class="link n-1k" :class="backgrounded ? 'border-white' : 'border-black'" @click="showLogin" v-else> {{$t('login')}} </button>
        </div>
    </div>
</template>
<script>

// components
import login from "./Login"
import accountDropdown from './AccountDropdown'
import toggleElement from './Toggle'
import LanguagesDropdown from './LanguagesDropdown'

// mixins
import {goTo}from '../../../mixins/goTo'
import links from '../../../mixins/links'
import setLocale from '../../../mixins/setLocale'

// icons
import Bars from '../../../assets/icons/Bars'

export default {
    components:{login,accountDropdown,toggleElement,Bars,LanguagesDropdown},
    mixins:[goTo,links,setLocale],
    computed:{
        logged(){
            return this.$store.getters.logged;
        },
        backgrounded(){
            return this.$route.meta.backgrounded;
        }
    },
    data(){
        return{
            showToggle:false
        }
    },
    methods:{
        goToSDU(){
            window.open("https://sdu.edu.kz/library-new/", '_blank');
        },
        showLogin(){
            this.$modal.show(login,{},{
                height:'auto',
                width:'300px',
                classes:['bigger-border-radius'],
                styles:'padding:0.9375em;',
                shiftY:0.3
            },{});
        },
        toggleShow(){
            this.showToggle=!this.showToggle;
        },
        closeToggle(){
            this.showToggle=false;
        }
    }
}
</script>
<style scoped>
#navbar{
    z-index: 2;
    position: sticky;
    top:0;
    min-height:6.75em;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
/*since it's the only image here*/
img{
    width: 7.5em;
    cursor: pointer;
}

button,.toggleButton{
    border:0.0625em solid;
    border-radius: 0.3125em;
    background-color: transparent;
    cursor:pointer;
    color:inherit;
}

button{
    padding: 0.5625em 1.25em;
}

.toggleButton{
    padding:0.4375em 0.625em;
}
</style>
