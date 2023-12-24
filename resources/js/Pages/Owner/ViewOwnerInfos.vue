<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import ModalNewCar from "@/Components/ModalNewCar.vue";
import {useGlobalStore} from "@/Stores/globalStore.js";
import {Link, usePage} from "@inertiajs/vue3";
import {ref} from "vue";
import {useForm} from "@inertiajs/vue3";
import axios from "axios";

const page = usePage();
const globalStore = useGlobalStore();

const vehicleType = 'someType';
const brandId = 'someBrandId';
const modelId = 'someModelId';
const yearId = 'someYearId';

const response = axios.get('https://www.tabelafipebrasil.com/api/js/tabelafipe-widget.min.js');

console.log(response.data);





</script>

<template>
    <main>
        <div class="d-flex flex-wrap justify-content-center p-5 h-100 overflow-x-hidden">
            <div class="owner align-self-stretch">
                <h2 class="align-self-center text-center">Dados do Proprietário</h2>
                <div class="area-info content-owner">
                    <label for="name">Nome</label>
                    <h3>{{ page.props.owner[0].name }}</h3>

                    <label for="birth">Data de nascimento</label>
                    <h3>{{ page.props.owner[0].birth }}</h3>

                    <label for="gender">Gênero</label>
                    <h3>{{ globalStore.gender[page.props.owner[0].gender] }}</h3>
                </div>
            </div>

            <div class="cars" v-if="page.props.qtdCars > 0">
                <h2 class="align-self-center text-center">Carros Registrados</h2>
                <div class="car overflow-y-auto overflow-x-hidden" style="max-height: 300px; margin-top: -5px">
                    <div v-for="car in page.props.cars" class="area-info d-flex flex-row content-owner justify-between">
                        <div class="camp">
                        <label for="name">Fabricante</label>
                        <h5>{{  }}</h5>
                        </div>

                        <div class="camp">
                        <label for="birth">Modelo</label>
                        <h5>{{ car.model }}</h5>
                        </div>

                        <div class="camp">
                        <label for="gender">Ano</label>
                        <h5>{{ car.year }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <footer class="d-flex flex-wrap justify-content-center gap-3">
            <PrimaryButton>Editar</PrimaryButton>
            <Link href="/">
            <SecondaryButton>Voltar</SecondaryButton>
            </Link>
            <SecondaryButton data-bs-toggle="modal" data-bs-target="#newOwnerCar" >Adicionar Carro</SecondaryButton>
        </footer>

        <ModalNewCar></ModalNewCar>
    </main>
</template>

<style scoped>
main {
    width: 100vw;
    margin-bottom: 20px;
}

.content-owner {
    border: 3px dashed rgba(255, 159, 71, 0.66);
    border-radius: 11px;
}

.content-owner > h3 {
    margin-bottom: 20px;
}

.area-info {
    display: flex;
    flex-direction: column;
    width: 300px;
    padding: 10px;
    margin: 5px;
}


footer {
    align-self: end;
}
</style>

<script>
import Layout from "@/Components/Layout/Layout.vue";
export default {
    layout: Layout,
}
</script>

