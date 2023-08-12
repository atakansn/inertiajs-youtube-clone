<script setup>
    import GuestLayout from "../../Layouts/GuestLayout.vue";
    import {useForm, Link} from "@inertiajs/vue3";
    import AuthenticationCard from "@Components/AuthenticationCard.vue";
    import Logo from "@Components/Logo.vue";

    const form = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
    })

    const onRegister = () => {
        return form.post(route('register'),{
            onSuccess: () => form.reset()
        })
    }

</script>

<template>
<AuthenticationCard head-title="Kayıt Ol">
    <template #logo>
        <Logo/>
    </template>

    <form class="space-y-6" @submit.prevent="onRegister">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">İsim</label>
                <div class="relative mt-1">
                    <!-- Error Class border-red-300 pr-10 text-red-900 placeholder-red-300 focus:border-red-500 focus:outline-none focus:ring-red-500 --->
                    <input v-model="form.name" id="name" name="name" type="text" autocomplete="name" required
                           class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-zinc-500 focus:outline-none focus:ring-zinc-500 md:text-md ">
                    <div v-if="form.errors.name" class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                        <!-- Heroicon name: mini/exclamation-circle -->
                        <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                <p v-if="form.errors.name" class="mt-2 text-sm text-red-600">{{form.errors.name}}</p>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">E-posta Adresi</label>
                <div class="relative mt-1">
                    <input v-model="form.email" id="email" name="email" type="email" autocomplete="email" required
                           class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-zinc-500 focus:outline-none focus:ring-zinc-500 md:text-md">
                    <div v-if="form.errors.email" class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                        <!-- Heroicon name: mini/exclamation-circle -->
                        <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                <p v-if="form.errors.email" class="mt-2 text-sm text-red-600">{{form.errors.email}}</p>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Şifre</label>
                <div class="relative mt-1">
                    <input v-model="form.password" id="password" name="password" type="password"
                           autocomplete="current-password" required
                           class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-zinc-500 focus:outline-none focus:ring-zinc-500 md:text-md">
                    <div v-if="form.errors.password" class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                        <!-- Heroicon name: mini/exclamation-circle -->
                        <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                <p v-if="form.errors.password" class="mt-2 text-sm text-red-600">{{form.errors.password}}</p>
            </div>

            <div>
                <label for="password-confirmation" class="block text-sm font-medium text-gray-700">Şifre Tekrarı</label>
                <div class="relative mt-1">
                    <input v-model="form.password_confirmation" id="password-confirmation" name="password-confirmation"
                           type="password" autocomplete="password-confirmation" required
                           class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-zinc-500 focus:outline-none focus:ring-zinc-500 md:text-md">
                    <div v-if="form.errors.password_confirmation" class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                        <!-- Heroicon name: mini/exclamation-circle -->
                        <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                <p v-if="form.errors.password_confirmation" class="mt-2 text-sm text-red-600">{{form.errors.password_confirmation}}</p>
            </div>

            <div>
                <button :disabled="form.processing" :class="{'opacity-75': form.processing}" type="submit"
                        class="flex w-full justify-center rounded-md border border-transparent bg-zinc-700 py-2 px-4 text-md font-medium text-white shadow-sm hover:bg-zinc-600 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:ring-offset-2">
                    Kayıt Ol
                </button>
            </div>
        </form>

    <template #outOfTheCard>
        <p class="mt-8 text-center text-sm text-gray-700">
            Mevcut kanalınız var mı? Hemen
            <Link href="/login" class="font-medium text-indigo-600 hover:text-indigo-500">Giriş yapabilirsiniz</Link>
        </p>
    </template>
</AuthenticationCard>
</template>

<style scoped>

</style>
