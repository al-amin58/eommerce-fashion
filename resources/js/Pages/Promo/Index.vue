<script setup>
import layout from "../../Shared/Layout.vue";
import AnimInput from '../../components/AnimInput.vue'
import Modal from '../../components/Modal.vue'
import {computed, onMounted, ref} from "vue";
import {useForm} from "@inertiajs/inertia-vue3";
import ImageUploader from "../../components/ImageUploader.vue";
import Switch from "../../components/Switch.vue";
import {Inertia} from "@inertiajs/inertia";

const props = defineProps({
    banners:[]|null,
    save_url:String|null,
})


let formData = useForm({
    isNav:false,
    isPeg:false,
    autoPlay:false,
    items: [
        {
            image:null,
            url:null
        }
    ],
});

let addRow = () => {
    formData.items.push({
        image:null,
        url:null
    })
}


let deleteRow = (index) => formData.items.splice(index, 1)

onMounted(() =>{
    formData.isNav = props.banners[0]?.isNavigate;
    formData.isPeg = props.banners[0]?.isPaginate;
    formData.autoPlay = props.banners[0]?.autoPlay;
    formData.items = JSON.parse(props.banners[0]['info'])?.length > 0 ? JSON.parse(props.banners[0]['info']) : formData.items;
});





const isLoading = ref(false)
const savePromo = () =>{
    Inertia.post(props.save_url, {formData:formData},{
        preserveState: true,
        replace: true,
        onStart: res =>{
            // console.log("res "+ res)
            isLoading.value = true;
        },
        onSuccess: page => {
            isLoading.value = false;
            $sToast.fire({
                icon: 'success',
                title: 'Updated successfully done...'
            })
        },
        onError: errors => {
            isLoading.value = false;
            $toast.error("Validation Errors...")
        }
    })
}



</script>

<template>
    <layout>
        <div class="content-body">
            <div class="row">
                <div class="col-md-6" >
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="card-title">Slider</h4>
                                <button class="btn btn-sm btn-primary">Add Slider</button>
                            </div>


                            <div class="row d-flex align-items-center">
                                <div class="col-12">
<!--                                    <div class="input-group border-0 d-flex align-items-center mb-1" v-for="(variant, index) in formData.items">
                                        <div class="d-flex flex-column">
                                            <div>
                                                <div v-show="variant.path && !formData.items[index].image">
                                                    <img :src="$page.props.auth.MAIN_URL+'/storage/'+variant.path" alt="avatar" width="250" >
                                                </div>
                                                <ImageUploader v-model="formData.items[index].image"/>
                                                <input type="text" class="form-control mb-1 rounded-start"
                                                       placeholder="e.g https://example.com/?category=category_slug" v-model="formData.items[index].url" >
                                            </div>
                                            <button
                                                v-if="index === formData.items.length - 1 "
                                                class="btn btn-primary btn-sm float-end mb-1"
                                                type="button"
                                                @click="addRow()">
                                                <vue-feather type="plus" size="20"/>
                                            </button>
                                            <button
                                                v-else
                                                class="btn btn-danger btn-sm float-end mb-1"
                                                @click="deleteRow(index)"
                                                data-repeater-delete
                                                type="button">
                                                <vue-feather type="trash" size="20"/>
                                            </button>
                                        </div>
                                    </div>

                                    <button
                                        class="btn border btn-sm float-end mt-2"
                                        type="button">
                                        Clear
                                    </button>
                                    <button
                                        class="btn btn-success btn-sm float-end mt-2 me-1"
                                        type="button"
                                        :disabled="isLoading"
                                        @click="savePromo"
                                        name="button">
                                        Save Promo
                                    </button>-->

                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">Image</th>
                                                <th scope="col">Path</th>
                                                <th scope="col">Mdify</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <th>1</th>
                                            <td>Mark</td>
                                            <td>
                                                <a class="text-warning" href="">
                                                    <vue-feather type="edit" size="15"/>
                                                </a>
                                                <span class="mx-1"> | </span>
                                                <a class="text-danger" href="">
                                                    <vue-feather type="trash" size="15"/>
                                                </a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-2">
                    <div class="card">
                        <div class="card-body text-center" v-c-tooltip="'If you want to enable home slider pagination icon then enable this.'">
                            <Switch v-model="formData.isNav"  class="mb-1"/>
                            <span class="label">Navigation</span>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body text-center" v-c-tooltip="'If you want to enable home slider navigation button then enable this.'">
                            <Switch v-model="formData.isPeg" class="mb-1"/>
                            <span class="label">Pagination</span>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body text-center" v-c-tooltip="'If you want to enable home slider automaticity changed then enable it'">
                            <Switch v-model="formData.autoPlay" class="mb-1"/>
                            <span class="label">Autoplay</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <ul class="list-group">
                        <li class="list-group-item">
                            1. Product Wise Shipping Cost calulation: Shipping cost is calculate by addition of each product shipping cost.
                        </li>
                        <li class="list-group-item">
                            2. Flat Rate Shipping Cost calulation: How many products a customer purchase, doesn't matter. Shipping cost is fixed.
                        </li>
                        <li class="list-group-item">
                            3. Seller Wise Flat Shipping Cost calulation: Fixed rate for each seller. If customers purchase 2 product from two seller shipping cost is calculated by addition of each seller flat shipping cost.
                        </li>
                        <li class="list-group-item">
                            4. Area Wise Flat Shipping Cost calulation: Fixed rate for each area. If customers purchase multiple products from one seller shipping cost is calculated by the customer shipping area. To configure area wise shipping cost go to Shipping Cities.
                        </li>
                    </ul>
                </div>

            </div>
        </div>


    </layout>
