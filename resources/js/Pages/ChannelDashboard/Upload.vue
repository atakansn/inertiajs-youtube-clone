<script setup>
    import ChannelDashboard from "../../Layouts/ChannelDashboard.vue";
    import {useForm, usePage} from "@inertiajs/vue3";
    import {computed, nextTick, ref,} from "vue";
    import Alert from "../../Components/Alert.vue";
    import ModalSingleAction from "../../Components/ModalSingleAction.vue";
    import useByteToOtherFormats from "@Composables/useByteToOtherFormats.js"

    const props = computed(() => usePage().props)

    const videoData = ref({
        title: '',
        description: '',
        published: ''
    })

    const fileInput = ref(null)
    const allowFields = ref(true)
    const showUpload = ref(true)
    const showVideoDetail = ref(false)
    const showModal = ref(false)
    const validationErrors = ref({})

    const fileInputForm = useForm({
        rawVideo: null,
        videoTitle: null,
    })

    const videoPublishedForm = useForm({
        title: '',
        description: '',
        publishStatus: ''
    })

    const publishedVideo = async () => {
        videoPublishedForm.put(route('channel-dashboard.new-video-published', {video: videoData.value?.id}), {
            method: 'put',
            onStart: () => allowFields.value = true,
            onSuccess: params => {
                showModal.value = true
                allowFields.value = true
                videoPublishedForm.reset()
            },
            onError: () => allowFields.value = false
        })
    }

    const feedbackVideoData = id => {
        const intervalClear = setInterval(() => {
            axios.get(route('channel-dashboard.video.upload.show', {video: id}))
                .then(response => {
                    videoData.value = response.data
                    if (response.data.processing_percentage === 100) {
                        clearInterval(intervalClear)
                        nextTick(() => allowFields.value = false)
                    }
                })
        }, 4000)
    }

    const fileInputClick = () => {
        fileInput.value.click()
    }

    const fileInputChange = e => {
        const file = e.target.files[0]

        if (!file) return

        const mimeType = file?.type
        const fileSize = useByteToOtherFormats(file?.size)
        const name = file.name
        const fileName = name.slice(0, name.lastIndexOf('.'))
        const fileExtension = name.slice(name.lastIndexOf('.') + 1).toLowerCase()
        const extensions = ['mp4']

        if (mimeType !== 'video/mp4' || !extensions.includes(fileExtension)) {
            return alert('Video türü video/mp4 veya uzantısı MP4 olmalı')
        }

        if (fileSize >= useByteToOtherFormats(30000000)) {
            return alert('Dosya boyutu 30 MB\'dan küçük olmalıdır.')
        }

        fileInputForm.rawVideo = file
        fileInputForm.videoTitle = fileName

        return fileInputForm.post(`/channel-dashboard/${props.value.channel.id}/upload`, {
            onSuccess: page => {
                showUpload.value = false
                showVideoDetail.value = true
                fileInputForm.reset()
                feedbackVideoData(page.props.video.id)
            },
            onFinish: page => {
                console.log('finish',page)
            },
            onError: page => validationErrors.value = page.rawVideo
        })
    }

</script>

