<template>
    <div>
        <b-container>
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