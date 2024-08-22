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


const {deleteItem, copyToClipboard} = useAction();

const slugTitle = useSlug();

const props = defineProps({
    categories:[] | null,
    parent_categories:[] | null,
    sub_categories:[] | null,
    main_url:String | null,
    errors:Object | null,
    filters: Object,
});

let createForm = useForm({
    title: null,
    parent_id:null,
    sub_cat_id:null,
    order_level:null,
    type:null,
    icon:null,
    banner:null,
});

let updateForm = useForm({
    title: null,
    parent_id:null,
    sub_cat_id:null,
    order_level:null,
    type:null,
    icon:null,
    banner:null,
});

const isLoading = ref(false);
const isShow = ref(null);

const addItem = () => {
    isShow.value = null;
    createForm.post(props.main_url,{
        preserveState: true,
        replace: true,
        onStart: res =>{
            console.log("res "+ res)
            isLoading.value = true;
        },
        onSuccess: page => {
            document.getElementById('addItemModal').$vb.modal.hide()
            isLoading.value = false;
            createForm.reset();
            $sToast.fire({
                icon: 'success',
                title: 'Category added successfully'
            })
        },
        onError: errors => {
            isLoading.value = false;
            $toast.error("Validation Errors...")
        }
    });
}

const updateItem = () =>{
    updateForm.post(props.main_url+"/update-with-files/"+updateForm.id, {
        preserveState: true,
        replace: true,
        onStart: res =>{
            console.log("res "+ res)
            isLoading.value = true;
        },
        onSuccess: page => {
            document.getElementById('editItemModal').$vb.modal.hide()
            isLoading.value = false;
            createForm.reset();
            $sToast.fire({
                icon: 'success',
                title: 'Updated successfully'
            })
        },
        onError: errors => {
            isLoading.value = false;
            $toast.error("Validation Errors...")
        }
    })
}
const childCats = ref(null)
const changeCategory = (event) =>{
    createForm.sub_cat_id = null;
    updateForm.sub_cat_id = null;
    childCats.value = props.sub_categories.filter(item => item.category_id === event)
}

const showItem = (id, type) =>{
    isShow.value = null;
    axios.get(`${props.main_url}/${id}`).then((res) =>{
        updateForm.id = res.data.id;
        updateForm.title = res.data.title;
        updateForm.parent_id = res.data.category?.id;
        updateForm.sub_cat_id = res.data.sub_category?.id;
        updateForm.order_level = res.data.order_level;
        updateForm.type = res.data.type;
        updateForm.icon = res.data.icon;
        updateForm.banner = res.data.banner;

        childCats.value = res.data.category.sub_categories

        document.getElementById('editItemModal').$vb.modal.show()

        console.log(res)

    }).catch((err) =>{
        $toast.error(err.message)
    })
}

const search = ref();
const perPage = ref();

watch([search, perPage], debounce(function ([val, val2]) {
    Inertia.get(props.main_url, { search: val, perPage: val2 }, { preserveState: true, replace: true });
}, 300));

</script>

