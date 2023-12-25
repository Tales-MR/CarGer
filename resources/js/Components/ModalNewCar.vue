<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {useForm, usePage} from '@inertiajs/vue3';
import  Swal  from "sweetalert2";
import axios from "axios";



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

let sendData = async function (){
    const response = (await axios.post('../../register/validate/ownerCar', {
        id_owner: car.id_owner,
        model: car.model,
        fabric: car.fabric,
        year: car.year,
    })).data;

    if (response.code === 0){
        let cancel = false;

        await Swal.fire({ //PopUp
            icon: "warning",
            title: "Dados duplicados",
            text: response.message,
            showCancelButton: true,
            confirmButtonText: "Confirmar",
            cancelButtonText: "Cancelar",
            reverseButtons: true,
        }).then((result) => {
            if (!result.isConfirmed) {
                cancel = true;
            }}
        )

        if (cancel) {
            return;
        }

        car.post('../../register/owner/ownerCar', {
            onSuccess: () => {
                Swal.fire({ //PopUp
                    icon: "success",
                    title: "Sucesso!",
                    text: "Carro registrado com sucesso!"
                })
            }
        })
    } else if (response.code === 1) {
        let cancel = false;

        await Swal.fire({ //PopUp
            icon: "warning",
            title: "Fabricante inexistente!",
            text: response.message,
            showCancelButton: true,
            confirmButtonText: "Confirmar",
            cancelButtonText: "Cancelar",
            reverseButtons: true,
        }).then((result) => {
            if (!result.isConfirmed) {
                cancel = true;
            }}
        )

        if (cancel) {
            return;
        }

        car.post('/register/owner/validateStoreFabMod', {
            onSuccess: () => {
                Swal.fire({ //PopUp
                    icon: "success",
                    title: "Sucesso!",
                    text: "Carro registrado com sucesso!"
                })
            }});
    } else if (response.code === 2) {
        car.post('../../register/owner/ownerCar', {
            onSuccess: () => {
                Swal.fire({ //PopUp
                    icon: "success",
                    title: "Sucesso!",
                    text: "Carro registrado com sucesso!"
                })
            }});
    }


}


</script>

<template>
    <!-- Modal -->
    <div class="modal" id="newOwnerCar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="newOwnerCar" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-fullscreen-lg-down animate__animated animate__bounceIn">
            <form @submit.prevent="sendData()">
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
