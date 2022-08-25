import axios from "axios";

export default {
    findEvents(){
        return axios.get("/api/events?order%5BdateEdited%5D=desc")
    },
    findEvent(id){
        return axios.get(`/api/events/${id}`)
    },
    editEvent(event){
        return axios.put(`/api/events/${event.id}`,{
            title: event.title,
            content: event.content,
            images: event.images.map(i=>i["@id"]),
            train: event.train,
            category: event.category,
            tags: event.tags,
            trainFaults: event.trainFaults
        });
    },
    create(event){
        return axios.post(
            "/api/events",
            {
                title: event.title,
                content: event.content,
                images: event.images.map(i=>i["@id"]),
                train: event.train,
                category: event.category,
                tags: event.tags,
                trainFaults: event.trainFaults
            }
        )
    },
    deleteEvent(id){
        return axios.delete(`/api/events/${id}`)
    },
}