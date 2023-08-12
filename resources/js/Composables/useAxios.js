export const useAxios = ({url, data, method, config}) => {
    if(!method) {
        return () => window.axios.get(url, config)
    }

    if(method.toLowerCase() === 'post') {
        return async () => {
            try{
                const {data} = window.axios.post(url, data, config)
            } catch (e){
                console.log(e)
            }
        }
    }
}