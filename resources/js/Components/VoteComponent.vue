<script setup>
    import {computed, ref} from "vue";
    import {usePage} from "@inertiajs/vue3";
    import HandThumbUpIcon from "./HandThumbUpIcon.vue";
    import HandThumbDownIcon from "./HandThumbDownIcon.vue";
    import AuthenticationModal from "@Components/AuthenticationModal.vue";

    const props = defineProps({
        defaultVotes: {
            type: Array,
            default: () => []
        },
        entityOwner: {
            required: false
        },
        entityId: {
            required: true
        },
        authUserId: {
            required: true
        }
    })

    const votes = ref([])
    const showAuthModal = ref(false)

    votes.value = props.defaultVotes

    const upVotes = computed(() => votes.value.filter(vote => vote.type === 'up'))
    const downVotes = computed(() => votes.value.filter(vote => vote.type === 'down'))

    const upVotesCount = computed(() => upVotes.value.length)
    const downVotesCount = computed(() => downVotes.value.length)

    const upVoted = computed(() => !!upVotes.value.find(vote => vote.user_id === props.authUserId))
    const downVoted = computed(() => !!downVotes.value.find(vote => vote.user_id === props.authUserId))

    const vote = type => {
        // if(authUser.id === props.entityOwner){
        //     console.log('foo')
        //     return;
        // }

        if (!props.authUserId) {
            openAuthModal()
            return
        }

        if (type === 'up' && upVoted.value) return
        if (type === 'down' && downVoted.value) return

        axios.post(`http://127.0.0.1:8000/votes/${props.entityId}/${type}`)
            .then(({data}) => {
                if (upVoted.value || downVoted.value) {
                    votes.value = votes.value.map(vote => {
                        if (vote.user_id === props.authUserId) {
                            return data
                        }

                        return vote
                    })
                } else {
                    votes.value = [
                        ...votes.value,
                        data
                    ]
                }
            })
    }

    const openAuthModal = () => {
        if (!props.authUserChannel) {
            return showAuthModal.value = true
        }

        showAuthModal.value = false
    }

    const closeAuthModal = () => {
        showAuthModal.value = false
    }
</script>

<template>
<AuthenticationModal @close="closeAuthModal"
                     :visibleable="showAuthModal"/>

<button @click="vote('up')"
        :class="{'text-gray-800': upVoted}"
        type="button"
        class="flex items-center justify-center text-gray-600 hover:text-gray-800">
    <HandThumbUpIcon :outline="upVoted" :solid="upVoted"/>
    <span class="ms-1.5">{{ upVotesCount }}</span>
</button>
<button @click="vote('down')"
        :class="{'text-gray-800': downVoted}"
        type="button"
        class="ms-4 flex items-center justify-center text-gray-600 hover:text-gray-800">
    <HandThumbDownIcon :outline="downVoted" :solid="downVoted"/>
    <span class="ms-1.5">{{ downVotesCount }}</span>
</button>
</template>

<style scoped>

</style>
