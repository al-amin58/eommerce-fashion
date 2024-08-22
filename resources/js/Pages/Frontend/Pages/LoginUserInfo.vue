<template>
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

    <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <a href="/" class="nav-link" >Home</a>
        <a href="/customer/profile" class="nav-link">Profile</a>
        <a href="/customer/orders" class="nav-link" >Orders</a>
        <a :href="$page.props.auth.MAIN_URL+'/logout'" class="nav-link">Logout</a>
    </div>

</template>
<script setup>

import {ref} from "vue";
import {Inertia} from "@inertiajs/inertia";

const profileImage = ref(null);
const uploadImageData = ref(null);
const uploadImage = (event) =>{
    profileImage.value=URL.createObjectURL(event.target.files[0])
    uploadImageData.value = event.target.files[0];
}
const updateProfileImage = () =>{
    Inertia.post('/update-profile-image', {image:uploadImageData.value},{
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
