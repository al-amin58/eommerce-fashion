<script setup>
import layout from "../../Shared/Layout.vue";
import AnimInput from '../../components/AnimInput.vue'
 import Modal from '../../components/Modal.vue'
import {computed, ref} from "vue";
import {useForm} from "@inertiajs/inertia-vue3";

const props = defineProps({
    categories:[] | null,
    brands:[]|null,
    colors:[]|null,
})


const randSku = computed(() => Math.floor(100000 + Math.random() * 900000));

const myData = ref();


let formData = useForm({
    description:"",


    quatations: [
        {
            itemname: ' This is Item name',
            options: [
                {
                    price:null,
                    size:null,
                }
            ],
        }
    ],
});



const renderOptionGroup = (categories, prefix = '') => {
    return categories.map((category) => {

        let cValue = '';
        for (let i = 0; i < category.order_level; i++){
            cValue += '--';
        }
        const label = `${cValue}${category.title}`;
        if (category.children && category.children.length > 0) {
            const childPrefix = `${prefix}\xa0\xa0\xa0`;
            return {
                label,
                options: renderOptionGroup(category.children, childPrefix),
            };
        } else {
            const value = { ...category };
            return {
                label,
                value,
            };
        }
    });
};
const formattedParentCategories = computed(() => {
    return renderOptionGroup(props.categories);
});
let addRow = () => {
    formData.quatations.push({
        itemname: '',
        options: [
            {
                price: null,
                size: null,
            }
        ],
    })
}
let deleteRow = (index) => formData.quatations.splice(index, 1)


const addRowVariant = (item) =>{
    item.options.push({
        price: null,
        size:null
    });
}

const deleteRowVariant = (itemIndex, variantIndex) => formData.quatations[itemIndex].options.splice(variantIndex, 1);
const colorName = ref(null);
const selectColor = (event) => colorName.value = event.name;



const addDisc = () => document.getElementById('addDisc').$vb.modal.show();



</script>

<template>
    <layout>

