import {computed, ref, watch} from "vue";

export function useSubscription(channel, authUser) {

    const showAuthModal = ref(false)
    const subscriptions = ref(channel.subscriptions)

    const subscription = computed(() => {
        return subscriptions.value.find(subscription => subscription?.user_id === authUser?.id)
    })

    const subscribed = computed(() => {
        if (channel?.user_id === authUser?.id) {
            return false
        }

        return !!subscription.value
    })

    const owner = computed(() => {
        return channel.user_id === authUser?.id;
    })

    const toggleSubscription = () => {
        if (!authUser) {
            showAuthModal.value = true
            return
        }

        if (owner.value) {
            return
        }

        if (subscribed.value) {
            axios.delete(route('subscription.destroy', {
                channel: channel.id,
                subscription: subscription.value.id
            }))
                .then(() => {
                    subscriptions.value = subscriptions.value.filter(sub => sub.id !== subscription.value.id)
                })
        } else {
            axios.post(route('subscription.store', {
                channel: channel.id,
            }), {
                channel: channel.id
            })
                .then(response => {
                    subscriptions.value.push(response.data)
                })
        }
    }

    return {
        subscriptions,
        subscription,
        subscribed,
        owner,
        toggleSubscription,
        showAuthModal
    }
}
