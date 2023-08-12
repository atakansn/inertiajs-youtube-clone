export default function useImagePreview(event, imageEl) {
    const image = event.target.files[0]

    if(!image) return

    const reader = new FileReader()

    reader.onload = () => imageEl = event.target.result

    reader.readAsDataURL(image)

    return imageEl
}
