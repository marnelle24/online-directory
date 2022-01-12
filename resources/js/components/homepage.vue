<template>
    <div>
        <div class="main-background">
            <section>
                <div class="flex-container pt-5">
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
                    <input type="radio" value="all" id="option-1" v-model="searchtype">
                    <input type="radio" value="church" id="option-2" v-model="searchtype">
                    <input type="radio" value="org" id="option-3" v-model="searchtype">
                    <label for="option-1" class="option option-1">
                        <div class="dot"></div>
                        <span>All</span>
                    </label>
                    <label for="option-2" class="option option-2">
                        <div class="dot"></div>
                        <span>Church</span>
                        </label>
                    <label for="option-3" class="option option-3">
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
        <!-- <div v-show="isShowResult" id="searchResult" style="min-height: 400px"> -->

        <div v-show="isShowResult" id="searchResult" class="container-fluid mt-4">
            <div class="row justify-content-center">
                <div class="ads_vertical_style col-md-2 d-flex justify-content-end">
                    <img width="75%" src="/images/ads1.jpg" style="cursor:pointer; max-height: 700px;" />
                </div>
                <div class="col-md-8">

                    <div class="row justify-content-center">
                        <div class="col-md-12 mb-5 text-center">
                            <img class="horizontal_ads" src="/images/test_ad.jpeg" style="cursor:pointer;" />
                        </div>
                    </div>
                    <!-- <div class="row" v-for="(chunk, idx) in resultChunk" :key="idx" :class="{'justify-content-center': chunk.length < 8 }">
                        <div class="col-md-3" v-for="item in chunk" :key="item.id">
                            <card :result="item" :searchtype="searchtype"></card>
                        </div>
                        <img v-if="idx !== resultChunk.length - 1" class="my-5" width="100%" src="https://via.placeholder.com/750x80.png?text=Dummy+Image+For+Advertisement" style="cursor:pointer;" />
                    </div> -->
                    
                    <div class="row">
                        <div class="col-md-12">
                            <p class="text-left text-muted fst-italic mb-0">Search result: {{ searchResult.length }} {{ searchResult.length > 1 ? 'records' : 'record' }} found</p>
                        </div>
                    </div>

                    <div class="row" style="min-height: 400px">
                        <div class="col-md-4 mt-4" v-for="item in paginatedItems" :key="item.id">
                            <div class="card item">
                                <img v-if="item.is_nccsmember" src="/images/nccs_member_label.png" width="30px" class="nccs_icon" />
                                <img :src="item.avatar ? `storage/${item.avatar}` : 'https://via.placeholder.com/243x190.png?text=Placeholder' " 
                                    alt="Profile photo" class="item-img" />
                                <div class="card-body">
                                    <h5 class="mb-0 text-truncate">
                                        <a :href=" `/${item.slug}`" class="text-decoration-none text-dark">
                                            {{ item.name }}
                                        </a>
                                    </h5>
                                    <small class="text-muted text-truncate subtitle fst-italic">{{ item.x }}</small>
                                    <br />
                                    <small :class="{ 'bg-dark text-white py-1 px-2 rounded':item.type==='church', 'bg-warning text-white py-1 px-2 rounded':item.type==='org' }">
                                        {{ item.type === 'org' ? 'Organisation' : 'Church' }}
                                    </small>
                                </div>
                            </div>

                        </div>
                    </div>

                    <b-pagination 
                        v-if="searchResult.length > perPage"
                        class="mt-4"
                        size="md" 
                        align="center" 
                        v-model="currentPage" 
                        @change="onPageChanged"
                        :total-rows="searchResult.length" 
                        :per-page="perPage">
                        <template #first-text><span class="text-primary">First</span></template>
                        <template #prev-text><span class="text-primary">Prev</span></template>
                        <template #next-text><span class="text-primary">Next</span></template>
                        <template #last-text><span class="text-primary">Last</span></template>
                    </b-pagination>

                </div>
                <div class="ads_vertical_style col-md-2 d-flex justify-content-start">
                    <img width="75%" src="/images/ads2.jpeg" style="cursor:pointer; max-height: 700px;" />
                </div>
            </div>
        </div>

        <!-- vue info modal -->
        <b-modal size="lg" title="Create User Account" hide-header-close hide-footer v-model="registrationModal">
            <registration></registration>
        </b-modal>

        
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
            searchtype: 'all',
            searchResult: [],
            isShowResult: false,
            registrationModal: false,
            resultChuckCounter: 0,

            paginatedItems: [],
            perPage: 9,
            currentPage: 1

        }

    },

    computed: {
        resultChunk(){
            return _.chunk(this.searchResult, 8);
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
            
            this.searchResult = [];

            axios.post('/api/search', data)
                 .then(response => {
                    
                    this.searchResult = response.data;

                    this.paginate(this.perPage, 0);

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
            
        },

        paginate(page_size, page_number) {
            
            let itemsToParse = this.searchResult;

            this.paginatedItems = itemsToParse.slice(
                page_number * page_size,
                (page_number + 1) * page_size
            );

        },

        onPageChanged(page) {
            this.paginate(this.perPage, page - 1);
        }
    },

}
</script>

<style scoped>
    
    .nccs_icon {
        position: absolute;
        margin-left: 10px;
    }

    .item-img {
        width: 100%;
        height: 235px;
        object-fit: cover;
        object-position: center;
        background: #ddd;
    }

</style>