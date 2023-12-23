<script setup>
import ModalNewOwner from "@/Components/ModalNewOwner.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";


</script>

<template>
    <main>
        <div class="nav">

        </div>

        <div class="last-add">

        </div>

        <PrimaryButton data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            Novo proprietário
        </PrimaryButton>

        <ModalNewOwner>

        </ModalNewOwner>
    </main>

</template>

<style scoped>

</style>

<script>
import Layout from "../Components/Layout/Layout.vue";
export default {
    layout: Layout,
}
</script>
