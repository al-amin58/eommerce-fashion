import {defineStore} from "pinia";
import axios from "axios";

export const useDataStore = defineStore('data', {

    state: () => ({
        topCategories:[],
        featuredCategories:[],
        wishList:[],

        settingItem:[],

        authData:{}
    }),

    actions:{
        initTopCategories(){
            axios.get('/fetch-top-categories').then((res) => {
                this.topCategories = res.data
            }).catch((err) =>{
                console.log(err)
            })
        },
        initFeaturedCategories(){
            axios.get('/fetch-featured-categories').then((res) => this.featuredCategories = res.data)
        },
        setSetting(key){
            axios.get(`/get-setting?key=${key}`).then((res) => {
                this.settingItem.push({
                    key:key,
                    val: res.data
                });
            })
        },
        footerData(key){
            axios.get(`/get-footer-setting?key=${key}`).then((res) => {
                this.settingItem.push(  {
                    key:key,
                    val: res.data
                });
            })
        },
        headerMenu(key){
            axios.get(`/get-header-menu?key=${key}`).then((res) => {
                this.settingItem.push(  {
                    key:key,
                    val: res.data
                });
            })
        },



        addToWishList(item){
            this.wishList.push(item);
            this.setWishListStore();
        },
        setWishListStore(){
            localStorage.setItem('wishList', JSON.stringify(this.wishList));
        },
        initWishList() {
            const storeWishList = localStorage.getItem('wishList');
            if (storeWishList) {
                this.wishList = JSON.parse(storeWishList);
            }
        },


        setAuthData(){
            axios.get(`/get-user-date`).then((res) => {
                this.authData = res.data;
            }).catch((err) => console.log(err))
        },


    },

    getters:{
        getTopCategories(){
            return this.topCategories;
        },
        getFeaturedCategories(){
            return this.featuredCategories;
        },
        getWishList(){
            return this.wishList;
        },
        getSetting(key){
            return this.settingItem.find(item => item.key === key);
        },
        getAuthData(){
            return this.authData;
        }
    }




})
