<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {useForm, usePage} from '@inertiajs/vue3';
import  Swal  from "sweetalert2";
import axios from "axios";
import {useGlobalStore} from "@/Stores/globalStore.js";

const globalStore = useGlobalStore();

const page = usePage();

let car = useForm({
    id_owner: page.props.owner[0].id_owner,
    model: '',
    fabric: '',
    year: '',
});

let clear = function (){
    car.reset();
};





let sendDataStageOne = async function () {
    console.log('1');

    globalStore.response = (await axios.post('../../register/validate/ownerCar/one', {
        model: car.model,
        fabric: car.fabric,
    })).data;

    await sendDataStageTwo();
}



let sendDataStageTwo = async function (){
    console.log('2');

    if (globalStore.response.code === 1) { //Fabricante não existe
        let cancel = false;

        await Swal.fire({ //PopUp
            icon: "warning",
            title: "Fabricante Inexistente!",
            text: globalStore.response.message,
            showCancelButton: true,
            confirmButtonText: "Confirmar",
            cancelButtonText: "Cancelar",
            reverseButtons: true,
        }).then((result) => {
                if (!result.isConfirmed) {
                    cancel = true;
                }
            }
        )

        if (cancel) {
            return;
        }

        globalStore.response = (await axios.post('../../register/validate/ownerCar/two', {
            model: car.model,
            fabric: car.fabric,
        })).data; //Next stage
    }

    await sendDataStageThree();
}

let sendDataStageThree = async function () {
    console.log('3');

    if (globalStore.response.code === 2) { //Stage Three
        //Fabrica criada ou já existente -> Modelo

        globalStore.response = (await axios.post('../../register/validate/ownerCar/three', {
            model: car.model,
            id_fabric: globalStore.response.id_fabric,
        })).data;
    }

    await sendDataStageFour();
}


let sendDataStageFour = async function () {
    console.log('4');

    if (globalStore.response.code === 3) {
        //Modelo criado -> Verificar se o owner já possui o carro

        globalStore.response = (await axios.post('../../register/validate/ownerCar/four', {
            id_model: globalStore.response.id_model,
            id_owner: car.id_owner,
            year: car.year,
        })).data;
    }

    if (globalStore.response.code === 96) {
        //Modelo em mais de uma fábrica
        let cancel = false;

        await Swal.fire({ //PopUp
            icon: "warning",
            title: "Modelo duplicado!",
            text: globalStore.response.message,
            showCancelButton: true,
            confirmButtonText: "Confirmar",
            cancelButtonText: "Cancelar",
            reverseButtons: true,
        }).then((result) => {
            if (!result.isConfirmed) {
                cancel = true;
            }
        })

        if (cancel) {
            return;
        }

        globalStore.response = (await axios.post('../../register/validate/ownerCar/four', {
            id_model: globalStore.response.id_model,
            id_owner: car.id_owner,
            year:     car.year,
        })).data;
    }

    await sendDataStageFive();
}



let sendDataStageFive = async function () {
    console.log('5');

    if (globalStore.response.code === 4) {
        //Carro duplicado

        let cancel = false;

        await Swal.fire({ //PopUp
            icon: "warning",
            title: "Carro duplicado!",
            text: globalStore.response.message,
            showCancelButton: true,
            confirmButtonText: "Confirmar",
            cancelButtonText: "Cancelar",
            reverseButtons: true,
        }).then((result) => {
            if (!result.isConfirmed) {
                cancel = true;
            }
        })

        if (cancel) {
            return
        }


        globalStore.response = (await axios.post('../../register/validate/ownerCar/store', {
            id_model: globalStore.response.id_model,
            id_owner: globalStore.response.id_owner,
            year: globalStore.response.year,
        })).data;
    }

    if (globalStore.response.code === 5) {

        globalStore.response = (await axios.post('../../register/validate/ownerCar/store', {
            id_model: globalStore.response.id_model,
            id_owner: globalStore.response.id_owner,
            year: globalStore.response.year,
        })).data;
    }

    await sendDataStageStore()
}

let sendDataStageStore = async function () {
    console.log('6');

    if (globalStore.response.code === 10) {
        await Swal.fire({ //PopUp
            icon: "success",
            title: "Carro cadastrado!",
            text: globalStore.response.message,
        });
    }
}


</script>

<template>
    <!-- Modal -->
    <div class="modal" id="newOwnerCar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="newOwnerCar" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-fullscreen-lg-down animate__animated animate__bounceIn">
            <form @submit.prevent="sendDataStageOne()">
                <div class="modal-content">
                    <div class="modal-header">

                        <h5 class="modal-title" id="staticBackdropLabel">Novo Proprietário</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                    </div>
                    <div class="modal-body d-flex align-self-sm-center p-5">


                        <!--Dados Proprietário-->
                        <div class="area-info">
                            <h2 class="align-self-center">Dados do Carro</h2>
                            <label for="fabric">Fabricante</label>
                            <input v-model="car.fabric" type="text" name="fabric" id="fabric">

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
.animate__animated.animate__bounceIn {
    --animate-duration: 0.7s;
}


.modal-header {
    background-color: #FF9F47;
    color: white;
    font-weight: bolder;
}

.area-info {
    display: flex;
    flex-direction: column;
    width: 300px;
    padding: 10px;
    margin: 5px;
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

input:focus, select:focus {
    border-radius: 11px;
    border: 2px solid #FF9F47;
    box-shadow: none;
}

option {
    color: #FF9F47;
}

.btn-close:focus {
    border: none;
    outline: none;
    box-shadow: none;
}

</style>
