import axios from "axios";

export default {
    findTrains(){
        return axios.get("/api/trains");
    },
    findHMIMessages(){
        return axios.get('/api/train_faults');
    },
    findCategories(){
        return axios.get('/api/categories?page=1&order%5Bname%5D=asc');
    },
    findCategory(id){
      return axios.get(`/api/categories/${id}`);
    },
    createCategory(category){
        return axios.post('/api/categories',{name:category});
    },
    editCategory(category){
        return axios.put(category.url,{name:category.name});
    },
    deleteCategory(url){
        return axios.delete(url);
    },
    uploadImage(data){
        return axios.post('/api/images',data,
            { headers: {'content-type': 'multipart/form-data' }
            });
    },
    showImage(imageId){
        return axios.get('/api/images/'+imageId);
    },
    findAllImages(){
        return axios.get('/api/images');
    },
    deleteImage(imageIri){
        return axios.delete(imageIri);
    }
}