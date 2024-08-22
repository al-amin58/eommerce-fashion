<template>
    <CustomerLayout>

        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-1">
                <a href="/dashboard">
                    <vue-feather class="text-black" type="arrow-left"/>
                </a>
                <h1 class="text-black fw-semibold">Address Book</h1>
            </div>
            <button v-if="props.addresses.length < 5" class="btn btn-primary mt-2" @click="addNewAddress">
                Add New Address
            </button>
        </div>

        <div class="row mt-5">
            <div class="col-md-6" v-for="item in props.addresses" v-if="props.addresses">
                <div class="card page-shadow">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h2>{{ item?.title }}</h2>
                            <!--                        <sapn class="badge bg-primary">Primary</sapn>-->
                        </div>
                        <p>{{ item?.address }}</p>
                        <p class="mb-0">{{ item?.email }}</p>
                        <p>{{ item?.phone }}</p>
                        <p>Area: {{ item?.order_area?.area_name }} & Delivery Charge: {{ item?.order_area?.delivery_charge }}</p>
                        <div class="btn-group dropstart float-end">
                            <button class="btn btn-icon float-end btn-sm btn-default border-1 border-primary rounded-circle text-primary"
                                    id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <vue-feather type="more-horizontal"/>
                            </button>
                            <div class="dropdown-menu p-0 dropstart" aria-labelledby="dropdownMenuButton">
                                <a href="#" class="dropdown-item d-flex align-items-center text-info w-100" @click="editItem(item)" type="button">
                                    <vue-feather type="edit" size="15"/>
                                    <span class="ms-1">Edit</span>
                                </a>
                                <button class="dropdown-item d-flex align-items-center text-danger w-100"
                                        type="button" @click="deleteItem(props.main_url, item?.id)">
                                    <vue-feather type="trash" size="15"/>
                                    <span class="ms-1">Delete</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </CustomerLayout>
<!--
    <div class="card-body">
        <h2>Update Profile Details</h2>
        <form @submit.prevent="updateCustomerProfile">
            <div>
                <label>Name</label>
                <input class="form-control" type="text" placeholder="e.g jhon doh">
            </div>
            <div class="mt-1">
                <label>Email</label>
                <input class="form-control" type="text" placeholder="e.g jhon.doh@ctpbd.com">
            </div>
            <div class="mt-1">
                <label>Phone</label>
                <input class="form-control" type="text" placeholder="e.g +8801*** - ********">
            </div>
            <button type="submit" class="btn btn-sm btn-primary mt-1">Update Profile</button>
        </form>
    </div>-->


    <!-- Modal to edit Item-->
    <Modal id="addItem" :title="isEditData ? 'Edit Address' : 'Add New Address'" v-vb-is:modal>
        <div class="modal-body">
            <form @submit.prevent="saveAddress">
                <div>
                    <label>Address Title</label>
                    <input type="text" class="form-control" v-model="formData.title" placeholder="e.g Home / Office address">
                    <span class="text-danger" v-if="props.errors.title">{{ props.errors.title }}</span>
                </div>
                <div class="mt-1">
                    <label>Select Area</label>
                    <vSelect :options="props.aries"
                             v-model="formData.area"
                             :reduce="item => item.id"
                             label="area_name" placeholder="e.g select area">
                        <template v-slot:option="option">
                            <li class="d-flex align-items-start py-1">
                                <div class="d-flex align-items-center justify-content-between w-100">
                                    <div class="me-1 d-flex flex-column">
                                        <h6 class="mb-25">{{ option.area_name }}</h6>
                                    </div>
                                </div>
                            </li>
                        </template>
                    </vSelect>
                    <span class="text-danger" v-if="props.errors.area">{{ props.errors.area }}</span>

                </div>
                <div class="mt-1">
                    <label>Email <span class="text-secondary">(optional)</span></label>
                    <input type="email" v-model="formData.email" placeholder="e.g shipping email." class="form-control">
                    <span class="text-danger" v-if="props.errors.email">{{ props.errors.email }}</span>
                </div>
                <div class="mt-1">
                    <label>Phone <span class="text-secondary">(optional)</span></label>
                    <input type="text" v-model="formData.phone" placeholder="e.g shipping phone number." class="form-control">
                    <span class="text-danger" v-if="props.errors.phone">{{ props.errors.phone }}</span>
                </div>
                <div class="mt-1">
                    <label>Full Address</label>
                    <textarea v-model="formData.address" class="form-control" placeholder="e.g full address"></textarea>
                    <span class="text-danger" v-if="props.errors.address">{{ props.errors.address }}</span>
                </div>
<!--                <div class="d-flex mt-1 align-items-start gap-1 flex-column">
                    <label>Make this address primary</label>
                    <div class="float-start">
                        <Switch v-model="formData.isPrimary"/>
                    </div>
                </div>-->

                <button type="submit" class="btn float-end btn-sm btn-primary mt-1">
                    {{ isEditData ? 'Update' : 'Save' }}
                </button>
                <button type="reset" class="btn float-end btn-sm  bg-danger mt-1 me-1 text-white" data-bs-dismiss="modal" aria-label="Close">
                    close
                </button>
            </form>
        </div>
    </Modal>

</template>

<script setup>
import CustomerLayout from "./Layout.vue";

import {useForm} from "@inertiajs/inertia-vue3";
import {ref, onMounted} from "vue";
import CLayout from "./CLayout.vue";
import {usePage} from "@inertiajs/vue3";
import {useDataStore} from "../../../Store/useDataStore";
import axios from "axios";
import Modal from "../../../components/Modal.vue";
import Switch from "../../../components/Switch.vue";
import {useAction} from "../../../Composables/useAction";

const {deleteItem} = useAction()
const props = defineProps({
    aries: null,
    addresses:null,
    main_url:null,
    errors:Object|null,
})

const isEditData = ref(false);
const addNewAddress = () => {
    isEditData.value = false;
    document.getElementById('addItem').$vb.modal.show()
}


const formData = useForm({
    title:null,
    area:null,
    email:null,
    phone:null,
    address:null,
    isPrimary:null,
    id:null,
})

const saveAddress = () => {
    if (!isEditData.value){
        formData.post(props.main_url,{
            preserveState: true,
            replace: true,
            onSuccess: page => {
                document.getElementById('addItem').$vb.modal.hide()
                formData.reset();
                $sToast.fire({
                    icon: 'success',
                    title: 'Address Created.'
                })
            },
            onError: errors => {
                $toast.error("Validation Errors...")
            }
        });
    }else{
        formData.put(`${props.main_url}/${formData.id}`,{
            preserveState: true,
            replace: true,
            onSuccess: page => {
                document.getElementById('addItem').$vb.modal.hide()
                formData.reset();
                isEditData.value = false;
                $sToast.fire({
                    icon: 'success',
                    title: 'Address Updated.'
                })
            },
            onError: errors => {
                $toast.error("Validation Errors...")
            }
        });
    }
}

const editItem = (item) =>{
    isEditData.value = true;
    formData.title = item.title
    formData.area = item.order_area_id
    formData.email = item.email
    formData.phone = item.phone
    formData.address = item.address
    formData.id = item.id,
    document.getElementById('addItem').$vb.modal.show()
}





</script>
<style scoped>
    .address-box{
        border-color: #e5e5e5 !important;
        box-shadow: 0px 3px 17px 0px #d9d7d7;
        border-radius: 15px;
    }
</style>
