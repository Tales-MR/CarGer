<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {useForm, usePage} from '@inertiajs/vue3';
import  Swal  from "sweetalert2";
import axios from "axios";
import { ref } from "vue";

let owner = useForm({
    name: 'Tales',
    birth: '2004-12-13',
    gender: 1,
    addCar: false
});

let car = useForm({
    fabric: 'FIAT',
    model: 'UNO',
    year: '2012',
});

let carros = ref([])

console.log(carros.value);

let clear = function (){
    owner.reset();
    car.reset();
};

let sendData = async function (){

    const response = (await axios.post('/register/validate/owner', {
        name: owner.name,
        birth: owner.birth,
    })).data;

    if (response.code !== 1){
        let cancel = false;

        await Swal.fire({
            icon: "warning",
            title: "Proprietário duplicado",
            text: response.message,
            showCancelButton: true,
            confirmButtonText: "Confirmar",
            cancelButtonText: "Cancelar",
            reverseButtons: true,
        }).then((result) => {
            if (!result.isConfirmed){
                cancel = true;
            }
        });

        if (cancel) {
            return
        }
    }

    owner.transform((data) => {
        return {
            ...data,
            ...car,
        }
    }).post('register/owner', {
        onSuccess: Swal.fire({
            icon: "success",
            title: "Sucesso!",
            text: "Proprietário registrado com sucesso",
        })
    });
}


</script>

<template>
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-fullscreen-lg-down">
            <form @submit.prevent="sendData()" class="modal-content">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="staticBackdropLabel">Novo Proprietário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body d-flex modal-body d-flex  align-self-sm-center p-5">


                    <!--Dados Proprietário-->
                    <div class="area-info">
                        <h2>Dados Proprietário</h2>
                        <label for="name">Nome Completo</label>
                        <input v-model="owner.name" type="text" name="name" id="name">

                        <label for="birth">Data de nascimento</label>
                        <input v-model="owner.birth" type="date" name="birth" id="birth">

                        <label for="gender">Gênero</label>
                        <select v-model="owner.gender" id="gender" class="" >
                            <option :value="null" disabled>Escolha uma opção</option>
                            <option value="1">Homem</option>
                            <option value="2">Mulher</option>
                        </select>
                    </div>

                    <!--Dados Carro-->
                    <SecondaryButton
                        v-if="!owner.addCar"
                        @click="owner.addCar = !owner.addCar"
                        style="height: fit-content"
                        class="align-self-center justify-self-center">
                    Adicionar Carro</SecondaryButton>

                    <div class="area-info" v-if="owner.addCar">
                        <h2>Dados Carro</h2>
                        <label for="frab">Marca</label>
                        <input v-model="car.fabric" type="text" name="frab" id="frab">

                        <label for="model">Modelo</label>
                        <input v-model="carros" type="text" name="model" id="model">

                        <label for="year">Ano</label>
                        <input v-model="car.year" type="text" name="year" id="year">

                        <SecondaryButton
                            v-if="owner.addCar"
                            @click="owner.addCar = !owner.addCar"
                            style="height: fit-content"
                            class="align-self-center mt-6">
                            Fechar</SecondaryButton>
                    </div>


                </div>
                <div class="modal-footer">
                    <PrimaryButton>Salvar</PrimaryButton>
                    <SecondaryButton data-bs-dismiss="modal" @click="clear()">Cancelar</SecondaryButton>
                </div>
            </div>
            </form>
        </div>
    </div>

</template>

<style scoped>
.modal-header {
    background-color: #FF9F47;
    color: white;
    font-weight: bolder;
}

.area-info {
    display: flex;
    flex-direction: column;
    width: 300px;
}

.modal-body {
    justify-content: space-around;
    width: 100%;
}

@media screen and (max-width: 770px) {
    .modal-body {
        flex-direction: column;
        overflow-x: hidden;
        align-items: center;
    }

    .area-info {
        margin-bottom: 60px;
    }
}




input, select{
    border-radius: 11px;
    border: 2px solid #FF9F47;
}

option {
    color: #FF9F47;
}

</style>
