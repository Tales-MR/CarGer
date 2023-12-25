<script setup>
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {useForm, usePage} from '@inertiajs/vue3';
import {Link} from "@inertiajs/vue3";

const page = usePage();

let carData = page.props.car[0];
let modelData = page.props.model;

</script>

<template>
    <!-- Modal -->
   <main>
        <div class="header d-flex flex-wrap align-self-sm-center justify-content-around m-6">
            <div class="camp">
                <h3>Fabricante</h3>
                <h4>fabric</h4>
                <hr>
            </div>

            <div class="camp">
                <h3>Modelo</h3>
                <h4>{{ modelData.name }}</h4>
                <hr>
            </div>

            <div class="camp">
                <h3>Ano</h3>
                <h4>{{ carData.year }}</h4>
                <hr>
            </div>

            <div class="camp">
                <h3>Última Revisão</h3>
                <h4>Revisoes</h4>
                <hr>
            </div>
        </div>



        <footer>
            <SecondaryButton>Deletar</SecondaryButton>
            <Link :href="`/view/owner/${carData.id_owner}`">
            <SecondaryButton>Voltar</SecondaryButton>
            </Link>
        </footer>
   </main>


</template>

<style scoped>
main, body, html {
    width: 100%;
    height: 100%;
}

.camp {
    margin: 0 20px;
}

@media screen and (max-width: 599px) {
    .header {
        flex-direction: column;
    }
}
</style>

<script>
import Layout from "@/Components/Layout/Layout.vue";
export default {
    layout: Layout,
}
</script>
