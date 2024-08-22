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
// import Pagination from "../../components/Pagination";
import {useAction} from "../../Composables/useAction";
const {deleteItem, copyToClipboard} = useAction();
const props = defineProps({
    arias:[] | null,
    main_url:String | null,
    filters: Object,
});
const action = useAction();

const isLoading = ref(false);
const createForm = useForm({
    area_name:null,
    area_code:null,
    delivery_charge:null,
    charge_condition:null,
    charge_condition_price:null,
})


const addItem = () => {
    createForm.post(props.main_url,{
        preserveState: true,
        replace: true,
        onStart: res =>{
            isLoading.value = true;
        },
        onSuccess: area => {
            document.getElementById('addItemModal').$vb.modal.hide()
            isLoading.value = false;
            createForm.reset();
            $sToast.fire({
                icon: 'success',
                title: 'Signed in successfully'
            })
        },
        onError: errors => {
            isLoading.value = false;
            $toast.error("Validation Errors...")
        }
    });
}


const search = ref();
const perarea = ref();

watch([search, perarea], debounce(function ([val, val2]) {
    Inertia.get(props.main_url, { search: val, perarea: val2 }, { preserveState: true, replace: true });
}, 300));

computed(() => {
    $sToast.fire({
        icon: 'success',
        title: usearea().props.value.message
    })
});



</script>

<template>
    <layout>
        <div class="content-header row mb-1">
            <div class="col-12 d-flex align-items-center justify-content-between">
                <h2 class="float-start mb-0">Order Area</h2>
                <button class="btn btn-sm btn-gradient-primary d-flex align-items-center"
                        type="button"
                        data-bs-toggle="modal"
                        data-bs-target="#addItemModal">
                    <vue-feather type="plus" size="15"/>
                    <span>Add Area</span>
                </button>
            </div>
        </div>

        <section class="app-user-list">
            <!-- list and filter start -->
            <div class="card">
                <div class="card-datatable table-responsive pt-0 px-2">
                    <div class="d-flex align-items-center justify-content-between border-bottom">
                        <div class="select-search-area d-flex align-items-center">
                            <select class="form-select" v-model="perarea">
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

                    <table class="area-list-table table">
                        <thead class="table-light">
                        <tr class=null>
                            <th class="sorting">Id</th>
                            <th class="sorting">Area Name</th>
                            <th class="sorting">Area Code</th>
                            <th class="sorting">Delivery Charge</th>
                            <th class="sorting">Charge Condition</th>
                            <th class="sorting">Condition Price</th>
                            <td></td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(area, i) in arias.data" :key="area.id">
                           <td>{{ i+1 }}</td>
                           <td>{{ area.area_name }}</td>
                           <td>{{ area.area_code }}</td>
                           <td>{{ area.delivery_charge }}</td>
                           <td>{{ area.charge_condition }}</td>
                           <td>{{ area.charge_condition_price }}</td>
                           <td>
                               <button class="btn btn-icon btn-danger" @click="action.deleteItem(props.main_url, area.id)">
                                   <vue-feather type="trash" size="12"/>
                               </button>
                           </td>

                        </tr>
                        </tbody>
                    </table>
                    <Pagination :links="arias.links" :from="arias.from" :to="arias.to" :total="arias.total"/>
                </div>
            </div>
        </section>
    </layout>


    <div class="modal modal-slide-in fade" id="addItemModal" aria-hidden="true" v-vb-is:modal>
        <div class="modal-dialog">
            <div class="modal-content p-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                <div class="modal-header mb-1">
                    <h5 class="modal-title">
                        <span class="align-middle">Area Address</span>
                    </h5>
                </div>
                <div class="modal-body flex-grow-1">
                    <form @submit.prevent="addItem">
<!--                        delivery_charge	charge_condition	charge_condition_price-->
                        <div class="mb-1">
                            <label class="form-label">Area Address</label>
                            <input class="form-control readonly"
                                   v-model="createForm.area_name"
                                   type="text" placeholder="e.g Area name"/>
                        </div>
                        <div class="mb-1">
                            <label class="form-label">Area Code</label>
                            <input class="form-control readonly"
                                   v-model="createForm.area_code"
                                   type="text" placeholder="e.g Area code"/>
                        </div>
                        <div class="mb-1">
                            <label class="form-label">Delivery Charge</label>
                            <input class="form-control readonly"
                                   v-model="createForm.delivery_charge"
                                   type="text" placeholder="e.g Delivery charge for this area"/>
                        </div>
                        <div class="mb-1">
                            <label class="form-label">Charge Condition</label>
                            <input class="form-control readonly"
                                   v-model="createForm.charge_condition"
                                   type="text" placeholder="e.g Charge Condition price"/>
                        </div>
                        <div class="mb-1">
                            <label class="form-label">Condition Price</label>
                            <input class="form-control readonly"
                                   v-model="createForm.charge_condition_price"
                                   type="text" placeholder="e.g Charge Condition price"/>
                        </div>


                        <div class="d-flex flex-wrap mb-0">
                            <button v-if="!isLoading" type="submit" class="btn btn-primary">Submit</button>
                            <button v-else class="btn btn-primary" type="button" disabled>
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Loading...
                            </button>
                            <button type="reset" class="btn btn-outline-secondary ms-1" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
