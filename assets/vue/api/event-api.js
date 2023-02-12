import axios from "axios";
function mapEventObject(event){
    return {
        title: event.title,
        content: event.content,
        images: event.images.map(i=>i["@id"]),
        train: event.train,
        category: event.category,
        tags: event.tags,
        trainFaults: event.trainFaults
    }
}
export default {
    findEvents(){
        return axios.get("/api/events?order%5BdateEdited%5D=desc")
    },
    findEvent(id){
        return axios.get(`/api/events/${id}`)
    },
    editEvent(event){
        return axios.put(`/api/events/${event.id}`,mapEventObject(event))
    },
    create(event){
        return axios.post("/api/events", mapEventObject(event))
    },
    deleteEvent(id){
        return axios.delete(`/api/events/${id}`)
    },
}