<script setup>
import {usePage} from "@inertiajs/vue3";
import Sidebar from "@/Components/Layout/Sidebar.vue";
import {useGlobalStore} from "@/Stores/globalStore.js";

const globalStore = useGlobalStore();

let page = usePage();
</script>

<template>
    <main>
        <div class="wrap-info-header mb-3 position-absolute">
            <button v-if="page.props.auth.user"
                    @click="globalStore.isShowingSideBar = ! globalStore.isShowingSideBar"
                    class="reset-button mr-3">
                MENU
            </button>
        </div>

        <Sidebar></Sidebar>
        <slot/>


    </main>

</template>

<style lang="scss">
@import "../../../sass/app.scss";
</style>

<style>
html, body{
    width: 100vw;
    height: 100vh;
}

main {
    display: grid;
    align-content: center;
    justify-content: center;

    height: 100%;
    width: 100%;
}
</style>


