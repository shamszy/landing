<template>
    <teleport to="body">
        <div
            v-show="props.show"
            ref="modal-backdrop"
            class="fixed z-10 inset-0 overflow-y-auto bg-black bg-opacity-50"
        >
            <div
                class="flex items-start justify-center min-h-screen pt-24 text-center"
            >
                <div
                    class="bg-white rounded-lg text-left overflow-hidden shadow-xl p-8 w-1/2 flex justify-between items-start gap-2"
                    role="dialog"
                    ref="modal"
                    aria-modal="true"
                    aria-labelledby="modal-headline"
                >
                    <div class=" w-full ">
                        <slot></slot>
                    </div>
                </div>
            </div>
        </div>
    </teleport>
</template>

<script setup>
import { ref, provide, inject } from "vue";

const visible = ref(false);
// const { show } = defineProps(['show']);
const props = defineProps(["show"]);


console.log(props.show);

const openModal = () => {
    visible.value = true;
};

const closeModal = () => {
    visible.value = false;
};

// provide('openModal', openModal);
// provide('closeModal', closeModal);
</script>

<style scoped>
/* Modal styles go here */
</style>
