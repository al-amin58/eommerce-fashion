<template>

    <form @submit.prevent="validUser" class="row g-1 shadow-lg mt-2 p-1">
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

        <div class="col-sm-6">
            <div class="form-check">
                <input class="form-check-input" v-model="loginFormData.remember" type="checkbox" id="login">
                <label class="form-check-label" for="login">Remember me</label>
            </div>
        </div>

        <div class="col-sm-6">
            Don't Have Account?
            <a href="/customer/login" class="text-primary cursor-pointer">Click Here</a>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary px-4 float-end mt-4" :disabled="isLoading">login</button>
        </div>
    </form>
</template>

<script setup>
import {ref} from 'vue'
import {useForm} from "@inertiajs/inertia-vue3";
const props = defineProps({
    errors:Object,
})
const loginFormData = useForm({
    email:null,
    password:null,
    remember:null,
});

const isLoading = ref(false)

const validUser = () =>{
    loginFormData.post('/login', {
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
