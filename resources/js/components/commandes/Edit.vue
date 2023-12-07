<script setup>
import { onMounted, ref } from "vue";

let form = ref({ id: "" });
const props = defineProps({
    id: {
        type: String,
        default: "",
    },
});

const getInvoice = async () => {
    let response = await axios.get(`/api/invoice/edit/${props.id}`);
};
</script>

<template>
    <div class="container"></div>
</template>
