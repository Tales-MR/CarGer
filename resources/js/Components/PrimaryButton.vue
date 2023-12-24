<template>
    <button
        class="block btn items-center px-4 py-2 border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition ease-in-out duration-150"
    >
        <slot />
    </button>
</template>

<style scoped>
.btn {
    background-color: #FF9F47;
    border: none;
    width: fit-content;
    justify-self: center;
}

.btn:hover {
    background-color: #ffbd6d;
}
</style>
