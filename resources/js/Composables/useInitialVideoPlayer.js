import Plyr from "plyr";
import Hls from "hls.js";
import "plyr/dist/plyr.css"
import {computed} from "vue";

export function useInitialVideoPlayer({playerElement, videoProp, authUserChannelId}) {

    const foundChannelInWatchHistory = computed(
        () => videoProp.watch_history.find(history => history?.channel_id === authUserChannelId)
    )

    const player = new Plyr(playerElement, {})

    if (!Hls.isSupported()) {
        playerElement.src = videoProp.video_url ?? ''
    } else {
        const hls = new Hls()
        hls.loadSource(videoProp.video_url ?? '')
        hls.attachMedia(playerElement)
        window.hls = hls
    }

    if (!foundChannelInWatchHistory.value) {
        let viewLogged = false
        player.on('timeupdate', (event) => {

            const percentagePlayed = Math.ceil((player.currentTime / player.duration) * 100)

            if (percentagePlayed > 5 && !viewLogged && authUserChannelId) {
                window.axios.put(
                    route('watch.history.update', {video: videoProp.id}),
                    {
                        channelId: authUserChannelId
                    }
                )

                viewLogged = true
            }
        })
    }

    return player
}
