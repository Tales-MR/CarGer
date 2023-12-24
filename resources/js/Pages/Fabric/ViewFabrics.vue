<script setup>
import SecondaryButton from "@/Components/SecondaryButton.vue";
import ModalNewFabric from "@/Components/ModalNewFabric.vue";

</script>

<template>
    <main>
        <SecondaryButton data-bs-toggle="modal" data-bs-target="#newFabric">Registrar Fabricante</SecondaryButton>


        <ModalNewFabric></ModalNewFabric>
    </main>
</template>

<style scoped>

</style>

<script>
import Layout from "@/Components/Layout/Layout.vue";
export default {
    layout: Layout,
}
</script>
