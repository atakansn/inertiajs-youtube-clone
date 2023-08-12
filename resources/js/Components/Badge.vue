<script setup>
    import {ref, toRefs} from "vue";

    const props = defineProps({
        success: {
            type: Boolean
        },
        information: {
            type: Boolean
        },
        warning: {
            type: Boolean
        },
        danger: {
            type: Boolean
        },
    })

    const propsToRef = toRefs(props)

    const bgColorClasses = ref({
        'bg-green-100': propsToRef.success,
        'bg-red-100': propsToRef.danger,
        'bg-blue-100': propsToRef.information,
        'bg-yellow-100': propsToRef.warning
    })

    const textColorClasses = ref({
        'text-green-800': propsToRef.success,
        'text-red-800': propsToRef.danger,
        'text-blue-800': propsToRef.information,
        'text-yellow-800': propsToRef.warning,
    })
</script>

<template>
<span :class="[bgColorClasses, textColorClasses]"
      class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium">
    <slot name="text" />
</span>
</template>

<style scoped>

</style>
