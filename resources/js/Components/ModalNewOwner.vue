<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {useForm} from '@inertiajs/vue3';
import  Swal  from "sweetalert2";
import axios from "axios";

let owner = useForm({
    name: 'Tales',
    birth: '2004-12-13',
    gender: 1,
});

let clear = function (){
    owner.reset();
};

let sendData = async function (){

    const response = (await axios.post('/register/validate/owner', {
        name: owner.name,
        birth: owner.birth,
    })).data;

    if (response.code !== 1){
        let cancel = false;

        await Swal.fire({ //PopUp
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
            return;
        }
    }

    owner.post('register/owner', {
        onSuccess: () => {
                Swal.fire({ //PopUp
                icon: "success",
                title: "Sucesso!",
                text: "Proprietário registrado com sucesso"
                });
            }
        })
}


</script>

<template>
    <!-- Modal -->
    <div class="modal" id="newOwner" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="newOwner" aria-hidden="true">
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
                            <h2 class="align-self-center">Dados Proprietário</h2>
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