<template>
    <layout>
        <div class="content-header row mb-1">
            <div class="col-12 d-flex align-items-center justify-content-between">
                <h2 class="float-start mb-0">Child Category List</h2>
                <button class="btn btn-sm btn-gradient-primary d-flex align-items-center"
                        type="button"
                        data-bs-toggle="modal"
                        data-bs-target="#addItemModal">
                    <vue-feather type="plus" size="15"/>
                    <span>Add Sub Sub Category</span>
                </button>
            </div>
        </div>

        <section class="app-user-list">
            <!-- list and filter start -->
            <div class="card">
                <div class="card-datatable table-responsive pt-0 px-2">
                    <div class="d-flex align-items-center justify-content-between border-bottom">
                        <div class="select-search-area d-flex align-items-center">
                            <select class="form-select" v-model="perPage">
                                <option :value="undefined">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <div
                            class="d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap">
                            <div class="select-search-area">
                                <label>Search
                                    <input v-model="search"
                                           type="search"
                                           class="form-control"
                                           placeholder="What You Find ?"
                                           aria-controls="DataTables_Table_0">
                                </label>
                            </div>
                        </div>
                    </div>

                    <table class="category-list-table table">
                        <thead class="table-light">
                        <tr class=null>
                            <th class="sorting">Id</th>
                            <th class="sorting">name</th>
                            <th class="sorting">Parent</th>
                            <th class="sorting">icon</th>
                            <th class="sorting">banner</th>
                            <th class="sorting">Created At</th>
                            <th class="sorting"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(category, i) in categories.data" :key="category.id">
                            <td>#_{{ i+1 }}</td>
                            <td>
                                <span class="d-flex align-items-center" v-if="category.childrens_count > 0">
                                    {{ category.title }}
                                    <span class="text-info" style="margin-left: 5px;" v-c-tooltip="`${category.childrens_count} Child In This Category.`">
                                        <vue-feather type="info" size="15"/>
                                    </span>
                                </span>
                                <span v-else class="text-capitalize">{{ category.title }}</span>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <small>Category: <span class="text-black fw-bold text-capitalize">{{ category.category?.title }}</span></small>
                                    <small>Sub Category: <span class="text-black fw-bold text-capitalize">{{ category.sub_cateogry?.title }}</span></small>
                                </div>
                            </td>
                            <td>
                                <img v-if="category.icon" :src="category.icon" alt="" style="object-fit: contain; max-height:60px;"> <span v-else>---</span>
                            </td>
                            <td>
                                <img v-if="category.banner" :src="category.banner" alt="" width="200" height="100" style="object-fit: contain"> <span v-else>---</span>
                            </td>
                            <td>{{ category.created_at }}</td>
                            <td>
                                <span class="text-primary cursor-pointer"  @click="showItem(category.id, 'edit')">
                                    <vue-feather type="edit" size="15"/>
                                </span>
                                <span class="text-danger cursor-pointer ms-1"  @click="deleteItem(props.main_url, category.id)">
                                    <vue-feather type="trash" size="15"/>
                                </span>
                            </td>
<!--                            <td>
                                <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu p-0" aria-labelledby="dropdownMenuButton">
                                    <button class="dropdown-item d-flex align-items-center text-info w-100" type="button" @click="showItem(category.id, 'edit')">
                                        <vue-feather type="edit" size="15"/>
                                        <span class="ms-1">Edit</span>
                                    </button>
                                    <button class="dropdown-item d-flex align-items-center text-danger w-100" type="button" @click="deleteItem(category.id)">
                                        <vue-feather type="trash" size="15"/>
                                        <span class="ms-1">Delete</span>
                                    </button>
                                </div>
                            </td>-->

                        </tr>
                        </tbody>
                    </table>
                    <Pagination :links="categories.links" :from="categories.from" :to="categories.to" :total="categories.total"/>
                </div>
            </div>
        </section>


        <div class="modal modal-slide-in fade" id="addItemModal" aria-hidden="true" v-vb-is:modal>
            <div class="modal-dialog">
                <div class="modal-content p-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                    <div class="modal-header mb-1">
                        <h5 class="modal-title">
                            <span class="align-middle">Add Category</span>
                        </h5>
                    </div>
                    <div class="modal-body flex-grow-1">
                        <ul v-if="props.errors" >
                            <li class="m-0 p-0 text-danger" v-for="item in props.errors"> {{ item }}</li>
                        </ul>

                        <form @submit.prevent="addItem">
                            <div class="mb-1">
                                <label class="form-label">Title</label>
                                <input class="form-control readonly"
                                       v-model="createForm.title"
                                       type="text" placeholder="e.g latest faction"/>
<!--                                <span class="text-danger" v-if="props.errors.title">{{ props.errors.title }}</span>-->
                            </div>
                            <div class="mb-1">
                                <div class="d-flex align-baseline">
                                    <label>Parent Category</label> <info title="If you want to add this category as a child then select an parent category"/>
                                </div>
                                <vSelect :options="props.parent_categories"
                                         v-model="createForm.parent_id"
                                         label="title"
                                         @update:modelValue="changeCategory"
                                         :reduce="category => category.id"
                                         placeholder="Select Me As Parent"/>
