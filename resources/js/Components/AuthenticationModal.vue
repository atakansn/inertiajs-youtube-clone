<script setup>
    import {nextTick, onMounted, onUnmounted, ref, watchEffect} from "vue";
    import {useForm, Link} from "@inertiajs/vue3";

    const props = defineProps({
        visibleable: {
            type: Boolean,
            default: false
        }
    })

    const visible = ref()
    const emailInput = ref(null)

    watchEffect(() => {
        visible.value = props.visibleable

        visible.value
            ? document.body.style.overflow = 'hidden'
            : document.body.style.overflow = 'visible'
    })

    const emits = defineEmits(['close'])

    const loginForm = useForm({
        email: '',
        password: '',
        remember: false
    })

    const onLogin = () => {
        return loginForm.post('/login', {
            onSuccess: () => {
                loginForm.reset()
                visible.value = false
            }
        })
    }
    

    onMounted(() => {
        nextTick(() => emailInput.value?.focus())
    })
    

</script>

<template>
<div v-if="visible"
     class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">

    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
                <div class="absolute top-0 right-0 hidden pt-4 pr-4 sm:block">
                    <button @click="emits('close')"
                            type="button"
                            class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        <span class="sr-only">Kapat</span>
                        <!-- Heroicon name: outline/x-mark -->
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div class="flex min-h-full flex-col justify-center">
                    <div class="sm:mx-auto sm:w-full sm:max-w-md">
                        <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">Hesabınıza giriş
                            yapın</h2>
                        <p class="mt-2 text-center text-sm text-gray-600">
                            Ya da
                            <Link :href="route('register')" class="font-medium text-gray-900 hover:text-gray-600">kayıt
                                olun ?
                            </Link>
                        </p>
                    </div>

                    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
                        <div>
                            <form @submit.prevent="onLogin" class="space-y-6">
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">E-posta
                                        adresi</label>
                                    <div class="mt-1">
                                        <input ref="emailInput"
                                               v-model="loginForm.email"
                                               id="email"
                                               type="email"
                                               required
                                               class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                        <p v-if="loginForm.errors.email" class="mt-1 text-sm text-red-600">
                                            {{ loginForm.errors.email }}</p>
                                    </div>
                                </div>

                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700">Parola</label>
                                    <div class="mt-1">
                                        <input v-model="loginForm.password"
                                               id="password"
                                               type="password"
                                               required
                                               class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                        <p v-if="loginForm.errors.password" class="mt-1 text-sm text-red-600">
                                            {{ loginForm.errors.password }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <input v-model="loginForm.remember" id="remember-me" name="remember-me"
                                               type="checkbox"
                                               class="h-4 w-4 rounded border-gray-300 text-gray-600 focus:ring-gray-500">
                                        <label for="remember-me" class="ml-2 block text-sm text-gray-900">Beni
                                            hatırla</label>
                                    </div>

                                    <div class="text-sm">
                                        <Link :href="route('password.request')"
                                              class="font-medium text-gray-600 hover:text-gray-500">
                                            Parolanızı mı unuttunuz?
                                        </Link>
                                    </div>
                                </div>

                                <div>
                                    <button type="submit"
                                            class="flex w-full justify-center rounded-md border border-transparent bg-gray-800 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                        Giriş Yap
                                    </button>
                                </div>
                            </form>
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
