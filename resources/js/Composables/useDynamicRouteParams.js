import {usePage} from "@inertiajs/vue3";
import {computed} from "vue";

export function useDynamicRouteParams() {
    const url = usePage().url
    const pattern = /\/([\w-]+)(?:\/(\w+))?/
    const match = url.match(pattern)

    const routeParam = computed(() => (match && match[2]) || null)

    return {
        routeParam
    }
}
