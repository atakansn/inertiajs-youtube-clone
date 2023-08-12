<script setup>

    import AuthenticationCard from "@Components/AuthenticationCard.vue";
    import {useForm} from "@inertiajs/vue3";
    import Logo from "@Components/Logo.vue";

    const props = defineProps({
        email: String,
        token: String,
    })

    const resetForm = useForm({
        token: props.token,
        email: props.email,
        password: '',
        password_confirmation: ''
    })

    const sendResetPassword = () => resetForm.post('/reset-password',{
        onFinish: () => resetForm.reset('password','password_confirmation')
    })

</script>

<template>
<AuthenticationCard head-title="Parolamı Sıfırlama Bağlantısı Gönder">
    <template #logo>
        <Logo class="w-28 h-28 mx-auto"/>
    </template>

    <form class="space-y-6" @submit.prevent="sendResetPassword">
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">E-posta</label>
            <div class="relative mt-1">
                <input v-model="resetForm.email"
                       :class="{'border-red-300 pr-10 text-red-900 placeholder-red-300 focus:border-red-500 focus:outline-none focus:ring-red-500': resetForm.errors.email}"
                       id="email"
                       type="email"
                       autocomplete="email"
                       required
                       class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-zinc-500 focus:outline-none focus:ring-zinc-500 md:text-md ">
                <div v-if="resetForm.errors.email" class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                    <!-- Heroicon name: mini/exclamation-circle -->
                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
            <p v-if="resetForm.errors.email" class="mt-2 text-sm text-red-600">{{resetForm.errors.email}}</p>
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Yeni Parola</label>
            <div class="relative mt-1">
                <input v-model="resetForm.password"
                       :class="{'border-red-300 pr-10 text-red-900 placeholder-red-300 focus:border-red-500 focus:outline-none focus:ring-red-500': resetForm.errors.password}"
                       id="password"
                       name="password"
                       type="password"
                       autocomplete="password"
                       required
                       class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-zinc-500 focus:outline-none focus:ring-zinc-500 md:text-md">
                <div v-if="resetForm.errors.password" class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                    <!-- Heroicon name: mini/exclamation-circle -->
                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
            <p v-if="resetForm.errors.password" class="mt-2 text-sm text-red-600">{{resetForm.errors.password}}</p>
        </div>

        <div>
            <label for="password-confirmation" class="block text-sm font-medium text-gray-700">Yeni Parola Tekrarı</label>
            <div class="relative mt-1">
                <input v-model="resetForm.password_confirmation"
                       id="password-confirmation"
                       name="password-confirmation"
                       type="password"
                       autocomplete="password-confirmation"
                       required
                       class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-zinc-500 focus:outline-none focus:ring-zinc-500 md:text-md">
            </div>
        </div>

        <div>
            <button :disabled="resetForm.processing"
                    :class="{'opacity-75': resetForm.processing}"
                    type="submit"
                    class="flex w-full justify-center rounded-md border border-transparent bg-zinc-700 py-2 px-4 text-md font-medium text-white shadow-sm hover:bg-zinc-600 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:ring-offset-2">
                Parolayı Sıfırla
            </button>
        </div>
    </form>

</AuthenticationCard>
</template>

<style scoped>

</style>
