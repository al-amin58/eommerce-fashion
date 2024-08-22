<template>
    <div id="chart2"></div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import ApexCharts from 'apexcharts';

const props = defineProps({
    data:{
        type:Array,
        required:true
    }
})

const chart = ref(null);
const options = {
    chart: {
        type: 'line',
        toolbar: { show: false }
    },
    series: [{
        name: 'sales',
        data: []
    }],
    xaxis: {
        categories: []
    }
};

onMounted(() => {
    options.series[0].data = props.data
    options.xaxis.categories = props.data.map(item => {
        const date = new Date(item.x);
        return date.toLocaleString('en-US', { month: 'long' });
    });

    var chart = new ApexCharts(document.querySelector("#chart2"), options);
    chart.render();
})

</script>
