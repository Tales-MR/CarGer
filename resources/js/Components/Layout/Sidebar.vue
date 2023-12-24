<script setup>
import {ref} from "vue";
import { usePage } from "@inertiajs/vue3";
import {Link} from "@inertiajs/vue3";
import {useGlobalStore} from "@/Stores/globalStore.js";

const globalStore = useGlobalStore();

const page = usePage();

let isShowingSideBar = ref(false);
const chooseLink = () => {
    isShowingSideBar = false;
}
</script>

<template>
    <Transition name="slide">
        <nav id="menu_lateral" class="menu_lateral expandir" v-if="globalStore.isShowingSideBar" >
            <div id="wrap-menu-bar">
                <span class="fs-2 text-white">CarGer</span>
                <button id="closeMenuBtn" @click="globalStore.isShowingSideBar = !globalStore.isShowingSideBar" class="reset-button fs-1 text-white">
                    00
                </button>
            </div>

            <ul class="lista_links_redirecionamento">
                <li class="elemento_menu">
                    <Link @click="chooseLink" href="/" class="Link_de_Redirecionamento">
                        <span class="link_de_texto">Proprietários</span>
                    </Link>
                </li>
                <li class="elemento_menu">
                    <Link @click="chooseLink" href="/view/fabrics" class="Link_de_Redirecionamento">
                        <span class="link_de_texto">Fabricantes</span>
                    </Link>
                </li>
                <li class="elemento_menu">
                    <Link @click="chooseLink" href="user.funcao !== 0 ? route('admin.newReq') : route('aluno.newReq')" class="Link_de_Redirecionamento">
                        <span class="link_de_texto">Gráficos</span>
                    </Link>
                </li>
            </ul>
        </nav>
    </Transition>
</template>

<style>
nav.menu_lateral {
    height: 100%;
    background-color: #FF9F47;
    position: fixed;
    z-index: 1000;
    box-shadow: 3px 0 5px rgba(0, 0, 0, 0.25);
}

nav.menu_lateral.expandir {
    width: 200px;
}

.lista_links_redirecionamento{
    margin-top: 20px;
    list-style-type: none;
    padding: 0;
}

ul li.elemento_menu a{
    color: white;
    text-decoration: none;
    font-size: 20px;
    display: flex;
    line-height: 30px;
    font-weight: bold;
    margin: 5px 0;
}

ul li.elemento_menu button{
    color: white;
    text-decoration: none;
    font-size: 20px;
    display: flex;
    line-height: 30px;
    font-weight: bold;
    margin: 5px 0;
}

ul li.elemento_menu{
    transition: 0.6s;
    border-bottom: 1px #b6b5b5 solid;
    padding: 0 15px;
}

ul li.elemento_menu:hover{
    background-color: #FF9F47;
}

.slide-enter-active {
    transition: all 0.4s ease-out;
}

.slide-leave-active {
    transition: all 0.4s ease-out;
}

.slide-enter-from,
.slide-leave-to {
    transform: translateX(-300px);
}

#wrap-menu-bar{
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 2px white solid;
    padding: 15px 15px;
}

#wrap-menu-bar p {
    font-weight: bold;
}

#closeMenuBtn:hover{
    transform: scale(1.20);
    transition: transform 0.2s ease-out;
}
</style>
