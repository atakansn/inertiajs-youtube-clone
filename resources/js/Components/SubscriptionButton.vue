<script setup>
    import {useSubscription} from "../Composables/useSubscription.js";
    import {computed, ref} from "vue";
    import {usePage} from "@inertiajs/vue3";
    import AuthenticationModal from "@/Components/AuthenticationModal.vue";

    const props = defineProps({
        channel: {},
        customClass: {}
    })

    const authUser = computed(() => usePage().props.auth.user)

    const {toggleSubscription, subscribed, owner, showAuthModal} = useSubscription(props.channel, authUser.value)

    const defaultClass = [
        'inline-flex items-center justify-center px-4 py-1.5 text-sm font-semibold leading-6 text-gray-700 whitespace-no-wrap bg-gray-50 border border-gray-200 rounded-full shadow-sm hover:bg-gray-100 focus:outline-none focus:shadow-none'
    ]

    const subscribedClass = ref({
        'bg-gray-100 text-gray-700': subscribed
    })

    const closeModal = () => showAuthModal.value = false

</script>

<template>
<AuthenticationModal @close="closeModal"
                     :visibleable="showAuthModal"/>

<slot name="subscribeEl"
      :classes="[defaultClass,subscribedClass]"
      :owner="owner"
      :subscribed="subscribed"
      :toggleSubscription="toggleSubscription">

    <button v-if="!owner"
            @click.prevent="toggleSubscription"
            :class="[defaultClass, subscribedClass, customClass]"
            type="button">
        {{ subscribed ? 'Abonelikten Çık' : 'Abone Ol' }}
    </button>

</slot>
</template>

<style scoped>

</style>
