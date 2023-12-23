<template>
    <button
        class="inline-flex btn items-center px-4 py-2 border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 transition ease-in-out duration-150"
    >
        <slot />
    </button>
</template>

<style scoped>
.btn {
    background-color: #FF9F47;
    border: none;
}

.btn:hover {
    background-color: #ffbd6d;
}
</style>
