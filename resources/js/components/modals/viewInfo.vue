<template>
    <div>
        <b-container>
            <b-row class="mb-4">
                <b-col>
                    <h5 class="mb-0">{{ item.name }} 
                        <span class="cn_text text-muted">{{ item.name_chi ? '('+item.name_chi+')' : '' }}</span>
                    </h5>
                    <p>CH Registration #: {{ item.chreg ? item.chreg : 'NONE' }}</p>
                    <p class="align-left bg-primary text-white p-1">{{ type==='church' ? 'Denomination:' : 'Category:' }} {{ item.church_denom }}</p>
                </b-col>
            </b-row>
            <b-row class="mb-2">
                <b-col>
                    <b-card>
                        <b-card-text>
                            <p><BIconPen></BIconPen> Primary Address</p>
                            <h6>
                                {{ item.bldg_name ? item.bldg_name + ', ' : ''}}
                                {{ item.address ? item.address + ', ' : ''}}
                                {{ item.city }}
                                {{ item.postcode }}
                            </h6>
                        </b-card-text>
                    </b-card>
                </b-col>
            </b-row>
            <b-row class="mb-2">
                <b-col>
                    <b-card>
                        <b-card-text>
                            <p><BIconPen></BIconPen> Mailing Address</p>
                            <h6>
                                {{ item.mbldg_name ? item.mbldg_name + ', ' : ''}}
                                {{ item.maddress ? item.maddress + ', ' : ''}}
                                {{ item.mcity }}
                                {{ item.mpostcode }}
                            </h6>
                        </b-card-text>
                    </b-card>
                </b-col>
            </b-row>
            <b-row class="mb-2">
                <b-col v-if="item.mission || item.mission_chi">
                    <b-card>
                        <b-card-text>
                            <p>Mission</p>
                            <h6>{{ item.mission }}</h6>
                        </b-card-text>
                    </b-card>
                </b-col>
                <b-col v-if="item.vision || item.vision_chi">
                    <b-card>
                        <b-card-text>
                            <p>Vision</p>
                            <h6>{{ item.vision }}</h6>
                        </b-card-text>
                    </b-card>
                </b-col>
            </b-row>

            <b-row class="mt-4">
                <b-col>
                    <p>Additional information</p>
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