<template>
    <div>
        <b-container>
            <b-row class="mb-4">
                <b-col>
                    <h2 class="mb-0">{{ item.name }} 
                        <span class="cn_text text-muted">{{ item.name_chi ? '('+item.name_chi+')' : '' }}</span>
                        <img v-if="item.is_nccsmember" src="/images/nccs_member_label.png" width="30px" class="nccs_icon" /></h2>
                    <h5>CH Registration #: {{ item.chreg ? item.chreg : 'NONE' }}</h5>
                    <p class="align-left bg-primary text-white p-1">{{ type==='church' ? 'Denomination:' : 'Category:' }} {{ item.church_denom }}</p>
                </b-col>
            </b-row>
            <b-row class="mb-2">
                <b-col>
                    <b-card>
                        <b-card-text>
                            <h6><BIconPen></BIconPen> Primary Address</h6>
                            <h5>
                                {{ item.bldg_name ? item.bldg_name + ', ' : ''}}
                                {{ item.address ? item.address + ', ' : ''}}
                                {{ item.city }}
                                {{ item.postcode }}
                            </h5>
                        </b-card-text>
                    </b-card>
                </b-col>
            </b-row>
            <b-row class="mb-2">
                <b-col>
                    <b-card>
                        <b-card-text>
                            <h6><BIconPen></BIconPen> Mailing Address</h6>
                            <h5>
                                {{ item.mbldg_name ? item.mbldg_name + ', ' : ''}}
                                {{ item.maddress ? item.maddress + ', ' : ''}}
                                {{ item.mcity }}
                                {{ item.mpostcode }}
                            </h5>
                        </b-card-text>
                    </b-card>
                </b-col>
            </b-row>
            <b-row class="mb-2">
                <b-col v-if="item.mission || item.mission_chi">
                    <b-card>
                        <b-card-text>
                            <h6>Mission</h6>
                            <h5>{{ item.mission }}</h5>
                        </b-card-text>
                    </b-card>
                </b-col>
                <b-col v-if="item.vision || item.vision_chi">
                    <b-card>
                        <b-card-text>
                            <h6>Vision</h6>
                            <h5>{{ item.vision }}</h5>
                        </b-card-text>
                    </b-card>
                </b-col>
            </b-row>

            <b-row class="mt-4">
                <b-col>
                    <h5>Additional information</h5>
                    <b-card>
                        <b-list-group flush>
                            <b-list-group-item>Date Founded: {{ item.date_founded ? item.date_founded : 'N/A' }}</b-list-group-item>
                            <b-list-group-item>Total Members: {{ item.totalMembership > 0  ? item.totalMembership : 0 }}</b-list-group-item>
                            <b-list-group-item>Average Weekly attendance: {{ item.aveWeeklyAttendance > 0 ? item.aveWeeklyAttendance : 0 }}</b-list-group-item>
                            <b-list-group-item>Number Of Reverends: {{ item.numberOfReverends > 0 ? item.numberOfReverends : 0 }}</b-list-group-item>
                            <b-list-group-item>Number Of Preachers: {{ item.numberOfPreachers > 0 ? item.numberOfPreachers : 0 }}</b-list-group-item>
                            <b-list-group-item>Number Of Missionaries: {{ item.numberOfMissionaries > 0 ? item.numberOfMissionaries : 0 }}</b-list-group-item>
                        </b-list-group>
                    </b-card>
                </b-col>
            </b-row>
        </b-container>
        
    </div>
</template>
<script>
import { BIconPen, BIconArrowDown } from 'bootstrap-vue'

export default {

    props: ['getInfo', 'type'],

    components: {
        BIconPen,
        BIconArrowDown
    },

    data() {
        return {
            item: this.getInfo
        }
    }

}
</script>
<style scoped>
    .cn_text {
        font-style: italic;
    }
</style>