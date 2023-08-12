export function useFormattedDuration(duration) {

    if (!duration || isNaN(duration)) return '00:00'

    const padZero = value => value.toString().padStart(2, '0')

    const hours = Math.floor(duration / 3600)
    const minutes = Math.floor((duration % 3600) / 60)
    const seconds = duration % 60

    if (hours > 0) {
        return `${padZero(hours)}:${padZero(minutes)}:${padZero(seconds)}`
    } else if(minutes > 0) {
        return `${padZero(minutes)}:${padZero(seconds)}`
    } else {
        return `00:${padZero(seconds)}`
    }

}
