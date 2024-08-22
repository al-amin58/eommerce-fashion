<template>
    <CustomerLayout>
        <div class="d-flex align-items-center gap-1">
            <a href="/dashboard">
                <vue-feather class="text-black" type="arrow-left"/>
            </a>
            <h1 class="text-black fw-semibold">Edit Profile</h1>
        </div>
        <div class="row sm-mt mt-5">
            <div class="card page-shadow col-md-6">
                <div class="card-body">
                    <form @submit.prevent="updateCustomerProfile" v-if="customerData">
                        <div>
                            <label>Name</label>
                            <input class="form-control" type="text" v-model="formData.name" placeholder="e.g jhon doh">
                        </div>
                        <div class="mt-1">
                            <label>Email</label>
                            <input class="form-control" type="text" v-model="formData.email" placeholder="e.g jhon.doh@ctpbd.com">
                        </div>
                        <div class="mt-1">
                            <label>Phone</label>
                            <input class="form-control" type="text" v-model="formData.phone" placeholder="e.g +8801*** - ********">
                        </div>
                        <button type="submit" :disabled="isLoading" class="btn btn-sm btn-primary mt-1">Update Profile</button>
                    </form>
                    <div v-else>
                        <div>
                            <label>Name</label>
                            <input type="text" class="form-control" disabled readonly :value="useCustomerData.getAuthData.name">
                        </div>
                        <div class="mt-1">
                            <label>Email</label>
                            <input type="text" class="form-control" disabled readonly :value="useCustomerData.getAuthData.email">
                        </div>
                        <div class="mt-1">
                            <label>Phone</label>
                            <input type="text" class="form-control" disabled readonly :value="useCustomerData.getAuthData.phone">
                        </div>
                        <button type="submit" @click="editUserData" class="btn btn-sm btn-primary mt-1">Edit Data</button>
                    </div>
                </div>
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
