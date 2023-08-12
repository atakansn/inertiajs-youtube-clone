<script setup>
    import GuestLayout from "@/Layouts/GuestLayout.vue";
    import {Link, useForm} from "@inertiajs/vue3";
    import AuthenticationCard from "@Components/AuthenticationCard.vue";
    import Logo from "@Components/Logo.vue";

    const resetPasswordForm = useForm({
        email: ''
    })

    const sendResetPassword = () => {
        resetPasswordForm.post('/forgot-password')
    }
</script>

<template>
<AuthenticationCard head-title="Parolamı Sıfırla">
    <template #logo>
        <Logo/>

        <div class="text-md font-normal text-center mt-5 text-gray-500">
            Lütfen hesabınıza ait e-posta adresinizi girin. Şifre sıfırlama bağlantısı e-posta adresinize gönderilecektir.
        </div>
    </template>

    <form class="space-y-6" @submit.prevent="sendResetPassword">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">E-posta Adresi</label>
                <div class="relative mt-1">
                    <input v-model="resetPasswordForm.email"
                           :class="{'border-red-600': resetPasswordForm.errors.email}"
                           id="email"
                           type="email"
                           autocomplete="email"
                           required
                           class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-zinc-500 focus:outline-none focus:ring-zinc-500 md:text-md">
                    <div v-if="resetPasswordForm.errors.email"
                         class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                        <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                             fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                <p v-if="resetPasswordForm.errors.email" class="mt-2 text-sm text-red-600">{{ resetPasswordForm.errors.email }}</p>
            </div>

            <div>
                <button :disabled="resetPasswordForm.processing"
                        :class="{'opacity-75': resetPasswordForm.processing}"
                        type="submit"
                        class="flex w-full uppercase justify-center rounded-md border border-transparent bg-gray-800 py-2 px-4 text-md font-medium text-white shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-cyan-700 focus:ring-offset-2">
                    Sıfırlama Bağlantısını Gönder
                </button>
            </div>
        </form>

</AuthenticationCard>
</template>

<style scoped>

</style>
