<template>
    <b-container fluid>
        <form>
            <b-row v-if="isSuccessRegistration">
                <b-col sm="12">
                    <div class="alert alert-success pt-4 pb-2 pl-2">
                        <strong>Congratulation!</strong> Your account has been created successfully and it's pending for approval. 
                        You'll receive an update through phone number or email address once your application is approve.
                    </div>
                </b-col>
            </b-row>

            <b-row class="my-3">
                <b-col sm="3">
                    <label for="input-firstname">First Name:</label>
                </b-col>
                <b-col sm="9">
                    <b-form-input :class="{ 'border-danger': isHasError && errorHandler.firstname }" id="input-firstname" v-model="user.firstname" type="text" :state="null" placeholder="First Name"></b-form-input>
                    <small v-if="isHasError && errorHandler.firstname" class="text-danger fst-italic"><sub>First name must be empty</sub></small>
                </b-col>
            </b-row>

            <b-row class="my-3">
                <b-col sm="3">
                    <label for="input-lastname">Last Name:</label>
                </b-col>
                <b-col sm="9">
                    <b-form-input :class="{ 'border-danger': isHasError && errorHandler.lastname }" id="input-lastname" v-model="user.lastname" type="text" :state="null" placeholder="Last Name"></b-form-input>
                    <small v-if="isHasError && errorHandler.lastname" class="text-danger fst-italic"><sub>Last name must be empty</sub></small>
                </b-col>
            </b-row>

            <b-row class="my-3">
                <b-col sm="3">
                    <label for="input-phone">Contact Number:</label>
                </b-col>
                <b-col sm="9">
                    <b-form-input :class="{ 'border-danger': isHasError && errorHandler.phoneNum }" id="input-phone" v-model="user.phoneNum" type="text" :state="null" placeholder="Phone Number"></b-form-input>
                    <small v-if="isHasError && errorHandler.phoneNum" class="text-danger fst-italic"><sub>Phone number must be empty</sub></small>
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
                    <b-form-input :class="{ 'border-danger': isHasError && (emailExistErr || errorHandler.email) }" id="input-email" v-model="user.email" type="email" :state="null" placeholder="Valid Email Address"></b-form-input>
                    <small v-if="isHasError && errorHandler.email" class="text-danger fst-italic"><sub>Email address must be empty</sub></small>
                    <small v-if="isHasError && emailExistErr" class="text-danger pl-2"><sub>{{ errMsg }}</sub></small>
                </b-col>
            </b-row>

            <b-row class="my-3">
                <b-col sm="3">
                    <label for="input-password">Password:</label>
                </b-col>
                <b-col sm="9">
                    <b-form-input :class="{ 'border-danger': isHasError && errorHandler.password }" id="input-password" v-model="user.password" type="password" :state="null" placeholder="Password"></b-form-input>
                    <small v-if="isHasError && errorHandler.password" class="text-danger fst-italic"><sub>{{ errorHandler.password[0] }}</sub></small>
                </b-col>
            </b-row>
            <b-row class="my-3">
                <b-col sm="3">
                    <label for="input-conf_pass">Confirm Password:</label>
                </b-col>
                <b-col sm="9">
                    <b-form-input :class="{ 'border-danger': isHasError && errorHandler.confPassword }" id="input-conf_pass" v-model="user.confPassword" type="password" :state="null" placeholder="Confirm Password"></b-form-input>
                    <small v-if="isHasError && errorHandler.confPassword" class="text-danger fst-italic"><sub>{{ errorHandler.confPassword[0] }}</sub></small>
                </b-col>
            </b-row>

            <b-row>
                <b-col sm="9" offset="3">
                    <vue-recaptcha sitekey="6Lcpl5AdAAAAAIkO4TG4ZQoPQmgAyON874nG424b" 
                        @verify="onCaptchaVerified"
                        @expired="onCaptchaExpired"
                        ref="recaptcha">
                    </vue-recaptcha>
                </b-col>
            </b-row>

            <b-row class="mt-2 mb-4">
                <b-col sm="3">
                </b-col>
                <b-col sm="9">
                    <b-button :disabled="!validateCaptcha" class="mt-3" variant="success" size="md" block @click.prevent="submitRegistration()">REGISTER</b-button>
                </b-col>
            </b-row>

        </form>
    </b-container>
</template>

<script>
const axios = require('axios');
import { VueRecaptcha } from 'vue-recaptcha';

export default {

    components: { VueRecaptcha },

    data() {
        return {
            user: {
                firstname: null,
                lastname: null,
                phoneNum: null,
                email:null,
                password:null,
                confPassword: null,
            },
            errorHandler: [],
            emailExistErr: false,
            isHasError: false,
            isSuccessRegistration: false,
            validateCaptcha: false
        }
    },

    mounted(){
        this.validateCaptcha = false;
    },

    methods: {

        onCaptchaVerified(recaptchaToken) {
            this.validateCaptcha = true
        },

        onCaptchaExpired() {
            this.$refs.recaptcha.reset();
        },

        onEvent() {
            // when you need a reCAPTCHA challenge
            this.$refs.recaptcha.execute();
        },
        submitRegistration() {

            this.isHasError = false;
            this.errorHandler = [];
            this.emailExistErr = false;
            this.isSuccessRegistration = false;

            axios.post('/api/register', this.user)
                 .then((response) => {

                    if(response.data.emailExist) {
                        this.isHasError = true;
                        this.emailExistErr = true;
                        this.errMsg = 'Oops! Something is wrong. '+response.data.emailExist;
                        return;
                    }

                    if(response.data.errors) {
                        this.isHasError = true;
                        this.errorHandler = response.data.errors;
                        return;
                    }

                    this.isSuccessRegistration = response.data.success;
                    this.errorHandler = [];
                    this.user = [];

                 })
                 .catch((error) => {
                     console.log(error)
                 })

            // console.log(this.user);
        }

    }

}
</script>

<style>

</style>