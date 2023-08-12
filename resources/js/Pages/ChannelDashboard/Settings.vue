<script setup>
    import {computed, ref} from "vue";
    import {useForm, usePage, router} from "@inertiajs/vue3";
    import ChannelDashboard from "../../Layouts/ChannelDashboard.vue";

    const props = defineProps({
        channel: {
            type: Object,
            default: () => null
        }
    })

    const appUrl = usePage().props.url

    const channelPhotoCheck = computed(() => props.channel.photo?.startsWith('https://ui-avatars.com'))

    const photoPreview = ref(null)
    const photoInput = ref(null)

    const coverPhotoPreview = ref(null)
    const coverPhotoInput = ref(null)

    const settingsForm = useForm({
        name: props.channel.name,
        identifier: `@${props.channel.identifier}`,
        description: props.channel.description,
        photo: null,
        cover_photo: null,
        _method: 'PUT'
    })

    const updatePhotoPreview = event => {
        const photo = event.target.files[0]

        if (!photo) return

        const reader = new FileReader()

        reader.onload = e => photoPreview.value = e.target.result

        reader.readAsDataURL(photo)
    }

    const updateCoverPhotoPreview = event => {
        const photo = event.target.files[0]

        if (!photo) return

        const reader = new FileReader()

        reader.onload = e => coverPhotoPreview.value = e.target.result

        reader.readAsDataURL(photo)
    }

    const deletePhoto = () => settingsForm.delete(route('channel-photo-delete',{channel: props.channel.id}))

    const changeAvatarColor = () => router.put(route('avatar-color-change',{channel: props.channel.id}))

    const updateSettingsForm = () => {
        if(photoInput.value.files[0]) {
            settingsForm.photo = photoInput.value.files[0]
        }

        if(coverPhotoInput.value.files[0]){
            settingsForm.cover_photo = coverPhotoInput.value.files[0]
        }

        settingsForm.post(route('channel-dashboard.settings.update',props.channel),{
            forceFormData: true,
            preserveScroll: true
        })
    }
</script>

