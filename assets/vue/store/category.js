import {getField, updateField} from 'vuex-map-fields';
import commonApi from "../api/common-api";

export default {
    namespaced: true,
    state:{
        category:null,
        categories:[],
        error:null,
        hasCategories:false,
        isError:false,
        isLoading:false,
        isSuccess:false,
        message:null,
    },
    getters: {
        getField:state=>getField(state.category),
        getCategory: state => state.category,
        getCategories: (state) => state.categories,
        getError: (state) => state.error,
        getMessage:(state)=>state.message,
        hasCategories: (state) => state.categories.length > 0,
        hasError: (state) => state.isError,
        getIsSuccess:(state)=>state.isSuccess,
    }
        ,
    mutations:{
        updateField,
        setItem:(state,item)=>state.category = item,
        setItems:(state,items)=>state.categories = items,
        setError:(state,error)=>state.error = error,
        hasError:(state,isError)=>state.isError = isError,
        setMessage:(state,message)=> state.message = message,
        setIsSuccess:(state,isSuccess)=>state.isSuccess=isSuccess,
        creatingCategory(state){
            state.isError = false;
            state.isSuccess = false;
            state.message = null;
            state.error = '';
        },
        actionSuccessful(state){
            state.isError = false;
            state.isSuccess = false;
            state.message = null;
        },
        deleteSuccessful(state,item){
            state.isSuccess = true;
            state.message = "Категорията е изтрита успешно!";
            state.category = {};
        }
    },
    actions:{
        async createCategory({commit},category){
            try {
                commit('creatingCategory');
                let response = await commonApi.createCategory(category);
                if(response.status===201){
                    commit('setItem',response.data);
                    commit('setIsSuccess',true);
                    commit('setMessage','Категорията '+ response.data.name + ' е създадена успешно!');
                    return response.data;
                }
                return "Сърврът върна неочакван отговор!"
            }catch (e) {
                commit('hasError',true);
                commit('setError',e);
                return e;
            }
        },
        async editCategory({commit},category){
            try {
                let response = await commonApi.editCategory(category);
                if(response.status===200){
                    commit('setItem',response.data);
                    commit('setIsSuccess',true);
                    commit('setMessage','Категорията '+ response.data.name + ' е редактирана успешно!');
                    return response.data;
                }
                return "Сърврът върна неочакван отговор!"
            }catch (e) {
                commit('hasError',true);
                commit('setError',e);
                return e;
            }

        },
        async deleteCategory({commit},url){
            try {
                let response = await commonApi.deleteCategory(url);
                if(response.status === 204){
                    commit('deleteSuccessful',url)
                }
                return response.status;
            }catch (e) {
                    commit('hasError',true);
                    commit('setError',e);
                    return e;
            }
        },
        async findCategories({commit}){
            try{
                let response = await commonApi.findCategories();
                commit('setItems',response.data);
            }catch (e) {
                commit('hasError',true);
                commit('setError',e);
            }
        },
        async findCategory({commit},id){
            try{
               let response = await commonApi.findCategory(id);
               commit('setItem',response.data);
            }catch (e) {
                commit('hasError',true);
                commit('setError',e);
            }
        }
    }
}