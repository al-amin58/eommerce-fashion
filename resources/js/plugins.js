
import { createToaster } from "@meforma/vue-toaster";
import ToastPlugin from 'vue-toast-notification';
// Import one of the available themes
//import 'vue-toast-notification/dist/theme-default.css';
import 'vue-toast-notification/dist/theme-sugar.css';
import {useToast} from 'vue-toast-notification';



import VueNotificationList from '@dafcoe/vue-notification'
import '@dafcoe/vue-notification/dist/vue-notification.css'
import Swal from "sweetalert2";

window.$sToast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})
window.$swal = Swal
window.$mTost = useToast({
    position: "top-right"
})
window.$toast = createToaster({
    position: 'bottom'
});

export default VueNotificationList;
