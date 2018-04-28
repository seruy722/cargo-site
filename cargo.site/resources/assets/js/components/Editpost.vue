<template id="post-edit">
    <div class="row">
        <h3>Редактирование записи</h3>
        <form v-on:submit.prevent="updatePost">
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="validationDefault01">First name</label>
                    <input type="text" class="form-control" id="validationDefault01" placeholder="First name"
                           value="Mark" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationDefault02">Last name</label>
                    <input type="text" class="form-control" id="validationDefault02" placeholder="Last name"
                           value="Otto" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationDefaultUsername">Username</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupPrepend2">@</span>
                        </div>
                        <input type="text" class="form-control" id="validationDefaultUsername" placeholder="Username"
                               aria-describedby="inputGroupPrepend2" required>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="validationDefault03">City</label>
                    <input type="text" class="form-control" id="validationDefault03" placeholder="City" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="validationDefault04">State</label>
                    <input type="text" class="form-control" id="validationDefault04" placeholder="State" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="validationDefault05">Zip</label>
                    <input type="text" class="form-control" id="validationDefault05" placeholder="Zip" required>
                </div>
            </div>
            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="invalidCheck2" required>
                    <label class="form-check-label" for="invalidCheck2">
                        Agree to terms and conditions
                    </label>
                </div>
            </div>
            <button class="btn btn-primary" type="submit" @click="change()">Submit form</button>
            <div class="form-row">
                <div class="col-md-4 form-group">
                    <label col-form-label>Дата</label>
                    <input type="date" class="form-control" v-model="posts.created_at">
                </div>
                <div class="col-md-4 form-group">
                    <label col-form-label>Тип</label>
                    <input type="text" class="form-control" v-model="posts.type" disabled>
                </div>
                <div class="col-md-2 form-group">
                    <span class="glyphicon glyphicon-th-list"></span>
                    <select class="list-group" v-model="table">
                        <option value="cargos">КАРГО</option>
                        <option value="debts">ДОЛГИ</option>
                    </select>
                </div>
                <div class="col-md-2 form-group">
                    <input type="text" v-model="posts.price" class="form-control">
                </div>
                <div class="col-md-2 form-group">
                    <span class="glyphicon glyphicon-user"></span>
                    <input list="client" v-model="posts.client_name" @change="$event.target.select()"
                           @click="$event.target.select()" class="form-control">
                    <datalist id="client">
                        <option value="Все" selected>0</option>
                        <option v-for="(client,index) in clients" :key="index" v-bind:value="client.name">{{client.id}}
                        </option>
                    </datalist>
                </div>
                <div class="col-md-2 form-group">
                    <input type="text" v-model="posts.count_place" class="form-control">
                </div>
                <div class="col-md-1 form-group">
                    <input type="text" v-model="posts.kg" class="form-control">
                </div>
                <div class="col-md-1 form-group">
                    <input type="text" v-model="posts.fax_name" class="form-control">
                </div>
                <div class="col form-group">
                    <input type="text" v-model="posts.notation" class="form-control">
                </div>
            </div>
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
                url: "http://cargo.site/"
            };
        },
        created() {
            Axios.get(this.url + "api/cargos/" + this.$route.params.id).then(response => response.data).then(response => {
                let data = response.data;
                data.created_at = this.formatDate(data.created_at.date);
                this.posts = data;
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
                let yy = data.getFullYear();
                return yy + "-" + mm + "-" + dd;
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
            },
            change() {
                console.log(this.posts);
            }
        }
    };
</script>