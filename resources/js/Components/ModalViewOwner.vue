<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

defineProps({
    name: {
        type: String,
        required: true,
    },
    birth: {
        type: Date,
        required: true,
    },
    gender: {
        type: Number,
        required: true,
    },
});

</script>

<template>
    <!-- Modal -->
    <div class="modal" id="viewOwner" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="viewOwner" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen animate__animated animate__fadeIn ">
            <form @submit.prevent="">
                <div class="modal-content vh-100">
                    <div class="modal-header">

                        <h5 class="modal-title" id="staticBackdropLabel">Visualizar Proprietário</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                    </div>
                    <div class="modal-body d-flex align-self-sm-center p-5">
                        <div class="area-info">
                            <h2 class="align-self-center">Dados do Proprietário</h2>
                            <label for="name">Nome</label>
                            <input type="text" name="name" id="name" :value="name">

                            <label for="birth">Data de nascimento</label>
                            <input type="date" name="birth" id="birth" :value="birth">

                            <label for="gender">Gênero</label>
                            <select id="gender" class="" :value="gender">
                                <option :value="null" disabled>Escolha uma opção</option>
                                <option value="1">Homem</option>
                                <option value="2">Mulher</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <PrimaryButton>Editar</PrimaryButton>
                        <SecondaryButton data-bs-dismiss="modal">Fechar</SecondaryButton>
                    </div>
                </div>
            </form>
        </div>
    </div>

</template>

<style scoped>
.animate__animated.animate__fadeIn {
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

.modal-dialog {
    height: 100vh;
}
</style>