<template>
<ChannelDashboard head-title="Kontrol Paneli - Kanal Ayarları">
    <template #pageHeading>
        Kanal Ayarları
    </template>

    <form @submit.prevent="updateSettingsForm" class="space-y-8 divide-y divide-gray-200">
        <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">
            <div class="space-y-6 sm:space-y-5">
                <div class="space-y-6 sm:space-y-5">
                    <div class="sm:grid sm:grid-cols-3 sm:items-center sm:gap-4">
                        <label for="photo" class="block text-sm font-medium text-gray-700">Kanal Fotoğrafı</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <div class="flex items-center">
                                <img class="inline-block h-20 w-20 rounded-lg object-cover"
                                     v-if="!photoPreview"
                                     :src="channel.channel_photo_url"
                                     alt="">

                                <img v-if="photoPreview"
                                     class="inline-block h-20 w-20 rounded-lg object-cover"
                                     :src="photoPreview"
                                     alt="">
                                <div class="ml-4 flex">
                                    <div
                                        class="relative flex cursor-pointer items-center rounded-md border border-blue-gray-300 bg-white px-3 shadow-sm focus-within:outline-none focus-within:ring-2 focus-within:ring-blue-500 focus-within:ring-offset-2 focus-within:ring-offset-blue-gray-50 hover:bg-blue-gray-50">
                                        <label for="channel-photo"
                                               class="pointer-events-none relative text-sm font-medium text-blue-gray-900">
                                            <span>Değiştir</span>
                                        </label>
                                        <input ref="photoInput"
                                               @change="updatePhotoPreview"
                                               id="channel-photo"
                                               name="channel-photo"
                                               type="file"
                                               class="absolute inset-0 h-full w-full cursor-pointer rounded-md border-gray-300 opacity-0">
                                    </div>
                                    <button :disabled="channelPhotoCheck"
                                            :class="{'disabled: opacity-50': channelPhotoCheck}"
                                            @click.prevent="deletePhoto"
                                            type="button"
                                            class="ml-3 rounded-md border border-blue-gray-300 bg-white py-2 px-3 text-sm font-medium text-blue-gray-900 hover:text-blue-gray-700 focus:border-blue-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-blue-gray-50">
                                        Sil
                                    </button>
                                    <button :disabled="!channelPhotoCheck"
                                            :class="{'disabled: opacity-50': !channelPhotoCheck}"
                                            @click.prevent="changeAvatarColor"
                                            type="button"
                                            class="ml-3 rounded-md border border-blue-gray-300 bg-white py-2 px-3 text-sm font-medium text-blue-gray-900 hover:text-blue-gray-700 focus:border-blue-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-blue-gray-50">
                                        Avatarın Rengini Değiştir
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="first-name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Kanal Adı
                        </label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <input v-model="settingsForm.name" type="text" name="first-name" id="first-name" autocomplete="given-name"
                                   :class="{'border-red-600': settingsForm.errors.name}"
                                   class="block w-full max-w-0 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-2xl sm:text-md">
                            <p class="text-red-600 text-[11px] mt-1.5">{{settingsForm.errors.name}}</p>
                            <p class="mt-1.5 text-[12px] text-gray-500" id="email-description">
                                Kullanıcının kanalını tanımlayan özel bir isimdir.
                            </p>
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200  sm:pt-5">
                        <label for="username" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Kanal
                            Belirleyici</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <div class="flex max-w-2xl rounded-md shadow-sm">
                                <span
                                    class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 bg-gray-50 px-3 text-gray-500 sm:text-sm">{{appUrl}}/</span>
                                <input v-model="settingsForm.identifier" type="text" name="username" id="username" autocomplete="username"
                                       :class="{'border-red-600': settingsForm.errors.identifier}"
                                       class="block w-full min-w-0 flex-1 rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-md">
                            </div>
                            <p class="text-red-600 text-[11px] mt-1.5">{{settingsForm.errors.identifier}}</p>
                            <p class="mt-1.5 text-[12px] text-gray-500" id="email-description">
                                {{appUrl}}/<strong>{{ settingsForm.identifier }}</strong>
                                Özel ve hatırlanması kolay bir ad ekleyerek, bu URL üzerinden kendi
                                kanallarına erişebilirler.
                            </p>
                        </div>
                    </div>


                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="about"
                               class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Açıklama</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <textarea v-model="settingsForm.description" id="about" name="about" rows="7"
                                      :class="{'border-red-600': settingsForm.errors.description}"
                                      class="block w-full max-w-2xl rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                            <p class="text-red-600 text-[11px] mt-1.5">{{settingsForm.errors.description}}</p>
                            <p class="mt-1.5 text-sm text-gray-500">Kanalınız için bir açıklama.</p>
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="cover-photo" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Kapak
                            Fotoğrafı</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <div
                                class="flex max-w-2xl justify-center rounded-md border-2 border-dashed border-gray-300 px-6 pt-5 pb-6">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                         viewBox="0 0 48 48" aria-hidden="true">
                                        <path
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="cover-photo-upload"
                                               class="relative cursor-pointer rounded-md bg-white font-medium text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:text-indigo-500">
                                            <span>Bir resim yükle</span>
                                            <input ref="coverPhotoInput" @change="updateCoverPhotoPreview" id="cover-photo-upload" name="file-upload" type="file" class="sr-only">
                                        </label>
                                        <p class="pl-1">ya da sürekle bırak</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="cover-photo" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Mevcut
                            Kapak Fotoğrafı</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <div class="flex max-w-2xl justify-center">
                                <img v-if="!coverPhotoPreview" class="h-32 w-full object-cover lg:h-48" :src="channel.channel_cover_photo_url" alt="image description">
                                <img v-if="coverPhotoPreview" class="h-32 w-full object-cover lg:h-48" :src="coverPhotoPreview" alt="image description">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-5">
            <div class="flex justify-end">
                <button type="submit"
                        class="inline-flex justify-center rounded-md border border-transparent bg-gray-800 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2">
                    Kaydet
                </button>
            </div>
        </div>
    </form>
</ChannelDashboard>
</template>

<style scoped>

</style>
