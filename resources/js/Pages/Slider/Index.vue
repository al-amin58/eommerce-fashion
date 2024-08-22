<script setup>
import layout from "../../Shared/Layout.vue";
import { ref} from "vue";
import {useForm} from "@inertiajs/inertia-vue3";
import Switch from "../../components/Switch.vue";
import {router} from "@inertiajs/vue3";




const props = defineProps({
    sliders:[]|null,
    main_url:String|null,
    errors:Object | null,
})


let formData = useForm({
    image:{},
    link:null,
});

let addRow = () => {
    formData.items.push({
        image:null,
        link:null
    })
}


let deleteRow = (index) => formData.items.splice(index, 1)
const prevImage = ref('../../../images/placeholder.avif');
const imageFile = ref(null);
const inputImage = (event) =>{
    prevImage.value = URL.createObjectURL(event.target.files[0])
    formData.image = event.target.files[0];
}
const clearImage = () => prevImage.value = '../../../images/placeholder.avif';


const isLoading = ref(false)
const handelSubmit = () =>{
    formData.post(props.main_url,{
        preserveState: true,
        replace: true,
        onStart: res =>{
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
            $toast.error('Validation Error')
        }
    })
}


const deleteItem = (id) => {
    router.post(`/panel/delete-slider/${id}`);
}
</script>

<template>
    <Head title="Slider" />
    <layout>
        <div class="content-body">
            <div class="row match-height">
                <div class="col-md-6" >
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="card-title">Slider</h4>
                                <button class="btn btn-sm btn-primary">Add Slider</button>
                            </div>

                            <div class="row d-flex align-items-center">
                                <div class="col-12">

                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">Image</th>
                                                <th scope="col">Path</th>
                                                <th scope="col">Mdify</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="item in sliders" :key="item.id">
                                            <th>
                                                <div class="slider-table-image">
                                                    <img class="w-100 h-100" :src="'/storage/'+item.image" alt="">

                                                </div>
                                            </th>
                                            <td>{{ item.link }}</td>
                                            <td>
                                                <a class="text-warning" href="">
                                                    <vue-feather type="edit" size="15"/>
                                                </a>
                                                <span class="mx-1"> | </span>
                                                <button @click="deleteItem(item.id)"  class="text-danger border-0 bg-transparent">
                                                    <vue-feather type="trash" size="15"/>
                                                </button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">

                            <form @submit.prevent="handelSubmit">
                                <div class="d-flex align-items-center flex-column">

                                    <p class="text-danger" v-if="props.errors.image">{{props.errors.image}}</p>

                                    <div class="card-body position-relative imgContainer">
                                        <img :src="prevImage" class="w-100" alt="">
                                        <button v-if="prevImage !== '../../../images/placeholder.avif'" @click="clearImage" style="position: absolute; right: 31px; top: 31px;">
                                            <vue-feather type="x"/>
                                        </button>
                                    </div>

                                    <input v-model="formData.link" type="text" class="form-control" placeholder="e.g page going url">


                                    <p class="text-danger" v-if="props.errors.link">{{props.errors.link}}</p>
                                    <div class="mt-2 d-flex gap-1">
                                        <label for="adsinput" class="btn btn-primary text-white cursor-pointer">
                                            <input type="file" @input="inputImage" class="d-none" id="adsinput">
                                            <vue-feather type="camera"/>
                                        </label>
                                        <button :disabled="isLoading" type="submit" class="btn btn-success">Save</button>
                                    </div>
                                </div>
                            </form>
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
            </div>
        </div>
    </layout>
</template>

<style>
.slider-table-image{
    width:120px;
    height:100px;
}
.slider-table-image img{
    object-fit:contain;
}
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