<template>
<ChannelDashboard head-title="Kanala Video Yükle">
    <template #pageHeading>
        Video Yükle

        <Alert class="mt-3"
               v-if="showVideoDetail"
               :information="videoData.processing_percentage !== 100"
               :success="videoData.processing_percentage === 100">
            <template v-if="videoData.processing_percentage !== 100" #message>
                "Yayınla" butonu, videonuzu başlığı ve açıklaması birlikte <strong>(başlık ve açıklamayı
                düzenleyip)</strong> yayınlayabilirsiniz. Alternatif olarak, videonuzu düzenleme sayfasından
                düzenleyebilirsiniz.
            </template>

            <template v-if="videoData.processing_percentage === 100" #message>
                Videonuz başarıyla işlendi ve yüklendi. Başlık ve açıklama belirleyip, "Yayınla" butonuna tıklayıp
                yayına alabilirsiniz.
            </template>

            <template class="font-medium" #list>
                <li>Yüklemiş olduğunuz video şu anda yayında değildir !</li>
                <li>Video varsayılan başlığı: <span class="text-red-500">{{ videoData.title }}</span></li>
                <li>Açıklaması bulunmamaktadır.</li>
            </template>
        </Alert>

        <Alert v-if="validationErrors.length > 0" :danger="validationErrors.length > 0" class="mt-3">
            <template #message>
                Hata
            </template>

            <template class="font-medium" #list>
                <li>{{validationErrors}}</li>
            </template>
        </Alert>
    </template>

    <div class="mx-auto max-w-2xl px-2 lg:max-w-7xl">
        <div v-if="showUpload" class="text-center">
            <div class="my-20">
                <svg class="mx-auto h-24 w-24 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z"/>
                </svg>
                <p class="mt-1 text-sm text-gray-500">
                    Başlamak için bir video yükleyip yayınlayın.
                </p>
                <div class="mt-5">
                    <button :class="{'disabled:bg-dark-400': fileInputForm.processing}"
                            :disabled="fileInputForm.processing"
                            @click="fileInputClick"
                            type="button"
                            class="disabled:bg-gray-500 inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-700 focus:ring-offset-2">
                        <svg v-if="fileInputForm.processing"
                             class="-ml-1 mr-2 h-5 w-5"
                             :class="{'animate-spin': fileInputForm.processing}"
                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>

                        Video Yükle
                    </button>
                    <input ref="fileInput" @change="fileInputChange" type="file" class="hidden"/>
                </div>
            </div>
        </div>

        <div v-if="showVideoDetail && videoData">
            <div>
                <div class="mb-14">
                    <div class="flex justify-between">
                        <p v-if="!videoData.processing_percentage" class="text-md font-medium text-gray-900 text-left">
                            Yükleniyor...
                        </p>
                        <p v-else class="text-md font-medium text-gray-900 text-left">
                            <template v-if="videoData.processing_percentage !== 100">
                                İşleniyor...
                            </template>
                            <template v-if="videoData.processing_percentage === 100">
                                Tamamlandı...
                            </template>
                        </p>
                        <p class="text-md font-medium text-gray-900 text-right">
                            {{ videoData.processing_percentage ? `%${videoData.processing_percentage}` : '' }}
                        </p>
                    </div>
                    <div class="mt-6" aria-hidden="true">
                        <div class="overflow-hidden rounded-full bg-gray-200">
                            <div class="transition-all ease-out duration-1000 h-2.5 rounded-full bg-indigo-600"
                                 :class="{'progress-bar-striped': !videoData.processing_percentage, 'progress-bar-animated': !videoData.processing_percentage}"
                                 :style="{'width': `${videoData.processing_percentage}%`}"></div>
                        </div>
                    </div>
                </div>
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <img v-if="videoData.video_thumbnail"
                                :src="videoData.video_thumbnail"
                                class="h-80 w-96 rounded-sm object-cover object-center">
                            <div v-else role="status"
                                 class="object-cover object-center flex items-center justify-center h-80 w-[90] bg-gray-300 rounded-sm animate-pulse dark:bg-gray-700">
                                <svg class="h-20 w-20 text-gray-200 dark:text-gray-600"
                                     xmlns="http://www.w3.org/2000/svg"
                                     fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 md:col-span-2 md:mt-0">
                        <form @submit.prevent="publishedVideo">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="title"
                                           :class="{'opacity-75': allowFields}"
                                           class="block text-md font-medium text-gray-700">Başlık</label>
                                    <div class="mt-1">
                                        <input :disabled="allowFields"
                                               v-model="videoPublishedForm.title"
                                               :class="{'opacity-75': allowFields, 'border-red-500':videoPublishedForm.errors.title}"
                                               type="text"
                                               name="title"
                                               id="title"
                                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-md">
                                        <p class="mt-1 text-xs text-red-500"
                                           v-if="videoPublishedForm.errors">
                                            {{ videoPublishedForm.errors.title }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="publish_status"
                                           :class="{'opacity-75': allowFields}"
                                           class="block text-md font-medium text-gray-700">
                                        Yayınlama Durumu
                                    </label>
                                    <select v-model="videoPublishedForm.publishStatus"
                                            :disabled="allowFields"
                                            :class="{'opacity-75': allowFields, 'border-red-500':videoPublishedForm.errors.is_published}"
                                            id="publish_status"
                                            class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-md">
                                        <option selected value disabled>Yayın Durumu Seçiniz</option>
                                        <option value="0">Yayınlama</option>
                                        <option value="1">Yayınla</option>
                                    </select>
                                    <p class="mt-1 mb-3 text-xs text-red-500"
                                       v-if="videoPublishedForm.errors">
                                        {{ videoPublishedForm.errors.is_published }}
                                    </p>
                                </div>
                            </div>
                            <div class="mt-3">
                                <label for="description"
                                       :class="{'opacity-75': allowFields}"
                                       class="block text-md font-semibold text-gray-700">Açıklama</label>
                                <div class="mt-1">
                                    <textarea
                                        :disabled="allowFields"
                                        v-model="videoPublishedForm.description"
                                        :class="{'opacity-75': allowFields, 'border-red-500':videoPublishedForm.errors.description}"
                                        rows="4" name="description"
                                        id="description"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-md">
                                    </textarea>
                                    <p class="mt-1 mb-3 text-xs text-red-500"
                                       v-if="videoPublishedForm.errors">
                                        {{ videoPublishedForm.errors.description }}
                                    </p>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button :disabled="allowFields"
                                        :class="{'opacity-75': allowFields}"
                                        type="submit"
                                        class="inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-3 text-md font-medium leading-4 text-white shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-700 focus:ring-offset-2">
                                    Kaydet
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</ChannelDashboard>

<ModalSingleAction :data="videoData.id" v-if="showModal">
    <template #title>
        Yayınlandı !
    </template>
    <template #body>
        Videonuz başarıyla yayınlandı.
    </template>
</ModalSingleAction>
</template>

<style scoped>
.progress-bar-striped {
    background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
    background-size: 16px 16px;
}

.progress-bar-animated {
    animation: 2s linear infinite progress-bar-stripes;
}

@keyframes progress-bar-stripes {
    0% {
        background-position-x: 1rem;
    }
}
</style>
