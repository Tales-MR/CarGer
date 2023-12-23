<script setup>
import {usePage} from "@inertiajs/vue3";

let page = usePage();
</script>

<template>
    <slot/>
</template>

<style lang="scss">
@import "../../../sass/app.scss";
</style>

<style>
main {
    display: grid;
    align-content: center;
    justify-content: center;

    width: 100vw;
    height: 100vh;
}
</style>


