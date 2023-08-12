<script setup>
    import ChannelDashboard from "../../Layouts/ChannelDashboard.vue";
    import {Link} from "@inertiajs/vue3"
    import SubscriptionButton from "../../Components/SubscriptionButton.vue";
    import {onMounted, ref} from "vue";
    import TheLoadingSpinner from "../../Components/LoadingSpinner.vue";
    import NoContent from "@Components/NoContent.vue";
    import ErrorModal from "@Components/ErrorModal.vue";

    const props = defineProps({
        subscriptions: {},
    })

    const divElementRef = ref(null)
    const subscriptionsList = ref(props.subscriptions)
    const showErrorModal = ref(false)
    
    const closeErrorModal = () => showErrorModal.value = false

    const subscriptionsLoadMore = (entries, observer) => {
        entries.forEach(async entry => {
            if (!entry.isIntersecting || !subscriptionsList.value.next_page_url) {
                return
            }

            try {
                const {data} = await axios.get(subscriptionsList.value.next_page_url)

                subscriptionsList.value = {
                    ...data,
                    data: [
                        ...subscriptionsList.value.data,
                        ...data.data
                    ]
                }

                if (!data.next_page_url) {
                    observer.unobserve(entry.target)
                }

            } catch (e) {
                showErrorModal.value = true
                observer.unobserve(entry.target)
                throw e
            }
        })
    }

    const intersectionObserverLoadMore = new IntersectionObserver(subscriptionsLoadMore)

    onMounted(() => {
        intersectionObserverLoadMore.observe(divElementRef.value)
    })

</script>

<template>
<ErrorModal :visibleable="showErrorModal"
            @close="closeErrorModal"/>

<ChannelDashboard head-title="Abonelikler">
    <template #pageHeading>
        Aboneliklerim
    </template>

    <div>
        <NoContent v-if="subscriptionsList.data.length === 0"
                   title="Abonelik bulunamadı"
                   description="Herhangi bir kanala abone olmadığınız için abonelikleriniz bulunamadı."
                   :link="{text: 'Kanallara göz atın', href: route('channels')}" />

        <ul v-else role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            <li v-for="(subscription,index) in subscriptionsList.data" :key="index"
                class="col-span-1 flex flex-col rounded-lg text-center">
                <div class="flex flex-1 flex-col">
                    <Link :href="route('channel.videos',{identifier: subscription.id})">
                        <img class="mx-auto h-20 w-20 flex-shrink-0 rounded-full"
                             :src="subscription.channel_photo_url"
                             alt="">
                    </Link>
                    <h3 class="mt-4 text-sm font-medium text-gray-900">
                        {{ subscription.name }}
                    </h3>
                    <dl class="mt-1 flex flex-grow flex-col justify-between">
                        <dd class="text-sm text-gray-500">
                            {{ subscription.subscriptions.length }} Abone
                        </dd>
                    </dl>
                </div>
                <div class="flex justify-center mt-3">
                    <SubscriptionButton :channel="subscription"/>
                </div>
            </li>
        </ul>

        <div ref="divElementRef">
            <TheLoadingSpinner v-if="!!subscriptionsList.next_page_url"/>
        </div>
    </div>
</ChannelDashboard>
</template>
