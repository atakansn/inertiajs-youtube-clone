<script setup>
    import {watchEffect} from "vue";

    const props = defineProps({
        visibleable: {
            required: true,
            type: Boolean
        }
    })

    const emit = defineEmits(['close'])

    watchEffect(() => {
        props.visibleable
            ? document.body.style.overflow = 'hidden'
            : document.body.style.overflow = 'visible'
    })
</script>

<template>
<div v-if="visibleable"
     class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">

    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                <div class="absolute top-0 right-0 hidden pt-4 pr-4 sm:block">
                    <button @click="emit('close')"
                            type="button"
                            class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <span class="sr-only">Kapat</span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <!-- Heroicon name: outline/exclamation-triangle -->
                        <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Sunucu kaynaklı bir
                            hata oluştu !</h3>
                        <div class="mt-2">
                            <p class="text-md text-gray-600">
                                <strong>Hata:</strong> Sunucudan yanıt alınamadı. Lütfen daha sonra tekrar deneyin veya
                                bağlantınızı kontrol edin. Sorun devam ederse, destek ekibimizle iletişime geçin
                                <strong>(destek@ornekuygulama.com)</strong>. Hata düzelirse veya daha fazla yardıma
                                ihtiyacınız olursa, bu pencereyi her zaman kapatabilirsiniz.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</template>

<style scoped>

</style>