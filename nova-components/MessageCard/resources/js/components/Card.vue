<template>
    <card class="flex flex-col custom-messagebox-bg" v-if="totalPendingRecords > 0">
        <div class="px-4 py-4">
            <img v-if="loading" src="/images/spinner.gif" width="75" />
            <template v-else>
                <svg 
                    xmlns="http://www.w3.org/2000/svg" 
                    class="h-5 w-6 custom-msgbox-heading" 
                    fill="none" 
                    viewBox="0 0 24 20" 
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span class="text-l font-bold custom-msgbox-heading">Pending for Approval</span>
                <br />
                <br />
                <ul class="custom-list pl-4">
                    <li class="custom-list-item" v-if="pendingChurches > 0">
                        <a href="/admin/resources/churches?churches_page=1&churches_filter=W3siY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXERlbm9taW5hdGlvbiIsInZhbHVlIjoiIn0seyJjbGFzcyI6IkFwcFxcTm92YVxcRmlsdGVyc1xcQXBwcm92ZWQiLCJ2YWx1ZSI6IjAifSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxQdWJsaXNoZWQiLCJ2YWx1ZSI6IiJ9LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXFNlYXJjaGFibGUiLCJ2YWx1ZSI6IiJ9XQ%3D%3D">
                            <strong>{{ pendingChurches }}</strong> {{ pendingChurches > 1 ? 'churches' : 'church' }} pending for approval
                        </a>
                    </li>
                    <li class="custom-list-item" v-if="pendingOrgs > 0">
                        <a href="/admin/resources/organizations?organizations_page=1&organizations_filter=W3siY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXERlbm9taW5hdGlvbiIsInZhbHVlIjoiIn0seyJjbGFzcyI6IkFwcFxcTm92YVxcRmlsdGVyc1xcQXBwcm92ZWQiLCJ2YWx1ZSI6IjAifSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxQdWJsaXNoZWQiLCJ2YWx1ZSI6IiJ9LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXFNlYXJjaGFibGUiLCJ2YWx1ZSI6IiJ9XQ%3D%3D">
                            <strong>{{ pendingOrgs }}</strong> {{ pendingOrgs > 1 ? 'organisations' : 'organisation' }} pending for approval
                        </a>
                    </li>
                    <li class="custom-list-item" v-if="pendingUsers > 0">
                        <a href="/admin/resources/users?users_page=1&users_filter=W3siY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXEFwcHJvdmVkIiwidmFsdWUiOiIwIn1d">
                        <strong>{{ pendingUsers }}</strong> {{ pendingUsers > 1 ? 'user registrations' : 'user registration' }} pending for approval
                        </a>
                    </li>
                </ul>
            </template>
           
        </div>
    </card>
</template>

<script>
export default {
    props: [
        'card',

        // The following props are only available on resource detail cards...
        // 'resource',
        // 'resourceId',
        // 'resourceName',
    ],

    data() {
        return {
            loading: false,
            pendingChurches: 0,
            pendingOrgs: 0,
            pendingUsers: 0,
            totalPendingRecords: 0
        }

    },

    mounted() {

        this.loading = true;

        setTimeout(() => {
            
           axios.post('/nova-vendor/'+this.card.component+'/checkPendingRecords')
                .then((response) => {
                    
                    this.totalPendingRecords = response.data.total;
                    this.pendingChurches= response.data.totalChurches;
                    this.pendingOrgs    = response.data.totalOrgs;
                    this.pendingUsers   = response.data.totalUsers;

                    this.loading = false;
                })
                .catch((error) => {
                    alert(error);
                });

        }, 2000);

       

    },
}
</script>

<style scoped>
    .custom-messagebox-bg {
        background: #e9a5a5;
        border: 1px solid #b74343;
        height: inherit !important;
    }
    .custom-msgbox-heading {
        color: #993d3d;
        font-size: 20px;
    }
    .custom-list {
        list-style: none;
    }
    .custom-list li {
        margin-bottom: 10px;
    }
    .custom-list li a {
        color: #543131;
        text-decoration: none;
        font-size: 18px;
    }
    .custom-list li a:hover {
        color: #763636;
        font-weight: bold;
    }
</style>