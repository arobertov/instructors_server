import commonApi from "../api/common-api";

export default {
    namespaced: true,
    state:{
        trainFault:'',
        trainFaults:[],
    },
    getters:{
        getItem:state=>state.trainFault,
        getItems:state=>state.trainFaults,
    },
    mutations:{
        setItem:(state,item)=>state.trainFault = item,
        setItems:(state,items)=>state.trainFaults = items,
        setError:(state,error)=>state.error = error,
    },
    actions:{
        async findTrainFaults({commit}){
            try{
                let response = await commonApi.findHMIMessages();
                commit('setItems',response.data);
                return response;
            }catch (e) {
                commit('setError',e);
            }
        }
    }
}