<script setup>
import ModalNewOwner from "@/Components/ModalNewOwner.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {usePage} from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import {Link} from "@inertiajs/vue3";
import {ref} from "vue";
import CardOwner from "@/Components/CardOwner.vue";

const page = usePage();

let showContent = ref(true);


</script>

<template>
    <main>
        <div class="nav d-flex align-items-center justify-content-center mt-6">
            <TextInput
                model-value=""
                @focus="showContent = false">
            </TextInput>
        </div>

        <div v-if="showContent" class="content d-grid align-items-center justify-content-center">
            <PrimaryButton data-bs-toggle="modal" data-bs-target="#newOwner" class="mt-40">
                Novo proprietário
            </PrimaryButton>

            <h2 class="fs-5 mt-10 text-center">CADASTRADOS RECENTEMENTE</h2>
            <div class="contentCards d-flex flex-wrap justify-content-center">

                <Link
                    :href="`/view/owner/${ownerData.owner.id_owner}`"
                    :headers="{ 'id_owner': String(ownerData.owner.id_owner) }"
                    v-for="ownerData in page.props.data"
                    :key="ownerData.owner.id_owner"
                    style="text-decoration: none; color: black; font-family: 'Arial'"
                >
                <CardOwner

                           :name="ownerData.owner.name"
                           :qtd-cars="ownerData.qtdCars">
                </CardOwner>
                </Link>
            </div>

            <ModalNewOwner>
            </ModalNewOwner>
        </div>
    </main>

</template>

<style >
html {
    overflow-x: hidden;
}
</style>

<script>
import Layout from "../Components/Layout/Layout.vue";
export default {
    layout: Layout,
}
</script>
