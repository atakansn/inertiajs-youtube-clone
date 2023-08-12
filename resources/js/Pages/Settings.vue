<script setup>
    import {computed, nextTick, ref} from "vue";
    import {useForm, usePage} from "@inertiajs/vue3";
    import AppLayout from "@/Layouts/AppLayout.vue";

    const pageProps = computed(() => usePage().props)

    const props = defineProps({
        sessions: {}
    })

    const user = pageProps.value.auth.user

    const passwordInput = ref(null)
    const passwordConfirmModal = ref(false)

    const userForm = useForm({
        name: user.name,
        email: user.email,
    })

    const passwordForm = useForm({
        current_password: '',
        password: '',
        password_confirmation: '',
    })

    const logoutOtherSessionForm = useForm({
        password: ''
    })

    const updateUserForm = () => {
        userForm.put('user/profile-information', {
            preserveScroll: true,
            errorBag: 'updateProfileInformation'
        })
    }

    const updatePasswordForm = () => {
        passwordForm.put(route('user-password.update'), {
            preserveScroll: true,
            errorBag: 'updatePassword'
        })
    }

    const closeModal = () => {
        passwordConfirmModal.value = false
        logoutOtherSessionForm.reset()
    }

    const confirmLogout = () => {
        passwordConfirmModal.value = true
        nextTick(() => {
            passwordInput.value.focus()
        })
    }

    const logoutOtherSessions = () => {
        logoutOtherSessionForm.delete(route('settings.other-browser-sessions.destroy'), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
            onError: () => passwordInput.value.focus(),
            onFinish: () => logoutOtherSessionForm.reset()
        })
    }
</script>

