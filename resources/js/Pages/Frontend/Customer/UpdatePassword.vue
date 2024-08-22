<template>
    <CustomerLayout>
        <div class="d-flex align-items-center gap-1">
            <a href="/dashboard">
                <vue-feather class="text-black" type="arrow-left"/>
            </a>
            <h1 class="text-black fw-semibold">Update Password</h1>
        </div>
        <div class="card shadow-sm col-md-6">
            <div class="card-body">
                <form @submit.prevent="updateCustomerPassword">
                    <div>
                        <label>Current Password</label>
                        <input class="form-control" type="password" v-model="authData.current" placeholder="This Password I'm Use Now">
                    </div>
                    <div class="mt-1">
                        <label>New Password</label>
                        <input class="form-control" type="password" v-model="authData.new" placeholder="This Is My New Password">
                    </div>
                    <div class="mt-1">
                        <label>Confirmed Password</label>
                        <input class="form-control" type="password" v-model="authData.confirmed"  placeholder="I'm Confirmed. It's Current  Password">
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary mt-1">Update Password</button>
                </form>
            </div>
        </div>
    </CustomerLayout>
</template>
<script setup>
import CustomerLayout from "./Layout.vue";

import {useForm} from "@inertiajs/inertia-vue3";
import {ref, onMounted} from "vue";
import CLayout from "./CLayout.vue";
import {usePage} from "@inertiajs/vue3";
import {useDataStore} from "../../../Store/useDataStore";
import axios from "axios";

const useCustomerData = useDataStore()

const customerData = ref(null)


const formData = useForm({
    name:null,
    email:null,
    phone:null,
})

const authData = useForm({
    current:null,
    new:null,
    confirmed:null,
})
const isLoading = ref(false)
const updateCustomerProfile = () => {
    formData.post('/update-user-profile', {
        preserveState: true,
        replace: true,
        onStart: res => {
            isLoading.value = true;
        },
        onSuccess: page => {
            isLoading.value = false;
            // formData.reset();
            $sToast.fire({
                icon: 'success',
                title: "update successfully done...",
            })
        },
        onError: errors => {
            document.getElementById('actionModal').$vb.modal.hide()
            isLoading.value = false;
            $toast.error("Validation Errors...")
        }
    })
}
const passIsLoad = ref(false);
const updateCustomerPassword = () =>{
    authData.post('/update-user-credentials', {
        preserveState: true, replace: true,
        onStart: res => passIsLoad.value = true,
        onSuccess: page => {
            passIsLoad.value = false;
            formData.reset();
            $sToast.fire({
                icon: 'success',
                title: "update successfully done...",
            })
        },
        onError: errors => $toast.error(errors)
    })
}
const editUserData = () =>{
    axios.get('/get-user-date').then((res) =>{
        console.log(res.data.name);
        customerData.value = true;
        formData.name = res.data.name
        formData.email = res.data.email
        formData.phone = res.data.phone
    })
}
onMounted(()=>{
    useCustomerData.setAuthData()

    console.log(useCustomerData.getAuthData)
    formData.name = useCustomerData.getAuthData.name
})

</script>
