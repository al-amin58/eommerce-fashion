


import { createApp, h } from "vue";
import { createInertiaApp, Link, Head } from "@inertiajs/inertia-vue3";
import { createPinia } from "pinia";
import VueFeather from 'vue-feather';
import store from './Store'
import { createVbPlugin } from 'vue3-plugin-bootstrap5'
import { Alert, Button, Carousel, Collapse, Dropdown, Modal, Offcanvas, Popover, ScrollSpy, Tab, Toast, Tooltip } from 'bootstrap'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';
import coreUi from '@coreui/vue'
import { vctooltip } from "@coreui/vue";
import suggest from "./components/Sujesation.vue";
import VueNotificationList from "./plugins.js"
import { useData } from "./Composables/useData";
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';


const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(createPinia())
            .use(store)
            .use(VueNotificationList)
            .use(vbPlugin)
            .use(coreUi)
            .directive('tooltip', vctooltip)
            .component("Link", Link)
            .component("Head", Head)
            .component('info', suggest)
            .component(VueFeather.name, VueFeather)
            .component("vSelect", vSelect)
            .component("Datepicker", Datepicker)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});


const priceStr = useData();
let vbPlugin = createVbPlugin({ Alert, Button, Carousel, Collapse, Dropdown, Modal, Offcanvas, Popover, ScrollSpy, Tab, Toast, Tooltip });



