<script setup>
    import {Link, useForm} from "@inertiajs/vue3";
    import AuthenticationCard from "@Components/AuthenticationCard.vue";
    import Logo from "@Components/Logo.vue";

    const loginForm = useForm({
        email: '',
        password: '',
        remember: false,
    })

    const onLogin = () => {
        loginForm.post('login',{
            onSuccess: () => loginForm.reset()
        })
    }
</script>

<template>
<AuthenticationCard head-title="Giriş">
    <template #logo>
        <Logo/>
    </template>

    <form class="space-y-6" @submit.prevent="onLogin">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">E-posta Adresi</label>
                <div class="relative mt-1">
                    <input v-model="loginForm.email"
                           :class="{'border-red-600': loginForm.errors.email}"
                           id="email"
                           type="email"
                           autocomplete="email"
                           required
                           class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-zinc-500 focus:outline-none focus:ring-zinc-500 md:text-md">
                    <div v-if="loginForm.errors.email"
                         class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                        <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                             fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                <p v-if="loginForm.errors.email" class="mt-2 text-sm text-red-600">{{ loginForm.errors.email }}</p>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Parola</label>
                <div class="mt-1">
                    <input v-model="loginForm.password"
                           id="password"
                           type="password"
                           autocomplete="current-password"
                           required
                           class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-zinc-500 focus:outline-none focus:ring-zinc-500 md:text-md">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input v-model="loginForm.remember"
                           id="remember-me"
                           type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-neutral-700 focus:ring-neutral-400">
                    <label for="remember-me" class="ml-2 block text-md text-gray-900">Beni Hatırla</label>
                </div>

                <div class="text-md">
                    <Link href="/forgot-password" class="font-medium text-black hover:text-gray-700">Parolanızı mı unuttunuz?</Link>
                </div>
            </div>

            <div>
                <button :disabled="loginForm.processing"
                        :class="{'opacity-75': loginForm.processing}"
                        type="submit"
                        class="flex w-full justify-center rounded-md border border-transparent bg-cyan-800 py-2 px-4 text-md font-medium text-white shadow-sm hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-700 focus:ring-offset-2">
                    Giriş Yap
                </button>
            </div>
    </form>

    <template #outOfTheCard>
        <p class="mt-8 text-center text-sm text-gray-700">
            Kayıtlı değil misiniz? Hemen
            <Link href="/register" class="font-medium text-indigo-600 hover:text-indigo-500">Kanalınızı oluşturun</Link>
        </p>
    </template>
</AuthenticationCard>
</template>

<style scoped>

</style>