</template>

<style>
.showColor{
    width:20px;
    height: 20px;
    display: block;
    border-radius: 5px;
    border: 1px solid var(--bs-black);
}
.vs__dropdown-toggle{
    padding: 6px !important;
}


.submit-button-gless{
    position: relative;
    padding: 20px 50px;
    text-decoration: none;
    color: #fff;
    font-size: 2em;
    text-transform: uppercase;
    font-family: sans-serif;
    letter-spacing: 4px;
    overflow: hidden;
    background: rgba(255,255,255,.1);
    box-shadow: 0 5px 5px rgba(0,0,0.2);
}
.submit-button-gless:before{
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 50%;
    height: 100%;
    background: rgba(255,255,255,.1);
}
.submit-button-gless:after{
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg,transparent,rgba(255,255,255,.4),transparent);
    transition: 0.5s;
    transition-delay: 0.5s;
}
.submit-button-gless:hover:after{
    left: 100%;
}
.submit-button-gless span{
    position: absolute;
    display: block;
    transition: 0.5s ease;
}
.submit-button-gless span:nth-child(1)
{
    top: 0;
    left: 0;
    width: 0;
    height: 1px;
    background: #fff;
}
.submit-button-gless:hover span:nth-child(1)
{
    width: 100%;
    transform: translateX(100%);
}
.submit-button-gless span:nth-child(3)
{
    bottom: 0;
    right: 0;
    width: 0;
    height: 1px;
    background: #fff;
}
.submit-button-gless:hover span:nth-child(3)
{
    width: 100%;
    transform: translateX(-100%);
}
.submit-button-gless span:nth-child(2)
{
    top: 0;
    left: 0;
    width: 1px;
    height: 0;
    background: #fff;
}
.submit-button-gless:hover span:nth-child(2)
{
    height: 100%;
    transform: translateY(100%);
}
.submit-button-gless span:nth-child(4)
{
    bottom: 0;
    right: 0;
    width: 1px;
    height: 0;
    background: #fff;
}
.submit-button-gless:hover span:nth-child(4)
{
    height: 100%;
    transform: translateY(-100%);
}


</style>
