<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {useForm, usePage} from '@inertiajs/vue3';
import  Swal  from "sweetalert2";
import axios from "axios";
import {ref} from "vue";

const page = usePage();

let fabric = useForm({
    name: ''
});

const clear = function () {
    fabric.reset();
}

let sendData = async function (){
    const response = (await axios.post('/register/validate/fabric', {
        name: fabric.name
    })).data;

    if (response.code !== 1){
        let cancel = false;

        await Swal.fire({ //PopUp
            icon: "warning",
            title: "Fabricante existente!",
            text: response.message,
        }).then((result) => {
            if (!result.dismiss){
                cancel = true;
            }
        });

        if (cancel) {
            return;
        }
    }

    fabric.post('/register/fabric', {
        onSuccess: () => {
            Swal.fire({ //PopUp
                icon: "success",
                title: "Sucesso!",
                text: "Fabricante registrado com sucesso!"
            })
        }})
}


</script>

<template>
    <!-- Modal -->
    <div class="modal" id="newFabric" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="newFabric" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-fullscreen-lg-down animate__animated animate__bounceIn">
            <form @submit.prevent="sendData()">
                <div class="modal-content">
                    <div class="modal-header">

                        <h5 class="modal-title" id="staticBackdropLabel">Novo Fabricante</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                    </div>
                    <div class="modal-body d-flex align-self-sm-center p-5">


                        <!--Dados Proprietário-->
                        <div class="area-info">
                            <h2 class="align-self-center">Fabricante</h2>
                            <label for="fabric">Nome</label>
                            <input v-model="fabric.name" type="text" name="fabric" id="fabric">
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
