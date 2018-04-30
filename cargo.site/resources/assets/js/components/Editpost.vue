<template id="post-edit">
    <div class="row">
        <h3>Редактирование записи</h3>
        <form v-on:submit.prevent="updatePost">
            <div class="form-row">
                <div class="col-md-3 form-group">
                    <label>Дата</label>
                    <input type="date" class="form-control" v-model="post.created_at">
                </div>
                <div class="col-md-3 form-group">
                    <label class="col-form-label">Тип</label>
                    <select class="list-group" v-model="post.type">
                        <option>Все</option>
                        <option value="Оплата">ОПЛАТА</option>
                        <option value="Долг">ДОЛГ</option>
                    </select>
                </div>
                <div class="col-md-3 form-group">
                    <label for="">Таблица</label>
                    <select class="form-control" v-model="table">
                        <option value="cargos">КАРГО</option>
                        <option value="debts">ДОЛГИ</option>
                    </select>
                </div>
                <div class="col-md-3 form-group">
                    <label for="">Сумма</label>
                    <input type="text" v-model="post.price" class="form-control">
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-3 form-group">
                    <label for="">Клиент</label>
                    <input list="client" v-model="post.client_name" @change="$event.target.select()"
                           @click="$event.target.select()" class="form-control">
                    <datalist id="client">
                        <option value="Все" selected>0</option>
                        <option v-for="(client,index) in clients" :key="index" v-bind:value="client.name">{{client.id}}
                        </option>
                    </datalist>
                </div>
                <div class="col-md-3 form-group">
                    <label for="">Мест</label>
                    <input type="text" v-model="post.count_place" class="form-control">
                </div>
                <div class="col-md-3 form-group">
                    <label for="">Вес</label>
                    <input type="text" v-model="post.kg" class="form-control">
                </div>
                <div class="col-md-3 form-group">
                    <label for="">Факс</label>
                    <input type="text" v-model="post.fax_name" class="form-control">
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12 form-group">
                    <label for="">Примечания</label>
                    <input type="text" v-model="post.notation" class="form-control">
                </div>
            </div>
            <button type="submit" class="btn btn-success">Сохранить</button>
            <router-link class="btn btn-warning" v-bind:to="'/'">Отмена</router-link>
        </form>
        <button @click="change()">Show</button>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                table: "cargos",
                post: [],
                clients: [],
                url: "http://cargo.site/"
            };
        },
        created() {
            Axios.get(this.url + "api/" + this.table + "/" + this.$route.params.id).then(response => response.data).then(response => {
                let data = response.data;
                data.created_at = data.created_at.split("-").reverse().join("-");
                this.post = data;
            });
            Axios.get(this.url + "api/clients").then(response => response.data).then(response => {
                this.clients = response.data;
            });
        },
        methods: {
            updatePost() {
                this.changeClientNameToID();
                Axios.patch(this.url + "api/" + this.table + "/" + this.$route.params.id, this.post).then(() => {
                    this.$router.push({name: "Listposts"});
                });
            },
            changeClientNameToID() {
                this.clients.forEach(element => {
                    if (this.post.client_name === element.name) {
                        this.post.client_id = element.id;
                    }
                });
            },
            change() {
                console.log(this.post);
            }
        }
    };
</script>