<!--        <div class="content-header row mb-1">
            <div class="col-12 d-flex align-items-center justify-content-between text-right">
                <a class="btn btn-sm btn-gradient-danger d-flex align-items-center"
                   :href="`${this.$page.props.auth.ADMIN_URL}/products`"
                   type="button">
                    <vue-feather type="corner-down-left" size="15"/>
                    <span class="ms-1">Back To List</span>
                </a>
            </div>
        </div>-->


        <div class="content-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <h1 class="fw-bolder">
                                #pro_{{ randSku  }}
                            </h1>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <AnimInput label="Product Title" v-model="myData"/>
                            <div class="form-group mt-1">
                                <label>Category</label>
                                <vSelect :options="formattedParentCategories" label="label" placeholder="e.g Select Category">
                                    <template v-slot:option="option">
                                        <li class="d-flex align-items-start py-1">
                                            <div class="d-flex align-items-center justify-content-between w-100">
                                                <div class="me-1 d-flex flex-column">
                                                    <h6 class="mb-25">{{ option.label }}</h6>
                                                </div>
                                            </div>
                                        </li>
                                    </template>
                                </vSelect>
                            </div>
                            <div class="form-group mt-1">
                                <label>Category</label>
                                <vSelect :options="brands" label="name" placeholder="e.g Select Brand">
                                    <template v-slot:option="option" v-c-tooltip="option.slogan ?? ''">
                                        <li class="d-flex align-items-start py-1">
                                            <div class="d-flex align-items-center justify-content-between w-100">
                                                <div class="me-1 d-flex flex-column" >
                                                    <h6 class="mb-25">{{ option.name }}</h6>
                                                    <img :src="option.icon" alt="" width="50" height="50">
                                                </div>
                                            </div>
                                        </li>
                                    </template>
                                </vSelect>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="form-group mt-1">
                                <label>Default Price</label> <info title="Average Price"/>
                                <input class="form-control" type="text" placeholder="e.g 00.0 ৳">
                            </div>

                            <fieldset class="mt-1">
                                <label>Discount</label> <info title="Apply Also Variant Price." />
                                <div class="input-group">
                                    <input type="number" class="form-control"
                                           name="min_experience"
                                           placeholder="e.g Amount..." aria-label="Amount">
                                    <select name="experience_type"
                                            class="form-control selectpicker">
                                        <option disabled selected> e.g Select Type</option>
                                        <option value="percentage">%</option>
                                        <option value="flat">৳</option>
                                    </select>
                                </div>
                            </fieldset>

                            <div class="form-group mt-1">
                                <label>Purchase Price</label> <info title="Average Price"/>
                                <input class="form-control" type="text" placeholder="e.g Amount 00.0 ৳">
                            </div>
                        </div>
                    </div>


                    <div class="card">
                        <div class="card-body">
                            <div class="">
                                <strong class="mb-md-25">Short Description</strong>
                                <p class="border-bottom p-1 bg-light cursor-pointer" @click="addDisc"> {{ formData.description != "" ? formData.description.slice(0, 70)+"..." : 'e.g what you want to write about your product.' }}</p>
                            </div>
                        </div>
                    </div>


                    <div class="card">
                        <div class="card-body">
                            <div class="">
                                <strong class="mb-md-25">Full Specification</strong>
                                <p class="border-bottom p-1 bg-light cursor-pointer" @click="addSpec">e.g do you think write about your product full specification here ?.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6" >
                    <div class="row" data-repeater-item v-for="(item, index) in formData.quatations">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Variant</h4>
                                <div class="row d-flex align-items-center">
                                    <div class="col-12">
                                        <div class="row mb-1">
                                            <div class="col">
                                                <vSelect :options="colors" v-model="formData.quatations[index].color" @update:modelValue="selectColor($event)" label="name" placeholder="e.g Select Product Color">
                                                    <template v-slot:option="option">
                                                        <li class="d-flex align-items-start py-1">
                                                            <div class="d-flex align-items-center justify-content-between w-100">
                                                                <div class="me-1 d-flex flex-column">
                                                                    <div class="d-flex align-items-center">
                                                                        <span class="showColor" :style="`background:${option.code} `"></span>
                                                                        <h6 class="mb-25 ms-1">{{ option.name }}</h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </template>
                                                </vSelect>
                                            </div>
                                            <div class="col">
                                                <div class="mb-1">
                                                    <span class="d-flex flex-row align-items-center">
                                                        <input type="file" class="form-control" multiple v-c-tooltip="'Click here for chous file. If you want to chos multiple image then hold press ctrl and select images or select multiple image with mouse cursor.'"/>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="input-group border-0 d-flex align-items-center mb-1" v-for="(variant, vIndex) in item.options">

                                            <input type="text" class="form-control rounded-start"
                                                   placeholder="Size" v-model="formData.quatations[index].options[vIndex].size" >

                                            <input type="text" class="form-control"
                                                   placeholder="Price" v-model="formData.quatations[index].options[vIndex].price" >
                                            <button
                                                v-if="vIndex === item.options.length - 1 "
                                                class="btn btn-primary btn-sm float-end"
                                                type="button"
                                                @click="addRowVariant(item)">
                                                <vue-feather type="plus" size="20"/>
                                            </button>
                                            <button
                                                v-else
                                                class="btn btn-danger btn-sm float-end"
                                                @click="deleteRowVariant(index, vIndex)"
                                                data-repeater-delete
                                                type="button">
                                                <vue-feather type="trash" size="20"/>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <button
                                    v-if="index === formData.quatations.length - 1"
                                    class="btn btn-primary btn-sm float-end mt-2"
                                    type="button"
                                    name="button"
                                    @click="addRow">
                                    <vue-feather type="plus"/>
                                </button>
                                <button
                                    class="btn btn-danger btn-sm float-end mt-2 me-1"
                                    @click="deleteRow(index)"
                                    data-repeater-delete
                                    type="button">
                                    <vue-feather type="trash"/>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="card">
                        <a>
                            <div class="card-body d-flex align-items-center justify-content-center">
                                <h4 class="py-2 mb-0 text-success">save</h4>
                            </div>
                        </a>
                    </div>
                    <div class="card">
                        <a>
                            <div class="card-body d-flex align-items-center justify-content-center">
                                <h4 class="py-2 mb-0 text-warning">Cancel</h4>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <Modal id="addDisc" title="Full Description About This Product"  v-vb-is:modal>
            <div class="modal-body">
                <textarea v-model="formData.description" rows="10" class="form-control" placeholder="e.g write here"></textarea>
            </div>

            <div class="modal-footer">
                <button class="btn btn-success" data-bs-dismiss="modal" aria-label="Close">Ok</button>
            </div>
        </Modal>


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
