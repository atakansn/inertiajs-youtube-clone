export default function useByteToOtherFormats(byte, showUnit = false) {
    let units = ['Bytes', 'KB', 'MB', 'GB', 'TB']

    if (byte === 0 || !byte || typeof byte === undefined) {
        return undefined
    }

    let calculateLog = +Math.floor(Math.log(byte) / Math.log(1024))

    return showUnit
        ? `${Math.round(byte / Math.pow(1024, calculateLog)).toFixed(2)} ${units[calculateLog]}`
        : +Math.round(byte / Math.pow(1024, calculateLog)).toFixed(2)
}
