<template>
    <form @submit.prevent="submitForm" class="p-3">
        <div class="mb-3">
            <label for="dealName" class="form-label">Deal Name:</label>
            <input id="dealName" v-model="form.dealName" type="text" class="form-control" required
                   :class="{'is-invalid': ( v$.form.dealName.required.$invalid ), 'is-valid': ( !v$.form.dealName.required.$invalid ) }"
                   @click="v$.form.dealName.$touch()"
            >
            <span class="text-danger" v-for="error in v$.form.dealName.$errors"
                  :key="error.$uid">
                        {{ error.$message}}
                    </span>
        </div>
        <div class="mb-3">
            <label for="dealStage" class="form-label">Deal Stage:</label>
            <input id="dealStage" v-model="form.dealStage" type="text" class="form-control" required
                   :class="{'is-invalid': ( v$.form.dealStage.required.$invalid ), 'is-valid': ( !v$.form.dealStage.required.$invalid ) }"
                   @click="v$.form.dealStage.$touch()"
            >
            <span class="text-danger" v-for="error in v$.form.dealStage.$errors"
                  :key="error.$uid">
                        {{ error.$message}}
                    </span>
        </div>
        <div class="mb-3">
            <label for="accountName" class="form-label">Account Name:</label>
            <input id="accountName" v-model="form.accountName" type="text" class="form-control" required
                   :class="{'is-invalid': ( v$.form.accountName.required.$invalid ), 'is-valid': ( !v$.form.accountName.required.$invalid ) }"
                   @click="v$.form.accountName.$touch()"
            >
            <span class="text-danger" v-for="error in v$.form.accountName.$errors"
                  :key="error.$uid">
                        {{ error.$message}}
                    </span>
        </div>
        <div class="mb-3">
            <label for="accountWebsite" class="form-label">Account Website:</label>
            <input id="accountWebsite" v-model="form.accountWebsite" type="text" class="form-control" required
                   :class="{'is-invalid': ( v$.form.accountWebsite.required.$invalid ), 'is-valid': ( !v$.form.accountWebsite.required.$invalid ) }"
                   @click="v$.form.accountWebsite.$touch()"
            >
            <span class="text-danger" v-for="error in v$.form.accountWebsite.$errors"
                  :key="error.$uid">
                        {{ error.$message}}
                    </span>
        </div>
        <div class="mb-3">
            <label for="accountPhone"  class="form-label">Account Phone:</label>
            <input id="accountPhone" v-model="form.accountPhone" type="number" class="form-control"  required
                   :class="{'is-invalid': ( v$.form.accountPhone.required.$invalid ), 'is-valid': ( !v$.form.accountPhone.required.$invalid ) }"
                   @click="v$.form.accountPhone.$touch()"
            >
            <span class="text-danger" v-for="error in v$.form.accountPhone.$errors"
                  :key="error.$uid">
                        {{ error.$message}}
                    </span>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <div v-if="responseMessage" class="mt-3">
        <h2>Response:</h2>
        <p>{{ responseMessage }}</p>
    </div>
    <div v-if="responseAccount" class="mt-3">
        <h2>responseAccount:</h2>
        <p>"id" : {{ responseAccount[0]?.id }}</p>
        <p>"Account_Name" : {{ responseAccount[0]?.Account_Name }}</p>
        <p>"Phone" :  {{ responseAccount[0]?.Phone }}</p>
        <p>"Website" :  {{ responseAccount[0]?.Website }}</p>
    </div>
    <div v-if="responseDeal" class="mt-3">
        <h2>responseDeal:</h2>
        <p>"id" : {{ responseDeal[0]?.id }}</p>
        <p>"Deal_Name" : {{ responseDeal[0]?.Deal_Name }}</p>
        <p>"Stage" :  {{ responseDeal[0]?.Stage }}</p>
    </div>

</template>

<script>
    import useVuelidate from '@vuelidate/core';
    import {required, minLength, maxLength, minValue, maxValue, integer, between, decimal} from '@vuelidate/validators';
    import {useToast} from "vue-toastification";
    export default {
        name: "zohoForm",
        components: {
        },
        setup() {
            return {
                v$: useVuelidate(),
            }
        },
        validations() {
            return {
                form: {
                    dealName: {
                        required,
                        minLength: minLength(3)
                    },
                    dealStage: {
                        required,
                        minLength: minLength(3)
                    },
                    accountName: {
                        required,
                        minLength: minLength(3)
                    },
                    accountWebsite: {
                        required,
                        minLength: minLength(3)
                    },
                    accountPhone: {
                        required,
                        minLength: minLength(10)
                    },

                },

            }
        },
        data() {
            return {
                toast: useToast(),
                form: {
                    dealName: '',
                    dealStage: '',
                    accountName: '',
                    accountWebsite: '',
                    accountPhone: ''
                },
                responseMessage: '',
                responseAccount: '',
                responseDeal: '',
            }
        },

        methods: {
            async submitForm() {
                this.v$.$touch()
                if (this.v$.$error) {
                    let errorsstring = ''
                    for (var key in this.v$.$errors) {
                        errorsstring += "Поле: " + this.v$.$errors[key].$property + " - " + this.v$.$errors[key].$message + "\n"
                    }
                   //  alert(this.v$.$error);
                    this.toast.error("Ooops," + errorsstring + "")
                    return false
                }
                try {
                    const response = await axios.post('/api/zoho', this.form);
                    this.toast.success("succes! " + response.data.message)
                    this.responseMessage = response.data.message;
                    this.responseAccount = response.data.accountData?.data;
                    this.responseDeal = response.data.dealData?.data;

                } catch (error) {
                    this.responseMessage = error.response.data.message;
                    console.log('error.response', error.response.data);
                    let errorsstring = ''
                    errorsstring += error.response.data.message
                    this.toast.error("Ooops, Errors" + errorsstring + "")
                    return false
                }
            }
        }
    }
</script>
