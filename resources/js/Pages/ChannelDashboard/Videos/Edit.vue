<script setup>
    import {ref} from "vue";
    import {useForm} from "@inertiajs/vue3";
    import ChannelDashboard from "../../../Layouts/ChannelDashboard.vue";

    const props = defineProps({
        video: {}
    })

    const videoForm = useForm({
        thumbnail: null,
        title: props.video.title,
        description: props.video.description,
        _method: 'PUT'
    })

    const thumbnailPreview = ref(null)
    const thumbnailInput = ref(null)

    const changeThumbnailPreview = event => {
        const image = event.target.files[0]

        if(!image) return

        const reader = new FileReader()

        reader.onload = e => thumbnailPreview.value = e.target.result

        reader.readAsDataURL(image)
    }

    const updateVideo = () => {
        if(thumbnailInput.value.files[0]){
            videoForm.thumbnail = thumbnailInput.value.files[0]
        }

        videoForm.post(route('channel-dashboard.videos.update',{video: props.video.id}),{
            forceFormData: true,
            onError: error => console.log(error)
        })
    }

</script>

<template>

<ChannelDashboard head-title="Video Düzenle">
    <template #pageHeading>
        Video Düzenleme
    </template>
    <form @submit.prevent="updateVideo" class="space-y-8 divide-y divide-gray-200">
        <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">
            <div class="space-y-6 sm:space-y-5">
                <div class="space-y-6 sm:space-y-5">
                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-b sm:border-gray-200 sm:pb-5">
                        <label for="cover-photo" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Video Thumbnail</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <div class="sm:col-span-6">
                                <img v-if="!thumbnailPreview" class="inline-block rounded-sm w-72" :src="video.video_thumbnail" alt="">
                                <img v-if="thumbnailPreview" class="inline-block rounded-sm w-72" :src="thumbnailPreview" alt="">
                                <div class="mt-1 flex items-center">
                                    <div class="mt-4 flex">
                                        <div class="relative flex cursor-pointer items-center rounded-md border border-blue-gray-300 bg-white py-2 px-3 shadow-sm focus-within:outline-none focus-within:ring-2 focus-within:ring-blue-500 focus-within:ring-offset-2 focus-within:ring-offset-blue-gray-50 hover:bg-blue-gray-50">
                                            <label for="user-photo" class="pointer-events-none relative text-sm font-medium text-blue-gray-900">
                                                <span>Değiştir</span>
                                            </label>
                                            <input ref="thumbnailInput" @change="changeThumbnailPreview" id="user-photo" name="user-photo" type="file" class="absolute inset-0 h-full w-full cursor-pointer rounded-md border-gray-300 opacity-0">
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 text-red-500 font-normal text-base">{{videoForm.errors.thumbnail}}</p>
                            </div>
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4">
                        <label for="video-title" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Video Başlığı</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0 max-w-lg">
                                <input v-model="videoForm.title"
                                       :class="{'border-red-500': videoForm.errors.title}"
                                       type="text"
                                       id="video-title"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <p class="mt-1 text-red-500 font-normal text-sm">{{videoForm.errors.title}}</p>
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="video-about" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Video Açıklaması</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <textarea v-model="videoForm.description"
                                      :class="{'border-red-500': videoForm.errors.description}"
                                      id="video-about" rows="7"
                                      class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                            <p class="mt-1 text-red-500 font-normal text-sm">{{videoForm.errors.description}}</p>
                            <p class="mt-2 text-sm text-gray-500">Videonuz için bir açıklama.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-5">
            <div class="flex justify-end">
                <button type="submit" class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-gray-800 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">Güncelle</button>
            </div>
        </div>
    </form>
</ChannelDashboard>
</template>

<style scoped>

</style>
