<script setup>
import {ref} from 'vue'
import Layout from "../Shared/Layout.vue";
import {useForm} from "@inertiajs/inertia-vue3";

const props = defineProps({
    login_url:null,
    reg_url: null,
    errors:Object|null,
})


const changeViewRef = ref(true);
const changeForm = (status) =>{
    changeViewRef.value = status;
    console.log("call here")
}

const isLoading = ref(false);
const regFormData = useForm({
    username:null,
    email:null,
    phone:null,
    password:null,
    remember:null,
});
const loginFormData = useForm({
    email:null,
    password:null,
    remember:null,
});




const validUser = (type) =>{
    if (type === 'login') {
        loginFormData.post(props.login_url, {
            preserveState: true,
            replace: true,
            onStart: res => {
                console.log("res " + res)
                isLoading.value = true;
            },
            onSuccess: page => {
                // isLoading.value = false;
                // loginFormData.reset();
                // $sToast.fire({
                //     icon: 'success',
                //     title: 'Signed in successfully'
                // })
                console.log(page);
            },
            onError: errors => {
                console.log(errors)
                isLoading.value = false;
                $toast.error(errors.message ?? "Have an error. try again")
            }
        });
    }
}



const createUser = (type) =>{
    regFormData.post(props.reg_url, {
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
                                        <form @submit.prevent="validUser('login')" class="row g-1" v-if="changeViewRef">
                                            <span class="text-danger" v-for="(value, key) in props.errors">{{ value }} </span>

                                            <h2 class="bg-white p-1 p-lg-2 border-start-primary border-start-3" style="border-left-width: 5px !important;">Login Here...</h2>
                                            <div class="col-12">
                                                <label>Email<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        <vue-feather type="mail"/>
                                                    </div>
                                                    <input type="email" v-model="loginFormData.email" class="form-control" placeholder="Enter Email Address">
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <label>Password<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        <vue-feather type="lock"/>
                                                    </div>
                                                    <input type="password" class="form-control" v-model="loginFormData.password" placeholder="Enter Password">
                                                </div>
                                            </div>
<!--                                            <div class="col-sm-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" v-model="loginFormData.remember" type="checkbox" id="login">
                                                    <label class="form-check-label" for="login">Remember me</label>
                                                </div>
                                            </div>-->

                                            <div class="col-sm-6">
                                                Don't Have Account?
                                                <strong @click="changeForm(false)" class="text-primary cursor-pointer">Click Here</strong>
                                            </div>
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary px-4 float-end mt-4" :disabled="isLoading">login</button>
                                            </div>
                                        </form>
                                        <form @submit.prevent="createUser" class="row g-1" v-if="!changeViewRef">

                                            <span class="text-danger" v-for="(value, key) in props.errors">{{ value }} </span>

                                            <h2 class="bg-white p-1 p-lg-2 border-start-primary border-start-3" style="border-left-width: 5px !important;">Register Here...</h2>
                                            <div class="col-12">
                                                <label>Username<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        <vue-feather type="user"/>
                                                    </div>
                                                    <input type="text" v-model="regFormData.username" class="form-control" placeholder="Enter Username">
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <label>Email<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        <vue-feather type="mail"/>
                                                    </div>
                                                    <input type="email" v-model="regFormData.email" class="form-control" placeholder="Enter Email">
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <label>Phone Number<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        <vue-feather type="phone"/>
                                                    </div>
                                                    <input type="number" v-model="regFormData.phone" class="form-control" placeholder="Enter Phone Number">
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <label>Password<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        <vue-feather type="lock"/>
                                                    </div>
                                                    <input type="password" class="form-control" v-model="regFormData.password" placeholder="Enter Password">
                                                </div>
                                            </div>

<!--
                                            <div class="col-sm-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" v-model="regFormData.remember" id="inlineFormCheck">
                                                    <label class="form-check-label" for="inlineFormCheck">Remember me</label>
                                                </div>
                                            </div>
-->

                                            <div class="col-sm-6">
                                                Already Have An Account?
                                                <strong @click="changeForm(true)" class="text-primary cursor-pointer">Click Here</strong>
                                            </div>
                                            <div class="col-12">
                                                <button :disabled="isLoading" type="submit" class="btn btn-primary px-4 float-end mt-4 d-flex align-items-center">
                                                    <span class="me-1">Register</span>
                                                    <vue-feather type="arrow-right" size="18"/>
                                                </button>
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
