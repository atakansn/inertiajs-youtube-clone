import {ref} from "vue";

export function useLazyCommentLoader() {
    const comments = ref(null)
    const scrollElement = ref(null)

    const loadMore = (entries, observer) => {
        if (entries[0].isIntersecting && comments.value.next_page_url) {
            axios.get(comments.value.next_page_url)
                .then(response => {
                    comments.value = {
                        ...response.data[0],
                        data: [
                            ...comments.value.data,
                            ...response.data[0].data
                        ]
                    }

                    if (!response.data[0].next_page_url) {
                        observer.unobserve(scrollElement.value)
                    }
                })
                .catch(error => {
                    console.log(error)
                    observer.unobserve(scrollElement.value)
                })
        }
    }

    const intersectionObserver = new IntersectionObserver(loadMore)

    return {comments, scrollElement, intersectionObserver}
}
