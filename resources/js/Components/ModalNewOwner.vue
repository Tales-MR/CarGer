<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { useForm } from '@inertiajs/vue3';



let owner = useForm({
    name: '',
    birth: '',
    gender: null
});

let car = useForm({
    frab: '',
    model: '',
    year: null,
});

let clear = function (){
    owner.name = '';
    owner.birth = '';
    owner.gender = null;
};
let sendData = function (){
    owner.transform((data) => {
        return {
            ...data,
            ...car,
        }
    }).post('Register/Owner');
}


</script>

<template>
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
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
                    <div class="area-info">
                        <h2>Dados Carro</h2>
                        <label for="frab">Marca</label>
                        <input v-model="car.frab" type="text" name="frab" id="frab">

                        <label for="model">Modelo</label>
                        <input v-model="car.model" type="text" name="model" id="model">

                        <label for="year">Ano</label>
                        <input v-model="car.year" type="text" name="year" id="year">
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

@media screen and (min-width: 770px) {
    .modal-body {
        flex-direction: row;
        justify-content: space-around;
        width: 100%;
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
