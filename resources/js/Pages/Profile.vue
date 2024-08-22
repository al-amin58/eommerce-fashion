<template>

    <Head title="Profile" />
    <Layout>
        <div class="col-md-7 mx-auto">
            <div class="card">
                <div class="card-body py-2 my-25">
                    <div class="text-center">
                        <div class="d-flex align-items-center flex-column">
                            <input type="file" accept="image/*" id="imageInput" @change="uploadImage" class="d-none">
                            <div class="avatar cursor-pointer">
                                <label for="imageInput">
                                    <img class="cursor-pointer" v-if="profileImage !== null" :src="profileImage" width="100" height="100"  alt="">
                                    <img class="cursor-pointer" v-else :src="$page.props.auth.user.avatar" width="100" height="100" alt="">
                                </label>
                            </div>
                            <button class="btn btn-primary btn-sm my-1" v-if="profileImage !== null" @click="updateProfileImage">upload</button>
                        </div>



                        <h2>{{ $page.props.auth.user.name }}</h2>
                        <small>{{ $page.props.auth.user.email }}</small>
                        <p>{{ $page.props.auth.user.phone }}</p>
                    </div>

                    <div class="row">
                        <div class="card shadow-sm col-md-6">
                            <div class="card-body">
                                <form @submit.prevent="updateCustomerProfile">
                                    <div>
                                        <label>Name</label>
                                        <input class="form-control" type="text" v-model="formData.name" placeholder="e.g jhon doh">
                                    </div>
                                    <div>
                                        <label>Email</label>
                                        <input class="form-control" type="text" v-model="formData.email" placeholder="e.g jhon.doh@ctpbd.com">
                                    </div>
                                    <div>
                                        <label>Phone</label>
                                        <input class="form-control" type="text" v-model="formData.phone" placeholder="e.g +8801*** - ********">
                                    </div>
                                    <button type="submit" :disabled="isLoading" class="btn btn-sm btn-primary mt-1">Update Profile</button>
                                </form>
                            </div>
                        </div>


                        <div class="card shadow-sm col-md-6">
                            <div class="card-body">
                                <form @submit.prevent="updateCustomerPassword">
                                    <div>
                                        <label>Current Password</label>
                                        <input class="form-control" type="password" v-model="authData.current" placeholder="This Password I'm Use Now">
                                    </div>
                                    <div>
                                        <label>New Password</label>
                                        <input class="form-control" type="password" v-model="authData.new" placeholder="This Is My New Password">
                                    </div>
                                    <div>
                                        <label>Confirmed Password</label>
                                        <input class="form-control" type="password" v-model="authData.confirmed"  placeholder="I'm Confirmed. It's Current  Password">
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-primary mt-1">Update Password</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import { useForm } from '@inertiajs/inertia-vue3'
import { ref } from 'vue'
import Layout from "../Shared/Layout.vue";
import {Inertia} from "@inertiajs/inertia";


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
    formData.post('/panel/update-admin-profile', {
        preserveState: true,
        replace: true,
        onStart: res => {
            isLoading.value = true;
        },
        onSuccess: page => {
            isLoading.value = false;
            formData.reset();
            $sToast.fire({
                icon: 'success',
                title: 'Updated successfully done...'
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
    authData.post('/panel/update-admin-credentials', {
        preserveState: true, replace: true,
        onStart: res => passIsLoad.value = true,
        onSuccess: page => {
            passIsLoad.value = false;
            formData.reset();
        },
        onError: errors => $toast.error(errors)
    })
}
const profileImage = ref(null);
const uploadImageData = ref(null);
const uploadImage = (event) =>{
    profileImage.value=URL.createObjectURL(event.target.files[0])
    uploadImageData.value = event.target.files[0];
}
const updateProfileImage = () =>{
    Inertia.post('/panel/update-profile-image', {image:uploadImageData.value},{
        preserveState: true,
        replace: true,
        onSuccess: page => {
            uploadImageData.value = {};
            $sToast.fire({
                icon: 'success',
                title: 'Signed in successfully'
            })
        },
        onError: errors => {
            $toast.error("Server Error 500")
        }
    })
}
</script>
