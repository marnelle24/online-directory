<template>
    <div class="item">
        <img v-if="item.is_nccsmember" src="/images/nccs_member_label.png" width="40px" class="nccs_icon">
        <img :src="item.avatar ? 'storage/'+item.avatar : 'https://via.placeholder.com/150/FF0000/FFFFFF?Text=Down1.com' " alt="Avatar" class="item-img" />
        <div class="container">
            <h1 class="mb-0">{{ item.name }}</h1>
            <p class="text-muted subtitle">{{ type === 'church' ? 'Denomination:' : 'Category:' }} : {{ item.church_denom }}</p>
            
            <b-button squared variant="outline-primary" size="sm" class="m-1" @click="infoModal = !infoModal">View Info</b-button>
            <b-button squared variant="outline-primary" size="sm" class="m-1" @click="servicesModal = !servicesModal">Service Schedule</b-button>
            <b-button squared variant="outline-primary" size="sm" class="m-1" @click="contactDetails = !contactDetails">Contact Details</b-button>
            <b-button squared variant="outline-primary" size="sm" class="m-1" @click="pastorStaff = !pastorStaff">Pastors & Staffs</b-button>
        </div>

        <!-- view details modal -->
        <b-modal size="xl" :title="'About ' + item.name" hide-header-close no-close-on-backdrop ok-only v-model="infoModal">
            <viewInfo :getInfo='item' :type="type"></viewInfo>
        </b-modal>

        <!-- service schedule -->
        <b-modal size="xl" :title="'Service Schedules of ' + item.name" hide-header-close ok-only v-model="servicesModal">
            <serviceSchedule :getInfo='item' :type="type"></serviceSchedule>
        </b-modal>

        <!-- Contact Details -->
        <b-modal size="xl" :title="'Contact Details of ' + item.name" hide-header-close ok-only v-model="contactDetails">
            <contactDetails :getInfo='item' :type="type"></contactDetails>
        </b-modal>

        <!-- Pastors & Staffs  -->
        <b-modal size="xl" :title="'Pastors & Staffs of ' + item.name" hide-header-close ok-only v-model="pastorStaff">
            <pastorsStaff :getInfo='item' :type="type"></pastorsStaff>
        </b-modal>

    </div>
    
</template>

<script>

import viewInfo from '../components/modals/viewInfo'
import serviceSchedule from '../components/modals/service_schedules'
import contactDetails from '../components/modals/contact_details'
import pastorsStaff from '../components/modals/pastors_staffs'

export default {
    name: 'Card',

    components: {
        viewInfo,
        serviceSchedule,
        contactDetails,
        pastorsStaff
    },

    props: ['result', 'searchtype'],

    data() {
        return {
            item: this.result,
            type: this.searchtype,
            pastors_staffs: this.result.pastors_staffs,

            infoModal: false,
            servicesModal: false,
            contactDetails: false,
            pastorStaff: false
        }
    }

}
</script>

<style scoped>
    .nccs_icon {
        position: absolute;
        margin-left: 10px;
    }

    .subtitle {
        font-style: italic;
        font-size: 12px;
    }

    .green_wrapper {
        padding-top: 4px;
        padding-bottom: 3px;
        padding-inline: 12px;
        display: -webkit-inline-box;
        border: 1px solid #bbb;
        margin-block: 10px;
        background: #ddd;
        font-size: 13px;
        border-radius: 5px 5px;
    }
    
    /* .item {
        padding: 10px;
        width: 307px;
        margin: 10px;
        color: #fff;
        background: #555;
        border: 1px solid #dfdfdf;
    } */

    .item {
        /* Add shadows to create the "card" effect */
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        transition: 0.3s;
        margin: 10px;
        width: 300px;
        height: 450px;
    }

    .item-img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        object-position: center;
    }

    /* On mouse-over, add a deeper shadow */
    .item:hover {
        box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    }

    /* Add some padding inside the card container */
    .item .container {
        padding: 26px;
        border-top: 1px solid #ddd;
    }

    .item .container h1 {
        font-size: 20px;
        font-weight: bolder;
    }

</style>