import { defineStore } from "pinia";

export const useGlobalStore = defineStore("global", {
    state: () => {
        return {
            isShowingSideBar: false,
            gender: {
              '1': 'Homem',
              '2': 'Mulher'
            },
            currentOwner: '',

        };
    }
});
