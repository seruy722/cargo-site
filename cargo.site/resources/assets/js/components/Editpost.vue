<template id="post-edit">
    <div class="row">
        <h3>Редактирование записи</h3>
        <form v-on:submit.prevent = "updatePost">
            <input type="date">
            <select class="list-group" v-model="typeTable">
                <option value="Оплата">ОПЛАТА</option>
                <option value="Долг">ДОЛГ</option>
            </select>
            <input type="text" v-model="posts.price">
            <div>
                <span class="glyphicon glyphicon-user"></span>
                <input list="client" v-model="client"  @change="$event.target.select()"
                       @click="$event.target.select()">
                <datalist id="client">
                    <option value="Все">0</option>
                    <option v-for="(client,index) in clients" :key="index" v-bind:value="client.name">{{client.id}}
                    </option>
                </datalist>
            </div>
            <input type="text" v-model="posts.count_place">
            <input type="text" v-model="posts.kg">
            <input type="text" v-model="posts.fax_name">
            <input type="text" v-model="posts.notation">
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                table: "cargos",
                posts: [],
                clients: [],
                client:null,
                clientID:null,
                typeTable:null,
                notification: null,
                url: "http://cargo.site/"
            };
        },
        created() {
            Axios.get(this.url + "api/cargos/"+this.$route.params.id).then(response => response.data).then(response => {
                this.posts = response.data;
            });
            Axios.get(this.url + "api/clients").then(response => response.data).then(response => {
                this.clients = response.data;
            });
        },
        methods: {
            formatDate(date) {
                let data = new Date(date);
                let dd = data.getDate();
                if (dd < 10) dd = "0" + dd;
                let mm = data.getMonth() + 1;
                if (mm < 10) mm = "0" + mm;
                let yy = data.getFullYear() % 100;
                if (yy < 10) yy = "0" + yy;
                return dd + "." + mm + "." + yy;
            },
            changeClientNameToID() {
                this.clients.forEach(element => {
                    if (this.search.client == 'Все') {
                        this.search.clientID = null;
                    }
                    if (element.name == this.search.client) {
                        this.search.clientID = element.id;
                    }
                });
            }
        }
    };
</script>