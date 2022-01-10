<template>
    <div>
        <ul class="nav nav-pills">
            <li class="nav-item">
                <button 
                    :class="{ 'custom_active': menu_selector==1 }" 
                    @click="menu_selector=1"
                    class="rounded-0 border-top border-start border-end btn btn-default">
                    Additional Information
                </button>
            </li>
            <li class="nav-item">
                <button 
                    :class="{ 'custom_active': menu_selector==2 }" 
                    @click="menu_selector=2"
                    class="rounded-0 border-top border-start border-end btn btn-default">
                    Contact Details
                </button>
            </li>
            <li class="nav-item" v-if="recordtype == 'church'">
                <button 
                    :class="{ 'custom_active': menu_selector==3 }" 
                    @click="menu_selector=3"
                    class="rounded-0 border-top border-start border-end btn btn-default">
                    Service Schedules
                </button>
            </li>
            <li class="nav-item" v-if="recordtype == 'church'">
                <button 
                    :class="{ 'custom_active': menu_selector==4 }" 
                    @click="menu_selector=4"
                    class="rounded-0 border-top border-start border-end btn btn-default">
                    Pastors/Staffs
                </button>
            </li>
        </ul>

        <div class="row">
            <div class="col-md-12">
                <div class="p-3 border bg-light custom-wrapper">
                    <div v-if="menu_selector==1">
                        <h5>Additional Information</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-responsive bg-white mt-3">
                                <tbody>
                                    <tr>
                                        <td>NCCS Member</td>
                                        <td>{{ result.is_nccsmember == 1 ? 'YES' : 'NO'  }}</td>
                                    </tr>
                                    <tr>
                                        <td>CH Registration</td>
                                        <td>{{ result.chreg }}</td>
                                    </tr>
                                    <tr>
                                        <td>Date Founded</td>
                                        <td>{{ result.date_founded == null || result.date_founded == '' ? 'N/A' : result.date_founded }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total Members</td>
                                        <td>{{ result.totalMembership }}</td>
                                    </tr>
                                    <tr v-if="result.type=='church'">
                                        <td>Average Weekly Attendance</td>
                                        <td>{{ result.aveWeeklyAttendance }}</td>
                                    </tr>
                                    <tr v-if="result.type=='church'">
                                        <td># of Reverends</td>
                                        <td>{{ result.numberOfReverends }}</td>
                                    </tr>
                                    <tr v-if="result.type=='church'">
                                        <td># of Preachers</td>
                                        <td>{{ result.numberOfPreachers }}</td>
                                    </tr>
                                    <tr v-if="result.type=='church'">
                                        <td># of Missionaries</td>
                                        <td>{{ result.numberOfMissionaries }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div v-if="menu_selector==2">
                        <h5>Contact Details</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered bg-white mt-3">
                                <tbody>
                                    <tr v-for="contact in result.contacts_details" :key="contact.id">
                                        <td class="text-uppercase">{{ contact.ctype }}</td>
                                        <td>
                                            {{ contact.value }} 
                                            <i>{{ contact.extra1==null ? '' : '('+contact.extra1+')' }}</i>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div v-if="menu_selector==3">
                        <h5>Service Schedules</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered bg-white mt-3">
                                <thead>
                                    <tr>
                                        <th>Day</th>
                                        <th>Time</th>
                                        <th>Language</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="service in result.service_schedules" :key="service.id">
                                        <td>{{ service.scheduleDay }}</td>
                                        <td>{{ service.scheduleHour }}:{{ service.scheduleMinutes }} {{ service.amOrPm }}</td>
                                        <td>{{ service.language }}</td>
                                        <td>{{ service.type }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div v-if="menu_selector==4">
                        <h5>Pastors & Staffs</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered bg-white mt-3">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Contact</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="person in result.pastors_staffs" :key="person.id">
                                        <td>{{ person.title }} {{ person.first_name }} {{ person.family_name }} </td>
                                        <td>{{ person.position }}</td>
                                        <td>{{ person.phone }}</td>
                                        <td>{{ person.type }} <i>{{ person.status==1 ? '(Active)' : 'Inactive' }}</i></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    
    export default {
        props: ['record_id', 'recordtype'],
        data() {
            return {
                menu_selector: 0,
                additional_info: true,
                contact_details: false,
                service_schedule: false,
                pastors_staffs: false,
                result: []
            }
        },

        async created() {
            this.menu_selector = 1;
            await this.fetchRecord();
        },

        methods: {
            fetchRecord() {
                
                let data = {
                    id: this.record_id,
                    type: this.recordtype
                };

                axios.post('/api/fetchRecord', data)
                     .then((response) => {
                         this.result = response.data;
                     })
                     .catch((error) => {
                         console.log(error);
                     })

            }
        }
    }

</script>

<style scoped>
    .custom_active {
        background: #343a40;
        color:#fff;
    }

    .custom-wrapper {
        min-height: 250px;
    }
</style>