<script setup>
import ModalNewOwner from "@/Components/ModalNewOwner.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {useForm, usePage} from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import {ref, watch} from "vue";
import CardOwner from "@/Components/CardOwner.vue";
import axios from "axios";
import ModalViewOwner from "@/Components/ModalViewOwner.vue";
import Swal from "sweetalert2";

let openOwner = useForm({
    name: '',
    birth: '',
    gender: 0,
});

const axiosGetOwnerData = async function (index) {

    let response = (await axios.post('/view/owner', {
        id_owner: String(index)
    })).data;

    if (response) {
        const ownerData = response['owner'][0];
        const carData   = response['car'][0];

        openOwner.name = ownerData.name;
        openOwner.birth = ownerData.birth;
        openOwner.gender = ownerData.gender;

    } else {
        await Swal.fire({ //PopUp
            icon: "warning",
            title: "ERRO!",
            text: "Houve um erro com a solicitação, tente novamente."
        })
    }
}

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

                <CardOwner v-for="ownerData in page.props.data"
                           :name="ownerData.owner.name"
                           :qtd-cars="ownerData.qtdCars"
                           @click="axiosGetOwnerData(ownerData.owner.id_owner)">


                </CardOwner>
            </div>

            <ModalViewOwner
                :name="openOwner.name"
                :birth="openOwner.birth"
                :gender="openOwner.gender">
            </ModalViewOwner>
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
