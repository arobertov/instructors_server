import {getField, updateField} from 'vuex-map-fields';
import eventApi from "../api/event-api";

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
    },
    getters: {
        getField,
        getItem: state => state.event,
        getItems: state => state.events,
        getError: state => state.error,
        isError: state => state.error !== null,
        hasEvents: state => state.events.length > 0,
        isOwner: state => state.event.owner.alias === window.user.alias
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
        createEventSuccess: (state, item) => state.events["hydra:member"].unshift(item),
        setError: (state, error) => state.error = error,
        setCategory: (state, category) => state.event.category = category,
        setTrainFaults: (state, trainFaults) => state.event.trainFaults = trainFaults,
        hasError: (state, isError) => state.isError = isError,
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
                return "?????????????? ?????????? ?????????????????? ??????????????!";
            } catch (e) {
                commit('hasError', true);
                commit('setError', e);
                return e;
            }
        }
    }
}
