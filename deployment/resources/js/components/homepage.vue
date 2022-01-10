<template>
    <div>
        <div class="main-background">
            <section>
                <div class="flex-container">
                    <div class="flex-child">
                        <a href="#">
                            <img src="/images/nccs_logo.png" alt="NCCS_logo" class="logo-attribute" />
                        </a>
                    </div>
                    <div class="flex-child">
                        <template v-if="loggedin_user">
                            <a href="/admin/resources/churches" class="header-link">
                                BACK TO PORTAL >>
                            </a>
                        </template>
                        <template v-else>
                            <a href="/admin/login" class="header-link">LOGIN</a> 
                            <span class="header-span">&nbsp;|&nbsp;</span> 
                            <a href="#" class="header-link" @click="registrationModal = !registrationModal">REGISTER</a>
                        </template>
                    </div>
                </div>
            </section>

            <section>
                <div class="content-wrapper">
                    <h1 class="Title">Welcome to the Registry of Churches & Christian Organizations in Singapore</h1>
                </div>
            </section>

            <section class="search-input-section">
                <div class="option-wrapper">
                    <input type="radio" value="church" id="option-1" v-model="searchtype">
                    <input type="radio" value="org" id="option-2" v-model="searchtype">
                    <label for="option-1" class="option option-1">
                        <div class="dot"></div>
                        <span>Church &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        </label>
                    <label for="option-2" class="option option-2">
                        <div class="dot"></div>
                        <span>Organisation</span>
                    </label>
                </div>
                <div class="Wrapper">
                    <div class="Input">
                        <input 
                            type="search" 
                            id="input" 
                            class="Input-text" 
                            placeholder="What's on your mind? Search anything..." 
                            v-model="searchKeyword"
                            @keyup.enter="searchRecord()">
                    </div>
                </div>
            </section>
        </div>
        <!-- search result area -->
        <div v-show="isShowResult" id="searchResult" style="min-height: 400px">
            <section class="result-section">
                <div class="result-flex-wrapper">
                    <div v-for="item in searchResult" :key="item.id" >
                        <card :result="item" :searchtype="searchtype"></card>
                    </div>
                </div>

            <!-- vie info modal -->
            <b-modal size="lg" title="Create User Account" hide-header-close hide-footer v-model="registrationModal">
                <registration></registration>
            </b-modal>


            </section>
        </div>
        
        <getFooter v-if="isShowResult"></getFooter>
    </div>
</template>

<script>

import card from '../components/card'
import getFooter from '../components/footer'

import registration from '../components/modals/registration'

export default {

    components: {
        card,
        getFooter,
        registration
    },

    props: ['user'],

    data() {
        return {
            loggedin_user: this.user ? this.user : null,
            searchKeyword: null,
            searchtype: 'church',
            searchResult: null,
            isShowResult: false,

            registrationModal: false
        }

    },

    mounted() {
    },

    methods: {

        searchRecord() {

            if(this.searchKeyword === null || this.searchKeyword === '')
                return;

            let data = {
                    searchKeyword: this.searchKeyword,
                    searchtype: this.searchtype
                }
            
            this.searchResult = {};

            axios.post('/api/search', data)
                 .then(response => {
                    
                    this.searchResult = response.data;
                    this.isShowResult = true;

                    setTimeout(() =>{
                        var my_element = document.getElementById("searchResult");
                        my_element.scrollIntoView({
                            behavior: "smooth",
                            block: "start",
                            inline: "nearest"
                        });
                    }, 1000);

                
                 })
                 .catch(error => {
                     console.log(error);
                 })
            
        }
    },

}
</script>

<style>

</style>