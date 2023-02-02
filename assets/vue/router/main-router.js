import VueRouter from "vue-router";
import IndexView from "../views/IndexView";
import EventView from "../views/Event/EventView";
import EventCreate from "../views/Event/EventCreateView";
import CategoriesList from "../views/Category/CategoriesListView";
import ListEvents from "../components/ListEventsComponent";
import HMIMessages from "../components/HMIMessagesComponent";
import EventPreview from "../views/Event/EventPreview";
import EditEvent from "@vue/components/event-components/EditEventComponent";
import EventsByCategory from "@vue/views/Event/EventsByCategoryView";

export default new VueRouter({
    mode:'history',
    routes: [
        {
            path: "/",
            name: "site_index",
            component: IndexView,
            meta:{
                requiresAuth: false,
                item:[{text:'Начало',to:{name:'site_index'}}]
            }
        },
        {
            path: "/events",
            component: EventView,
            children:[
                {
                    path:"",
                    name: "site_events",
                    component:ListEvents,
                    meta:{
                        requiresAuth: true,
                        item:[
                            {text:'Начало',to:{name:'site_index'}},
                            {text:'Събития',to:{name:'site_events'}}
                        ]
                    },
                },
                {
                    path:"create",
                    name:"site_events_create",
                    component: EventCreate,
                    meta:{
                        requiresAuth: true,
                        item:[
                            {text:'Начало',to:{name:'site_index'}},
                            {text:'Събития',to:{name:'site_events'}},
                            {text:'Публикуване на събитие',to:{name:'site_events_create'}}
                        ]
                    }
                },
                {
                    path:"preview/:id",
                    name:"site_event_preview",
                    component: EventPreview,
                    meta:{
                        requiresAuth: true,
                        item:[
                            {text:'Начало',to:{name:'site_index'}},
                            {text:'Събития',to:{name:'site_events'}},
                            {text:'Прегледай събитие',to:{name:'site_event_preview'}}
                        ]
                    }
                },
                {
                    path:"edit/:id",
                    name:"site_edit_preview",
                    component: EditEvent,
                    meta:{
                        requiresAuth: true,
                        item:[
                            {text:'Начало',to:{name:'site_index'}},
                            {text:'Събития',to:{name:'site_events'}},
                            {text:'Редактирай събитие',to:{name:'site_edit_preview'}}
                        ]
                    }
                },
                {
                    path:"preview/by-category/:category_id",
                    name:"site_event_by_category_preview",
                    component: EventsByCategory,
                    meta:{
                        requiresAuth: true,
                        item:[
                            {text:'Начало',to:{name:'site_index'}},
                            {text:'Събития',to:{name:'site_events'}},
                            {text:'Събития по категории',to:{name:'site_event_by_category_preview'}}
                        ]
                    }
                },
            ]
        },
        {
            path:"/categories",
            name:"categories_list",
            component: CategoriesList,
            meta:{
                requiresAuth: true,
                item:[
                    {text:'Начало',to:{name:'site_index'}},
                    {text:'Категории',to:{name:'categories_list'}}
                ]
            },
        },
        {
            path:"/hmi-messages",
            name:"hmi_messages",
            component:HMIMessages,
            meta:{
                requiresAuth: true,
                item:[
                    {text:'Начало',to:{name:'site_index'}},
                    {text:'Съобщения HMI',to:{name:'hmi_messages'}}
                ]
            },
        },
    ]
})
















