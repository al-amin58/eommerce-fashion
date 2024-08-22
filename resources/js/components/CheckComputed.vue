<template>
    <div>
        <input v-model="firstName" />
        <input v-model="lastName" />
        <input v-model="fullName" />
        <pre v-text="{ firstName, lastName, fullName, name }"></pre>
    </div>

</template>


<script>
import {reactive, computed,toRefs} from 'vue'
    export default {
        setup() {
            const firstName = computed(()=> "my first anme")

            const state = reactive({
                firstName: "firstName",
                lastName: 'Doe',

                // getter + setter
                fullName: computed({
                    get() {
                        return state.firstName+" "+state.lastName
                    },
                    set(val) {
                        console.log(val)
                        state.firstName = val;
                        // const [last, ...rest] = val.split(' ').reverse()
                        // state.firstName = rest.reverse().join(' ')
                        // state.lastName = last
                    }
                }),

                // getter only:
                name: computed(() => state.fullName)
            })
            return toRefs(state)
        }
    }
</script>
