import commonApi from "../api/common-api";

export default {
    namespaced: true,
    state:{
        train:'',
        trains:[],
        error:null
    },
    getters:{
        getItem:state=>state.train,
        getItems:state=>state.trains,
    },
    mutations:{
        setItem:(state,item)=>state.train = item,
        setItems:(state,items)=>state.trains = items,
        setError:(state,error)=>state.error = error,
    },
    actions:{
        async findTrains({commit}){
           try{
             let response = await commonApi.findTrains();
             commit('setItems',response.data);
           }catch (e) {
                commit('setError',e);
           }
        }
    }
}