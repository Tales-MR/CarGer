<script setup>
import SecondaryButton from "@/Components/SecondaryButton.vue";
import IconCheck from "@/Components/Layout/IconCheck.vue";
import IconTrash from "@/Components/Layout/IconTrash.vue";
import { useForm } from "@inertiajs/vue3";


//Dados que ou serão usados no carList, ou serão descartados
let carInfoTemp = useForm({
    index: '',
    fabric: '',
    model: '',
    year: '',
    show: false,
});

//Dados que serão enviado para o bd
const carList = useForm({
    index: [],
    fabric: [],
    model: [],
    year: []
});

//Limpar os campos da temp
let clear = function () {
    carInfoTemp.reset();
    carInfoTemp.show = false;
}

//Passar os dados da temp pra list
let addCar = function (index) {
    carList.index.push(index)
    carList.fabric.push(carInfoTemp.fabric);
    carList.model.push(carInfoTemp.model);
    carList.year.push(carInfoTemp.year);

    clear();
    emits('updateCarList', props.carList);
};

//Remover um carro já na lista
const removeCar = () => {
    carList.index.splice(index, 1);
    carList.fabric.splice(index, 1);
    carList.model.splice(index, 1);
    carList.year.splice(index, 1);
};
</script>

<template>
    <!-- Dados Carro -->
    <div class="car d-flex flex-column align-items-center justify-content-center">
        <div class="area-info area-car" v-if="carInfoTemp.show">

            <h2 class="align-self-center">Dados Carro</h2>
                <label for="fabric">Marca</label>
                <input v-model="carInfoTemp.fabric" type="text" :name="'fabric' + index" :id="'fabric' + index">

                <label for="model">Modelo</label>
                <input v-model="carInfoTemp.model" type="text" :name="'model' + index" :id="'model' + index">

                <label for="year">Ano</label>
                <input v-model="carInfoTemp.year" type="text" :name="'year' + index" :id="'year' + index">

                <div class="buttons d-flex justify-around">
                    <SecondaryButton @click="clear()" style="height: fit-content" class="align-self-center mt-6">
                        <IconTrash/>
                    </SecondaryButton>
                    <SecondaryButton @click="addCar(carList.index.indexOf(-1))" style="height: fit-content" class="align-self-center mt-6">
                        <IconCheck/>
                    </SecondaryButton>
                </div>
        </div>

        <SecondaryButton
            @click="carInfoTemp.show = true" style="height: fit-content"
            v-if="!carInfoTemp.show"
            class="align-self-center justify-self-center">

            Adicionar Carro

        </SecondaryButton>
        <slot/>
    </div>
</template>

<style scoped>
.area-car {
    background-color: #ffe8d4;
    border-radius: 11px;
}

.area-info {
    display: flex;
    flex-direction: column;
    width: 300px;
    padding: 10px;
    margin: 5px;
}

input {
    border-radius: 11px;
    border: 2px solid #FF9F47;
}

input:focus {
    border-radius: 11px;
    border: 2px solid #FF9F47;
    box-shadow: none;
}
</style>


