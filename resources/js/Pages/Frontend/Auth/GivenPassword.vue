<script setup>
import {ref} from 'vue'
import Layout from "../Shared/Layout.vue";
import {useForm} from "@inertiajs/inertia-vue3";

const props = defineProps({
    login_url:null,
    reg_url: null,
    errors:Object|null,
})

const isLoading = ref(false);
const loginFormData = useForm({
    conform_pas:null,
    password:null,
});

const checkVerify = () =>{
    loginFormData.post('/set-password', {
        preserveState: true,
        replace: true,
        onStart: res => {
            console.log("res " + res)
            isLoading.value = true;
        },
        onSuccess: page => {
            isLoading.value = false;
            loginFormData.reset();
            $sToast.fire({
                icon: 'success',
                title: 'Signed in successfully'
            })
        },
        onError: errors => {
            console.log(errors)
            isLoading.value = false;
            $toast.error(errors.message ?? "Have an error. try again")
        }
    });
}


</script>

<template>
    <Layout>
        <div class="login-page">
            <div class="container-sm">
                <div class="row my-5">
                    <div class="col-lg-10 offset-lg-1 sm-mt-2 sm-p-0" >
                        <div class="bg-white shadow rounded">
                            <div class="row mt-5">
                                <div class="col-md-7 pe-0 mx-auto">
                                    <div class="form-left h-100 py-2 px-2 py-lg-5 px-lg-5">
                                        <form @submit.prevent="checkVerify" class="row g-1">
                                            <span class="text-danger" v-for="(value, key) in props.errors">{{ value }} </span>

                                            <h2 class="bg-white p-1 p-lg-2 border-start-primary border-start-3" style="border-left-width: 5px !important;">Set Password</h2>

                                            <div class="col-12">
                                                <label>Password<span class="text-danger">*</span></label>
                                                <input type="password" class="form-control"  @input="clearPass" v-model="loginFormData.password" placeholder="Enter Password">
                                            </div>

                                            <div class="col-12">
                                                <label>Conform password<span class="text-danger">*</span></label>
                                                <input type="password" class="form-control"  @input="clearPass"
                                                       v-model="loginFormData.conform_pas" placeholder="Enter Conform Password">
                                            </div>

                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary px-4 mt-4" :disabled="isLoading">Save Password</button>

                                                <a href="/dashboard" class="btn btn-default float-end">Skip</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<style scoped>

</style>
