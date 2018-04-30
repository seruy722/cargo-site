import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        table: "cargos",
        posts: [],
        clients: [],
        // notification: null,
        url: "http://cargo.site/",
        calculated: {
            price: 0,
            countPlace: 0,
            kg: 0,
            commission: 0
        },
        search: {
            typeTable: null,
            client: null,
            clientID: null,
            dateStart: null,
            dateLast: null,
            selected: []
        },
        excel: {
            jsonFields: {},
            excelData: [],
            jsonMeta: [
                [
                    {
                        key: "charset",
                        value: "utf-8"
                    }
                ]
            ]
        }
    },
    getters: {
        totalPrice: state => {
            return state.calculated.price;
        },
        totalPlace: state => {
            return state.calculated.countPlace;
        },
        totalKg: state => {
            return state.calculated.kg;
        },
        totalCommission: state => {
            return state.calculated.commission;
        }
    },
    mutations: {
        addPosts: (state, posts) => {
            state.posts = posts;
        },
        addClients: (state, clients) => {
            state.clients = clients;
        },
        CHANGE_TABLE: (state, table) => {
            state.table = table;
        },
        TOTAL_CALCULATED: state => {
            state.posts.forEach(element => {
                state.calculated.price += element["price"];
                state.calculated.countPlace += element["count_place"];
                state.calculated.kg += element["kg"];
                state.calculated.commission += element["commission"];
            });
        }
    },
    actions: {
        totalCalculated:(context,element)=>{
            context.commit('TOTAL_CALCULATED',element);
        }
    }

});