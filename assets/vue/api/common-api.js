import axios from "axios";

export default {
    findTrains(){
        return axios.get("/api/trains");
    },
    findHMIMessages(){
        return axios.get('/api/train_faults');
    },
    findCategories(){
        return axios.get('/api/categories');
    },
    createCategory(category){
        return axios.post('/api/categories',{name:category});
    },
    editCategory(category){
        return axios.put(category.url,{name:category.name});
    },
    deleteCategory(url){
        return axios.delete(url);
    }
}