<!--                                <span class="text-danger" v-if="props.errors.parent_id">{{ props.errors.parent_id }}</span>-->
                            </div>

                            <div class="mb-1" v-if="childCats?.length > 0">
                                <div class="d-flex align-baseline">
                                    <label>Sub Category</label> <info title="If you want to add this category as a child then select an parent category"/>
                                </div>
                                <vSelect :options="childCats"
                                         v-model="createForm.sub_cat_id"
                                         label="title"
                                         :reduce="category => category.id"
                                         placeholder="Select Me As Parent"/>
<!--                                <span class="text-danger" v-if="props.errors.parent_id">{{ props.errors.parent_id }}</span>-->
                            </div>

                            <div class="mb-1">
                                <label>Icon Image</label> <info title="Low number order level coming first"/>
                                <ImageUploader v-model="createForm.icon" />
<!--                                <span class="text-danger" v-if="props.errors.icon">{{ props.errors.icon }}</span>-->
                            </div>

                            <div class="mb-1">
                                <label>Banner Image</label> <info title="Low number order level coming first"/>
                                <ImageUploader v-model="createForm.banner" />
<!--                                <span class="text-danger" v-if="props.errors.banner">{{ props.errors.banner }}</span>-->
                            </div>

                            <div class="d-flex flex-wrap mb-0">
                                <button v-if="!isLoading" type="submit" class="btn btn-primary">Submit</button>
                                <button v-else class="btn btn-primary" type="button" disabled>
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Loading...
                                </button>
                                <button type="reset" class="btn btn-outline-secondary ms-1">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal modal-slide-in fade" id="editItemModal" aria-hidden="true" v-vb-is:modal>
            <div class="modal-dialog">
                <div class="modal-content p-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                    <div class="modal-header mb-1">
                        <h5 class="modal-title">
                            <span class="align-middle">Edit This Category</span>
                        </h5>
                    </div>
                    <div class="modal-body flex-grow-1">
                        <form @submit.prevent="updateItem">
                            <div class="mb-1">
                                <label class="form-label">Title</label>
                                <input class="form-control readonly"
                                       v-model="updateForm.title"
                                       type="text" placeholder="e.g latest faction"/>
                                <span class="text-danger" v-if="props.errors.title">{{ props.errors.title }}</span>
                            </div>
                            <div class="mb-1">
                                <div class="d-flex align-baseline">
                                    <label>Parent Category</label>
                                </div>
                                <vSelect :options="props.parent_categories"
                                         v-model="updateForm.parent_id"
                                         label="title"
                                         @update:modelValue="changeCategory"
                                         :reduce="category => category.id"
                                         placeholder="Select Me As Parent"/>
                                <span class="text-danger" v-if="props.errors.parent_id">{{ props.errors.parent_id }}</span>
                            </div>

                            <div class="mb-1" v-if="childCats?.length > 0">
                                <div class="d-flex align-baseline">
                                    <label>Sub Category</label>
                                </div>
                                <vSelect :options="childCats"
                                         v-model="updateForm.sub_cat_id"
                                         label="title"
                                         :reduce="category => category.id"
                                         placeholder="Select Sub Cat"/>
                                <span class="text-danger" v-if="props.errors.parent_id">{{ props.errors.parent_id }}</span>
                            </div>

                            <div class="mb-1">
                                <label>Icon Image</label>
                                <ImageUploader v-model="updateForm.icon" />
                                <img :src="updateForm.icon" width="50" height="50" v-if="typeof updateForm.icon === 'string'" style="object-fit: contain" alt="">
                                <span class="text-danger" v-if="props.errors.icon">{{ props.errors.icon }}</span>
                            </div>

                            <div class="mb-1">
                                <label>Banner Image</label>
                                <ImageUploader v-model="updateForm.banner" />
                                <img :src="updateForm.banner" width="100" height="70" v-if="typeof updateForm.banner === 'string'" style="object-fit: contain" alt="">
                                <span class="text-danger" v-if="props.errors.banner">{{ props.errors.banner }}</span>
                            </div>

                            <div class="d-flex flex-wrap mb-0">
                                <button v-if="!isLoading" type="submit" class="btn btn-primary">Submit</button>
                                <button v-else class="btn btn-primary" type="button" disabled>
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Loading...
                                </button>
                                <button type="reset" class="btn btn-outline-secondary ms-1">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </layout>
</template>
