<script setup>
defineProps({
    name: {
        type: String,
        required: true,
    },
    qtdCars: {
        type: Number,
        required: true,
    }
});

defineEmits(['update:modelValue']);
</script>

<template>
    <div class="content">
        <div class="last-add d-flex flex-wrap justify-content-center overflow-y-auto gap-4">
            <div class="card-owner" style="max-width: 18rem; cursor: pointer">

                <div class="title d-flex justify-content-center text-center"><h2 class="fs-3">{{ name }}</h2></div>
                <hr>
                    <h3 class="card-title fs-5 text-center">Carros registrados: {{ qtdCars }}</h3>
            </div>
        </div>
    </div>
</template>

<style scoped>


    .card-owner {
        padding: 2px;
        border: 3px solid #FF9F47;
        background-color: #fff8f1;
        border-radius: 11px;
        width: 250px;
        height: fit-content;
        transition-duration: 0.3s;
        margin: 5px;
    }

    .card-owner:hover {
        border-radius: 11px;
        box-shadow: 1px 1px 10px rgba(51, 32, 9, 0.44);
        transform: scaleX(1.005);
    }

    hr {
        border: 2px dashed #FF9F47;
        margin: 2px;
    }
</style>