<template>
<AppLayout head-title="Ayarlar">
    <Teleport to="body">
        <div v-if="passwordConfirmModal" class="relative z-10" aria-labelledby="modal-title" role="dialog"
             aria-modal="true">
            <Transition enter-active-class="ease-out duration-300" enter-from-class="opacity-0"
                        enter-to-class="opacity-100" leave-active-class="ease-in duration-200"
                        leave-from-class="opacity-100" leave-to-class="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
            </Transition>

            <div class="fixed inset-0 z-10 overflow-y-auto">

                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <Transition enter-active-class="ease-out duration-300"
                                enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                                leave-active-class="ease-in duration-200"
                                leave-from-class="opacity-100 translate-y-0 sm:scale-100"
                                leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <div
                            class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
                            <div class="absolute top-0 right-0 hidden pt-4 pr-4 sm:block">
                                <button @click="closeModal" type="button"
                                        class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    <span class="sr-only">Kapat</span>
                                    <!-- Heroicon name: outline/x-mark -->
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                         aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="mt-5">
                                <div
                                    class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-yellow-100">
                                    <!-- Heroicon name: exclamation-triangle -->
                                    <svg class="w-8 h-8 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                                    </svg>

                                </div>
                                <div class="mt-3 text-center sm:mt-3">
                                    <h3 class="text-lg font-medium leading-7 text-gray-900" id="modal-title">Tüm
                                        Cihazlardan Çıkış Yapıyorsunuz</h3>
                                    <div class="mt-5 mb-3">
                                        <p class="text-sm text-gray-500">Hesap parolanızı girerek, tüm cihazlardan çıkış
                                            yapın.</p>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <input ref="passwordInput"
                                       v-model="logoutOtherSessionForm.password"
                                       placeholder="Parola"
                                       type="password"
                                       name="password"
                                       id="password"
                                       :class="{'border-red-500': logoutOtherSessionForm.errors.password}"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <p v-if="logoutOtherSessionForm.errors.password" class="text-red-500 text-xs mt-1.5">
                                    {{ logoutOtherSessionForm.errors.password }}</p>
                            </div>
                            <div class="mt-5 sm:mt-6">
                                <button @click="logoutOtherSessions" type="button"
                                        class="inline-flex w-full justify-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:text-sm">
                                    Çıkış Yap
                                </button>
                            </div>
                        </div>
                    </Transition>
                </div>
            </div>
        </div>
    </Teleport>

    <div class="space-y-6 mt-5">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Hesap Bilgileri</h3>
                    <p class="mt-1 text-sm text-gray-600">Kanalınızı oluşturma aşamasında kullandığınız bilgiler.</p>
                </div>
            </div>
            <div class="mt-5 md:col-span-2 md:mt-0">
                <form @submit.prevent="updateUserForm">
                    <div class="overflow-hidden border rounded-lg shadow-sm sm:rounded-md">
                        <div class=" px-4 py-5 sm:p-6">
                            <div class="grid grid-cols-5 gap-6">
                                <div class="col-span-3">
                                    <label for="name" class="block text-sm font-medium text-gray-700">
                                        İsim
                                    </label>
                                    <input v-model="userForm.name" type="text" name="name" id="name"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-md"
                                           :class="{'border-red-600': userForm.errors.name}"
                                           placeholder="İsim">
                                    <p v-if="userForm.errors" class="mt-2 text-red-600 font-semibold text-sm">
                                        {{ userForm.errors.name }}</p>
                                </div>
                                <div class="col-span-3">
                                    <label for="email" class="block text-sm font-medium text-gray-700">E-posta
                                        Adresi</label>
                                    <input v-model="userForm.email" type="email" name="email" id="email"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-md"
                                           :class="{'border-red-600': userForm.errors.email}"
                                           placeholder="ornek@mail.com">
                                    <p v-if="userForm.errors" class="mt-2 text-red-600 font-semibold text-sm">
                                        {{ userForm.errors.email }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 text-right sm:px-6 bg-gray-50">
                            <button type="submit"
                                    class="inline-flex justify-center rounded-md border border-transparent bg-gray-800 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2">
                                Kaydet
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="hidden sm:block" aria-hidden="true">
            <div class="py-5">
                <div class="border-t border-gray-200"></div>
            </div>
        </div>

        <div class="mt-10 sm:mt-0">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Parola İşlemleri</h3>
                        <p class="mt-1 text-sm text-gray-600">Mevcut parolaınızı güncelleme</p>
                    </div>
                </div>
                <div class="mt-5 md:col-span-2 md:mt-0">
                    <form @submit.prevent="updatePasswordForm">
                        <div class="overflow-hidden border rounded-lg shadow-sm sm:rounded-md">
                            <div class="px-4 py-5 sm:p-6">
                                <div class="grid grid-cols-5 gap-6">
                                    <div class="col-span-3">
                                        <label for="current-password" class="block text-sm font-medium text-gray-700">Eski
                                            Parola</label>
                                        <input v-model="passwordForm.current_password"
                                               :class="{'border-red-600': passwordForm.errors.current_password}"
                                               type="password"
                                               name="current-password" id="current-password"
                                               autocomplete="given-name"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-md">
                                        <p class="mt-1 text-[12px] text-red-600">
                                            {{ passwordForm.errors.current_password }}</p>
                                    </div>

                                    <div class="col-span-3">
                                        <label for="password" class="block text-sm font-medium text-gray-700">Yeni
                                            Parola</label>
                                        <input v-model="passwordForm.password" type="password" name="password"
                                               :class="{'border-red-600': passwordForm.errors.password}"
                                               id="password"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-md">
                                        <p class="mt-1 text-[12px] text-red-600">{{ passwordForm.errors.password }}</p>
                                    </div>

                                    <div class="col-span-3">
                                        <label for="password-confirmation"
                                               class="block text-sm font-medium text-gray-700">Yeni Parola
                                            Tekrarı</label>
                                        <input v-model="passwordForm.password_confirmation" type="password"
                                               :class="{'border-red-600': passwordForm.errors.password_confirmation}"
                                               name="password-confirmation" id="password-confirmation"
                                               autocomplete="street-address"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-md">
                                        <p class="mt-1 text-[12px] text-red-600">
                                            {{ passwordForm.errors.password_confirmation }}</p>
                                    </div>

                                </div>
                            </div>
                            <div class="px-4 py-3 sm:px-6 text-right bg-gray-50">
                                <button type="submit"
                                        class="inline-flex justify-center rounded-md border border-transparent bg-gray-800 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2">
                                    Kaydet
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="hidden sm:block" aria-hidden="true">
            <div class="py-5">
                <div class="border-t border-gray-200"></div>
            </div>
        </div>

        <div class="mt-10 sm:mt-0">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Tarayıcı Oturumları</h3>
                        <p class="mt-1 text-sm text-gray-600">Giriş yaptığınız cihazları gösterir, <strong>Diğer Cihazlardan Çıkış Yap</strong> butonu mevcut oturumu etkilemez.</p>
                    </div>
                </div>
                <div class="md:col-span-2 md:mt-0">
                    <div class="overflow-hidden border rounded-lg shadow-sm sm:rounded-md mb-5">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                    <div class="sm:col-span-4">
                                        <ul role="list" class="divide-y divide-gray-200">
                                            <li v-for="(session,index) in sessions" class="flex py-4">
                                                <svg v-if="session.agent.is_desktop" xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 24 24"
                                                     fill="currentColor" class="w-8 h-8">
                                                    <path fill-rule="evenodd"
                                                          d="M2.25 5.25a3 3 0 013-3h13.5a3 3 0 013 3V15a3 3 0 01-3 3h-3v.257c0 .597.237 1.17.659 1.591l.621.622a.75.75 0 01-.53 1.28h-9a.75.75 0 01-.53-1.28l.621-.622a2.25 2.25 0 00.659-1.59V18h-3a3 3 0 01-3-3V5.25zm1.5 0v7.5a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5v-7.5a1.5 1.5 0 00-1.5-1.5H5.25a1.5 1.5 0 00-1.5 1.5z"
                                                          clip-rule="evenodd"/>
                                                </svg>

                                                <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                     fill="currentColor" class="w-6 h-6">
                                                    <path d="M10.5 18.75a.75.75 0 000 1.5h3a.75.75 0 000-1.5h-3z"/>
                                                    <path fill-rule="evenodd"
                                                          d="M8.625.75A3.375 3.375 0 005.25 4.125v15.75a3.375 3.375 0 003.375 3.375h6.75a3.375 3.375 0 003.375-3.375V4.125A3.375 3.375 0 0015.375.75h-6.75zM7.5 4.125C7.5 3.504 8.004 3 8.625 3H9.75v.375c0 .621.504 1.125 1.125 1.125h2.25c.621 0 1.125-.504 1.125-1.125V3h1.125c.621 0 1.125.504 1.125 1.125v15.75c0 .621-.504 1.125-1.125 1.125h-6.75A1.125 1.125 0 017.5 19.875V4.125z"
                                                          clip-rule="evenodd"/>
                                                </svg>


                                                <div class="ml-3">
                                                    <p class="text-sm font-medium text-gray-900">
                                                        {{ session.agent.platform }}, {{ session.agent.browser }}</p>
                                                    <p class="text-sm text-gray-500">
                                                        {{ session.ip_address }},
                                                        <span v-if="session.is_current_device"
                                                              class="text-green-600 font-semibold">Bu Cihaz Aktif</span>
                                                        <span v-else
                                                              class="text-gray-500">Son Aktivite, {{ session.last_active }}</span>
                                                    </p>
                                                </div>
                                            </li>
                                        </ul>
                                        <button @click="confirmLogout" type="button"
                                                class="inline-flex justify-center rounded-md border border-transparent mt-5 bg-gray-800 py-2 px-7 text-sm font-medium text-white shadow-sm hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2">
                                            Diğer Cihazlardan Çıkış Yap
                                        </button>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</AppLayout>
</template>

<style scoped>

</style>
