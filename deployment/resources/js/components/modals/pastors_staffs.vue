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
                    <b-table bordered hover :items="pastorsStaffs" :fields="fields" :sort-by.sync="sortBy" :sort-desc.sync="sortDesc">
                        <template #cell(name)="data">
                            {{ data.item.title }} {{ data.item.first_name }} {{ data.item.family_name }} <br />
                            <small v-if="data.item.title_chi || data.item.given_name_chi || data.item.family_name_chi">
                                ( {{ data.item.title_chi }} {{ data.item.given_name_chi }} {{ data.item.family_name_chi }} )
                            </small>
                        </template>
                        <template #cell(position)="data">
                            {{ data.item.position }} {{ data.item.position_chi ? '(' + data.item.position_chi + ')' : '' }}
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
            pastorsStaffs: this.getInfo.pastors_staffs,
            fields: [
                {
                    key: 'name',
                    label: 'Name'
                },
                {
                    key: 'position',
                    label: 'Position'
                },
                {
                    key: 'phone',
                    label: 'Contact #'
                },
                {
                    key: 'type',
                    label: 'Type',
                    sortable: true
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