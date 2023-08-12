<script setup>
    defineProps({
        modelValue: String,
        placeholderText: {
            required: false,
            type: String,
            default: 'Yorumunuzu Düzenleyin'
        }
    })

    const emit = defineEmits(['closeEditComment', 'updateComment', 'update:modelValue'])
</script>

<template>
<div class="my-5">
    <textarea @input="emit('update:modelValue', $event.target.value)"
              :value="modelValue"
              rows="4"
              class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
              :placeholder="placeholderText">
    </textarea>
    <div class="flex justify-end mt-2.5">
        <div class="flex-shrink-0">
            <button @click="emit('closeEditComment')"
                    type="submit"
                    class="me-2 inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-2.5 py-2 text-xs font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                İptal Et
            </button>
            <button @click.prevent="emit('updateComment')"
                    type="button"
                    class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-2.5 py-2 text-xs font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Düzenle
            </button>
        </div>
    </div>
</div>
</template>

<style scoped>

</style>
