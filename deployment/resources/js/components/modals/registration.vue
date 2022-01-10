<template>
    <b-container fluid>
        <b-row class="my-3">
            <b-col sm="3">
                <label for="input-firstname">First Name:</label>
            </b-col>
            <b-col sm="9">
                <b-form-input id="input-firstname" v-model="user.first_name" type="text" :state="null" placeholder="First Name"></b-form-input>
            </b-col>
        </b-row>

        <b-row class="my-3">
            <b-col sm="3">
                <label for="input-lastname">Last Name:</label>
            </b-col>
            <b-col sm="9">
                <b-form-input id="input-lastname" v-model="user.last_name" type="text" :state="null" placeholder="Last Name"></b-form-input>
            </b-col>
        </b-row>

        <b-row class="my-3">
            <b-col sm="3">
                <label for="input-phone">Contact Number:</label>
            </b-col>
            <b-col sm="9">
                <b-form-input id="input-phone" v-model="user.phone" type="text" :state="null" placeholder="Phone Number"></b-form-input>
            </b-col>
        </b-row>

        <b-row class="my-3">
            <b-col sm="12">
                <hr />
            </b-col>
        </b-row>

        <b-row class="my-3">
            <b-col sm="3">
                <label for="input-email">Email Address:</label>
            </b-col>
            <b-col sm="9">
                <b-form-input id="input-email" v-model="user.email" type="email" :state="null" placeholder="Valid Email Address"></b-form-input>
            </b-col>
        </b-row>

        <b-row class="my-3">
            <b-col sm="3">
                <label for="input-password">Password:</label>
            </b-col>
            <b-col sm="9">
                <b-form-input id="input-password" v-model="user.password" type="password" :state="null" placeholder="Password"></b-form-input>
            </b-col>
        </b-row>
        <b-row class="my-3">
            <b-col sm="3">
                <label for="input-conf_pass">Confirm Password:</label>
            </b-col>
            <b-col sm="9">
                <b-form-input id="input-conf_pass" v-model="user.conf_pass" type="password" :state="null" placeholder="Confirm Password"></b-form-input>
            </b-col>
        </b-row>

        <b-row class="mt-2 mb-4">
            <b-col sm="3">
            </b-col>
            <b-col sm="9">
                <b-button class="mt-3" variant="success" size="lg" block @click.prevent="submitRegistration()">REGISTER</b-button>
            </b-col>
        </b-row>

       
    </b-container>
</template>

<script>
export default {

    data() {
        return {
            user: {
                first_name: null,
                last_name: null,
                phone: null,
                email:null,
                password:null,
                conf_pass: null,
            }
        }
    },

    methods: {

        submitRegistration() {

            console.log(this.user);
        }

    }

}
</script>

<style>

</style>