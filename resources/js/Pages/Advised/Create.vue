<script setup>
import layout from "../../Shared/Layout.vue";
import {useForm} from "@inertiajs/inertia-vue3";
import debounce from "lodash/debounce";
import {computed, onMounted, ref, watch} from 'vue';
import OffcanvasCom from "../../components/Offcanvas.vue";
import {Inertia} from "@inertiajs/inertia";
import {useSlug} from '../../Composables/useSlug.js'
import {Tooltip} from 'bootstrap'
import ImageUploader from "../../components/ImageUploader.vue";
import Swal from "sweetalert2";
import axios from "axios";
import {Offcanvas} from 'bootstrap';
import Pagination from "../../components/Pagination.vue";
import {useAction} from '../../Composables/useAction.js';
import Switch from "../../components/Switch.vue";


const action = useAction();

const slugTitle = useSlug();

const props = defineProps({
    products:[] | null,
    parent_categories:[] | null,
    data:Object|null,
    selectedProduct:[]|null,
    main_url:String | null,
    errors:Object | null,
    filters: Object,
});


const formData = useForm({
    title:null,
    products:[],
    discount_type:null,
    discount_price:null,
    status:null,
    imageFile:null,
});



const prevImage = ref('../../../images/placeholder.avif');
const imageFile = ref(null);
const inputImage = (event) =>{
    prevImage.value = URL.createObjectURL(event.target.files[0])
    formData.imageFile = event.target.files[0];
}
const clearImage = () => prevImage.value = '../../../images/placeholder.avif';
const saveAds = () =>{
    formData.post('/panel/advised-post', {
        onSuccess: page =>{
            formData.reset();
            prevImage.value = '../../../images/placeholder.avif';
            $sToast.fire({
                icon: 'success',
                title: 'Ads Save successfully done...'
            })
        }
    })
}

const updateAds = () =>{
    formData.post(`/panel/advised-post/${props.data.id}`, {
        onSuccess: page =>{
            formData.reset();
            prevImage.value = '../../../images/placeholder.avif';
            $sToast.fire({
                icon: 'success',
                title: 'Ads Updated successfully done...'
            })
        }
    })
}

onMounted(()=>{
    formData.title = props.data?.title;
    formData.discount_type= props.data?.discount_type ?? null;
    formData.discount_price= props.data?.discount_price;
    formData.status= props.data?.status === 1;
    prevImage.value = props.data?.image ?? '../../../images/placeholder.avif';
    formData.products = props.selectedProduct
});


</script>

<template>
    <layout>
        <div class="row">
            <div class="col-md-6">
                <p v-if="props.errors.image" class="text-danger">{{props.errors.image }}</p>
                <div class="card">

                    <div class="card-body position-relative imgContainer">
                        <img :src="prevImage" class="w-100" alt="">
                        <button v-if="prevImage !== '../../../images/placeholder.avif'" @click="clearImage" style="position: absolute; right: 31px; top: 31px;">
                            <vue-feather type="x"/>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card d-flex align-items-center justify-content-center">
                    <label for="adsinput" class="card-body cursor-pointer">
                        <input type="file" @input="inputImage" class="d-none" id="adsinput">
                        <vue-feather type="camera"/>
                    </label>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Ads Product</h2>

                        <div class="">
                            <p class="text-danger" v-if="props.errors.title">{{props.errors.title }}</p>
                            <label>Ads Title</label>
                            <input type="text" v-model="formData.title" class="form-control" placeholder="e.g Ads Title">
                        </div>

                        <div class="mt-1">
                            <label>Products</label>
                            <vSelect :options="props.products"
                                     v-model="formData.products"
                                     :reduce="item => item.id"
                                     multiple
                                     label="title"
                                     placeholder="e.g Select Products For Ads">
                                <template v-slot:option="option">
                                    <li class="d-flex align-items-start py-1">
                                        <img :src="option.thumbnail" alt="" width="50" height="50">
                                        <div class="ms-1">
                                            <h6 class="mb-25">{{ option.title.slice(0, 30) }}</h6>
                                            <p>{{ option.category?.title }}/{{ option.brand?.name ?? '---'}}</p>
                                        </div>
                                    </li>
                                </template>
                            </vSelect>
                        </div>


<!--                        <div class="mt-1">
                            <label>Discount</label>
                            <div class="input-group">
                                <input type="number"
                                       v-model="formData.discount_price"
                                       class="form-control"
                                       placeholder="e.g Amount..." aria-label="Amount">
                                <select name="experience_type"
                                        v-model="formData.discount_type"
                                        class="form-control selectpicker">
                                    <option disabled selected value="null"> e.g Select Type</option>
                                    <option value="percentage">%</option>
                                    <option value="flat">৳</option>
                                </select>
                            </div>
                        </div>-->

                        <div class="d-flex align-items-center justify-content-between">
                            <div class="mt-1">
                                <label>Ads Status</label>
                                <Switch v-model="formData.status" class="justify-content-start" />
                            </div>

                            <button v-if="props.data !== undefined" @click="updateAds" class="btn btn-sm btn-gradient-primary d-flex align-items-center">
                                <vue-feather type="arrow-up" size="15"/>
                                <span class="ms-1">Update Ads</span>
                            </button>
                            <button v-else @click="saveAds" class="btn btn-sm btn-gradient-primary d-flex align-items-center">
                                <vue-feather type="arrow-up" size="15"/>
                                <span class="ms-1">Save Ads</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </layout>
</template>

<style scoped>
.imgContainer {
    height: auto;
}
.imgContainer img {
    display: block;
    max-height: 100%;
    width: auto;
}






</style>
