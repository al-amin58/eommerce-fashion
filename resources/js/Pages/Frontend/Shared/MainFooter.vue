<script setup>

    import {useDataStore} from "../../../Store/useDataStore";
    import {computed, onMounted} from "vue";
    const store = useDataStore();

    onMounted(()=>{
        store.setSetting('address');
        store.setSetting('phone');
        store.setSetting('email');
        store.setSetting('footer_logo');
        store.setSetting('app_details');
        store.footerData('customPages')
    })

    const pages = computed(() =>{
        return store.settingItem.find(item => item.key === 'customPages')?.val
    })
</script>

<template>
    <footer class="pt-5 text-white">
        <div class="container">
            <div class="row justify-content-between">

                <div class="col-lg-4 col-md-6 col-12 mb-3">
                    <div>
                        <img :src="`/storage/${store.settingItem.find(item => item.key === 'footer_logo')?.val}`"  style="width: 160px;" alt="">
                        <p class="mt-2">Creative Tech Park is the best web design company in Bangladesh and it is based in Dhaka, the country’s capital. For the past eight years, it has been renowned for its talented programmers and creative developers.</p>

                        <ul style="list-style: none;" class="p-0 d-flex align-items-center gap-1 mt-2">
                            <h3 class="text-white">Follow US</h3>
                            <li>
                                <a href="https://www.facebook.com/CreativeTechPark" target="_blank">
                                    <vue-feather type="facebook" class="text-white"/>
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <vue-feather type="instagram" class="text-white"/>
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <vue-feather type="twitter" class="text-white"/>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 mb-3">
                    <div>
                        <h3 class="text-white mb-0 mb-md-2">Contuct Us</h3>
                        <div class="d-flex flex-column mt-1" style="gap: 8px;">
                            <p class="m-0">The Imperial Irish Kingdom, Mo-03 (3rd Floor), Merul Badda, Dhaka 1212</p>
                            <a href="tel:01639-200002" class="m-0 text-white">Phone: +8801639-200002</a>
                            <a href="tel:01888-001212" class="m-0 text-white">Phone: +8801888-001212</a>
                            <a href="mailto:info@creativetechpark.com" class="m-0 text-white">Email: info@creativetechpark.com</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 mb-3">
                    <div class="d-flex flex-column" style="gap: 8px;">
                        <h3 class="text-white mb-0 mb-md-2">Let Us Help You</h3>
                        <div class="d-flex flex-column" style="gap: 8px;">
                            <a class=" text-white" href="/">Terms & Conditions</a>
                            <a class=" text-white" href="/">Return & Refund Policy</a>
                            <a class=" text-white" href="/">FAQ</a>
                        </div>
                    </div>
                </div>

                <!-- Dynamic content Comented -->
                <!-- <div class="col">
                    <div class="address-content">
                        <img :src="`/storage/${store.settingItem.find(item => item.key === 'footer_logo')?.val}`"  style="width: 160px;" alt="">
                        <p class="mt-3 sm-footer-about" style="text-align: justify">
                            {{ store.settingItem.find(item => item.key === 'app_details')?.val }}
                        </p>
                    </div>
                </div>

                <div class="col-md-2 col-12" v-for="page in pages">
                    <div class="help-center-content">
                        <h4 class="font-weight-bold">{{ page.title }}</h4>
                        <ul class="navbar-nav">
                            <li class="nav-item d-flex align-items-center text-white" v-for="item in  page.pages">
                                <vue-feather type="arrow-right" size="10"/>
                                <a :href="$page.props.auth.MAIN_URL+'/pages/'+item.slug" class="ms-1 nav-link text-white">{{ item.title }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col">
                    <div class="address-content">
                        <h4 class="font-weight-bold text-white">Address:</h4>
                        <p>{{ store.settingItem.find(item => item.key === 'address')?.val }}</p>
                        <p class="m-0 p-0"><span class="font-weight-bold">Phone:</span>{{ store.settingItem.find(item => item.key === 'phone')?.val }}</p>
                        <p class="m-0 p-0"> <span class="font-weight-bold">Email:</span> {{ store.settingItem.find(item => item.key === 'email')?.val }}</p>
                    </div>
                </div> -->
            </div>
        </div>
        <div style="background-color: #222836;" class="py-2 pb-5 pb-md-2">
            <div class="text-center pb-2 pb-md-0">
                <p class="m-0">&copy; {{ new Date().getFullYear() }} <a class="fw-semibold" href="https://creativetechpark.com" target="_blank">Creative Tech Park</a> All rights reserved.</p>
            </div>
        </div>
    </footer>
</template>

<style lang="scss" scoped>
    footer {
        background: #111926;
    }
</style>
