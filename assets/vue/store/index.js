import Vue from "vue";
import Vuex from "vuex";
import UserModule from "./user";
import CategoryModule from "./category";
import EventModule from "./event";
import TrainModule from "./train";
import TrainFaults from "./trainFaults";
Vue.use(Vuex);

export default new Vuex.Store({
    modules:{
        UserModule:UserModule,
        EventModule:EventModule,
        CategoryModule:CategoryModule,
        TrainModule:TrainModule,
        TrainFaults:TrainFaults,
    }
});