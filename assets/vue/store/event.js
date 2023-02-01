import {getField, updateField} from 'vuex-map-fields';
import eventApi from "@vue/api/event-api";

const initializeEvent = {
    title: '',
    content: '',
    category: null,
    train: null,
    images: [],
    tags: [],
    trainFaults: []
}
export default {
    namespaced: true,
    state: {
        event: {
            title: '',
            content: '',
            category: null,
            train: null,
            images: [],
            tags: [],
            trainFaults: []
        },
        events: [],
        error: null,
        isError: false,
        isSuccess:false,
        successMessage:null,
    },
    getters: {
        getField,
        getItem: state => state.event,
        getImages:state=>state.event.images,
        getItems: state => state.events,
        getError: state => state.error,
        isError: state => state.error !== null,
        hasEvents: state => state.events.length > 0,
    },
    mutations: {
        updateField,
        creatingEvent(state) {
            state.event = {
                title: '',
                content: '',
                category: null,
                train: null,
                images: [],
                tags: [],
                trainFaults: []
            };
            state.error = null;
            state.isError = false;
        },
        setItem: (state, item) => state.event = item,
        setItems: (state, items) => state.events = items,
        createEventSuccess: (state, item) => {
            state.events["hydra:member"].unshift(item);
            state.events["hydra:totalItems"] += 1;
        },
        setError: (state, error) => state.error = error,
        setCategory: (state, category) => state.event.category = category,
        attachImages:(state,images)=>state.event.images = images,
        setTrainFaults: (state, trainFaults) => state.event.trainFaults = trainFaults,
        hasError: (state, isError) => state.isError = isError,
        deleting:(state)=>{state.isError=false;state.error='';state.isSuccess=false;state.successMessage=''},
        deletingSuccess:(state,eventID)=>{
            state.events["hydra:member"] = state.events["hydra:member"].filter(e=>e.id!==eventID);
            state.events["hydra:totalItems"] -= 1;
            state.isError=false;;
            state.error='';
            state.isSuccess=true;
            state.successMessage='Събитието бе успешно изтрито!';
        }
    },
    actions: {
        async findEvents({commit}) {
            try {
                const response = await eventApi.findEvents()
                commit('setItems', response.data);
                return response.data;
            } catch (e) {
                commit('hasError', true);
                commit('setError', e);
                return e;
            }
        },
        async findEvent({commit}, id) {
            try {
                const response = await eventApi.findEvent(id)
                commit('setItem', response.data)
                return response.data;
            } catch (e) {
                commit('hasError', true);
                commit('setError', e);
                return e;
            }
        },
        async createEvent({commit}, event) {
            try {
                const response = await eventApi.create(event);
                if (response.status === 201) {
                    commit('setItem', response.data);
                    commit('createEventSuccess', response.data)
                    return response.data;
                }
                return "Сърврът върна неочакван отговор!";
            } catch (e) {
                commit('hasError', true);
                commit('setError', e);
                return e;
            }
        },
        async deleteEvent({commit},id){
            try {
                commit('deleting')
                const response = await eventApi.deleteEvent(id);
                commit('deletingSuccess',id)
                console.log(response.status)
                return response.data;

            }catch (e) {
                commit('hasError', true);
                commit('setError', e);
                return e;
            }
        }
    }
}
