<template>
    <div>
        <b-container>
            <b-row class="mb-4">
                <b-col>
                    <h2 class="mb-0">{{ item.name }} 
                        <span class="cn_text text-muted">{{ item.name_chi ? '('+item.name_chi+')' : '' }}</span>
                        <img v-if="item.is_nccsmember" src="/images/nccs_member_label.png" width="30px" class="nccs_icon" /></h2>
                </b-col>
            </b-row>
            <b-row>
                <b-col>
                    <b-table striped hover :items="services" :fields="fields">
                        <template #cell(time)="data">
                            {{ data.item.scheduleDay }} @ {{ data.item.scheduleHour }} :{{ data.item.scheduleMinutes }} {{ data.item.amOrPm }}
                        </template>
                    </b-table>
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
            item: this.getInfo,
            services: this.getInfo.service_schedules,
            fields: [
                {
                    key: 'type',
                    label: 'Type'
                },
                {
                    key: 'language',
                    label: 'Language'
                },
                {
                    key: 'time',
                    label: 'Schedule'
                }
            ]
        }
    }

}
</script>
<style scoped>
    .cn_text {
        font-style: italic;
    }
</style>