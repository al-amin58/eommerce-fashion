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

const props = defineProps({
    pages:[]|null,
    savePages:[]|null,
    main_url:String|null,
})


const isLoding = ref(false);
let formData = useForm({
    customPages:[{
        title: '',
        pages: [],
        status: false,
    }]
});


let addRow = () => {
    formData.customPages.push({
        title: '',
        pages: [],
        status: true,
    })
}
let deleteRow = (index) => {
    formData.customPages.splice(index, 1)
}

onMounted(() =>{
    formData.customPages = props.savePages ?? [{}];
})



// const isLoding = ref(false);


let updateSettings = () =>{
    formData.post(props.main_url, {
        onSuccess: (res)=>{
            $sToast.fire({
                icon: "success",
                text: "Business Settings Update Successfully Done.:)",
            });
        },
        onError: (res) =>{
            $sToast.fire({
                icon: "error",
                text: "Business Settings Not Update (:",
            });
        }
    });
}
</script>

<template>
    <layout>
        <div class="row">
            <div class="col-md-6" data-repeater-item
                 v-for="(value, index) in formData.customPages">
                <div class="card">
                    <div class="card-body position-relative imgContainer">
                        <h2 class="card-title">Add banners 2</h2>
                        <div class="mt-1">
                            <input type="text" v-model="formData.customPages[index].title" class="form-control mb-1" placeholder="e.g title">
                            <vSelect :options="props.pages"
                                     v-model="formData.customPages[index].pages"
                                     :reduce="item => item.id"
                                     multiple
                                     label="title"
                                     placeholder="e.g Select Products For Ads">
                                <template v-slot:option="option">
                                    <li class="d-flex align-customPages-start py-1">
                                        <h6 class="mb-25">{{ option.title.slice(0, 30) }}</h6>
                                    </li>
                                </template>
                            </vSelect>
                        </div>

                        <button
                            v-if="index === formData.customPages.length - 1"
                            class="btn btn-primary btn-sm float-end mt-25"
                            type="button"
                            name="button"
                            @click="addRow">
                            <vue-feather type="plus"/>
                        </button>
                        <button
                            class="btn btn-danger btn-sm float-end mt-25 me-1"
                            @click="deleteRow(index)"
                            data-repeater-delete
                            type="button">
                            <vue-feather type="trash"/>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" v-if="!isLoding">
            <div class="col">
                <div class="card bg-light-success cursor-pointer" @click="updateSettings">
                    <div class="card-body d-flex align-customPages-center justify-content-center">
                        <h3 class="text-success">Update Setting</h3>
                    </div>
                </div>
            </div>
            <div class="col">
                <a href="panerl/settings"  class="card bg-light-danger cursor-pointer">
                    <div class="card-body d-flex align-customPages-center justify-content-center">
                        <h3 class="text-danger">Cancel Setting</h3>
                    </div>
                </a>
            </div>
        </div>

        <div class="col d-flex align-customPages-center justify-content-center" v-if="isLoding">
            <img src="../../../images/loading2.svg" alt="">
        </div>
    </layout>
</template>


