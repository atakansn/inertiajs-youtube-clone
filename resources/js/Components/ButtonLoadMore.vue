<script setup>
    import LoadingSpinner from "./LoadingSpinner.vue";

    defineProps({
        showSpinner: {
            type: Boolean,
            default: () => false
        },
        spinnerClass: {
            required: false,
            type: String
        }
    })

    const emits = defineEmits(['loadMore'])
</script>

<template>
<div>
    <LoadingSpinner v-if="showSpinner"
                    :spinner-class="spinnerClass"/>

    <button v-else
            @click.prevent="emits('loadMore')" type="button"
            class="inline-flex items-center rounded-md border border-transparent px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
        Daha Fazla Yükle
    </button>
</div>
</template>

<style scoped>

</style>
