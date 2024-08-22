
<script setup>
import {useForm} from "@inertiajs/inertia-vue3";
import layout from "../../Shared/Layout.vue";
import {ref, watchEffect} from "vue";
import {useSlug} from "../../Composables/useSlug";
import Editor from "../../components/Editor.vue";


const {makeSlug} = useSlug();


const props = defineProps({
    main_url: String|null,
});
const fullPageSpecification = ref(false)
const fullPageSpec = () => fullPageSpecification.value = true;
const defaultPageSpec = () => fullPageSpecification.value = false;

let createForm = useForm({
    title: null,
    slug:null,
    summery:null,

    seoTitle:null,
    seoKeyWords:null,
    seoImage:null,
    seoDiscriptions:null,
});

const isLoading = ref(false);
const addPage = () => {
    createForm.post(props.main_url,{
        preserveState: true,
        replace: true,
        onStart: res =>{
            console.log("res "+ res)
            isLoading.value = true;
        },
        onSuccess: page => {
            isLoading.value = false;
            createForm.reset();
            $sToast.fire({
                icon: 'success',
                title: "Page Save Successfully Done...."
            })
        },
        onError: errors => {
            isLoading.value = false;
            $toast.error("Validation Errors...")
        }
    });
}

const seoImageUpload = (event) => createForm.seoImage = event.target.files[0];

watchEffect(() => {
    createForm.slug = makeSlug(createForm.title)
})



</script>


<template>
    <layout>
        <div class="content-header row mb-1">
            <div class="col-12 d-flex align-items-center justify-content-between">
                <h2 class="float-start mb-0">page List</h2>
                <a :href="$page.props.auth.ADMIN_URL+'/pages'" class="btn btn-sm btn-gradient-primary d-flex align-items-center">
                    <vue-feather type="arrow-left" size="15"/>
                    <span>Go To Back</span>
                </a>
            </div>
        </div>


        <section class="app-user-list">
            <div class="container mt-5">
                <div class="row match-height">
                    <div :class="fullPageSpecification ? 'col-md-12': 'col-md-7'" >
                        <div class="card"  :class="fullPageSpecification ? 'd-none' : ''">
                            <div class="card-body">
                                <h2 class="card-title">Page Title & Slug</h2>
                                <div class="form-group mt-1">
                                    <label>Title</label> <info title="Page Title"/>
                                    <input v-model="createForm.title" class="form-control" type="text" placeholder="e.g This is page title">
                                </div>
                                <div class="form-group mt-1">
                                    <label>slug</label> <info title="Url Slug Convert To Title"/>
                                    <input class="form-control" disabled type="text" v-model="createForm.slug" placeholder="e.g Title-convert-to-slug">
                                </div>
<!--                                <div class="mt-2">
                                    <label for="switch">Status</label>
                                    <Switch label="Status" v-model="createForm.status" id="switch" class="justify-content-start"/>
                                </div>-->
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h3>Full Specification's</h3>
                                    <button v-if="!fullPageSpecification" class="btn-icon btn" @click="fullPageSpec" v-c-tooltip="'Enter Full page'" >
                                        <vue-feather type="external-link"/>
                                    </button>
                                    <button v-else class="btn-icon btn" @click="defaultPageSpec" v-c-tooltip="'Exit full page'" >
                                        <vue-feather type="external-link" style="rotate: 180deg;"/>
                                    </button>
                                </div>
                                <div class="">
                                    <Editor v-model="createForm.summery" :isMultiline="fullPageSpecification" :height=" fullPageSpecification ? '600px' : '400px'"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5" :class="fullPageSpecification ? 'd-none' : ''">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="card-title">Page Seo Details & Meta Keywords</h2>
                                <div class="mb-1">
                                    <label class="label">Title</label>
                                    <input v-model="createForm.seoTitle" class="form-control"  type="text" placeholder="e.g seo title / default product title">
                                </div>
                                <div class="mb-1">
                                    <label class="label">Keywords</label>
                                    <v-select
                                        v-model="createForm.seoKeyWords"
                                        multiple
                                        taggable
                                        placeholder="Product Sizes"></v-select>
                                </div>

                                <div class="mb-1">
                                    <label class="label">Image</label>
                                    <input type="file" @input="seoImageUpload" class="form-control" v-c-tooltip="'Click here for choose file'"/>
                                </div>

                                <div class="mt-1">
                                    <label class="label">Description's</label>
                                    <textarea v-model="createForm.seoDiscriptions" class="form-control" id="" rows="8" placeholder="e.g seo full descriptions"></textarea>
                                </div>
                            </div>

                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="row" v-if="!isLoading">


                                    <div class="col">
                                        <div class="card bg-light-success cursor-pointer" @click="addPage">
                                            <div class="card-body d-flex align-items-center justify-content-center">
                                                <h3 class="text-success">Save Page</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <a :href="$page.props.auth.ADMIN_URL+'/pages'"  class="card bg-light-danger cursor-pointer">
                                            <div class="card-body d-flex align-items-center justify-content-center">
                                                <h3 class="text-danger">Cancel Request</h3>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div v-else class="d-flex align-items-center justify-content-center" >
                                    <img src="../../../images/loading2.svg" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </layout>
</template>

<style scoped>

</style>
