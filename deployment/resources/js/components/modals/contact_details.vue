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
                    <b-table striped hover :items="contacts" :fields="fields">
                        <template #cell(value)="data">
                            <template v-if="data.item.ctype === 'Website' || data.item.ctype === 'website'">
                                <a :href="data.item.value" target="_blank">{{ data.item.value }}</a>
                            </template>
                            <template v-else>{{ data.item.value }}</template>
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
            contacts: this.getInfo.contacts_details,
            fields: [
                {
                    key: 'ctype',
                    label: 'Type'
                },
                {
                    key: 'value',
                    label: 'Detail'
                },
                {
                    key: 'extra1',
                    label: 'Added Details'
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