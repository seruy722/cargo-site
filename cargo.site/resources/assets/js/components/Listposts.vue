<template id="post-list">
    <div class="row">
        <div>
            <div class="row">
                <div class="col-md-4">
                    <span class="glyphicon glyphicon-calendar"></span>
                    <input type="date" @change="fetchSearch()" v-model="search.dateStart">
                    <input type="date" @change="fetchSearch()" v-model="search.dateLast">
                </div>
                <div class="col-md-3">
                    <span class="glyphicon glyphicon-user"></span>
                    <input list="client" v-model="search.client" @change="$event.target.select();fetchSearch()"
                           @click="$event.target.select()">
                    <datalist id="client">
                        <option value="Все">0</option>
                        <option v-for="(client,index) in clients" :key="index" v-bind:value="client.name">{{client.id}}
                        </option>
                    </datalist>
                </div>
                <div class="col-md-2">
                    <span class="glyphicon glyphicon-th-list"></span>
                    <select class="list-group" v-model="anotherTable" @change="changeTable()">
                        <option value="cargos">КАРГО</option>
                        <option value="debts">ДОЛГИ</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <span class="glyphicon glyphicon-th-list"></span>
                    <select class="list-group" v-model="search.typeTable" @change="fetchSearch()">
                        <option v-bind:value="null">Все</option>
                        <option value="Оплата">ОПЛАТА</option>
                        <option value="Долг">ДОЛГ</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <download-excel
                            class="btn btn-success"
                            :data='excel.excelData'
                            :fields="excel.jsonFields"
                            :meta="excel.jsonMeta"
                            :name="search.client">
                        Excel
                    </download-excel>
                    <br><br>
                </div>
            </div>
            <h3>{{$store.state.calculated.price}}</h3>
        </div>
        <div v-if="this.table==='cargos'">
            <div v-if="this.posts.length">
                <span>Сумма: {{totalPrice}}</span>|
                <span>Кол. мест: {{totalPlace}}</span>|
                <span>Вес: {{totalKg}}</span>
            </div>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>№</th>
                    <th>Дата</th>
                    <th>Тип</th>
                    <th>Сумма</th>
                    <th>Клиент</th>
                    <th>Мест</th>
                    <th>Вес</th>
                    <th>Факс</th>
                    <th>Примечание</th>
                    <th class="col-md-1">Действия</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(post, i) in posts" :key="post.id"
                    v-bind:class="{'danger':post.type=='Долг','success':post.type=='Оплата'}">
                    <td>{{i + 1}}</td>
                    <td v-for="(element,index) in post" :key="element.id" v-if="index!='id'">{{element}}</td>
                    <td>
                        <router-link class="btn btn-sm btn-warning glyphicon glyphicon-edit"
                                     v-bind:to="{name:'Editpost',params:{id:post.id}}">

                        </router-link>
                        <button class="btn btn-sm btn-danger glyphicon glyphicon-remove"
                                @click="desroyEntry(post.id)">
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
            <div v-if="!this.posts.length">Нет записей</div>
        </div>
        <div v-if="this.table==='debts'">
            <div v-if="this.posts.length">
                <span>Сумма: {{totalPrice}}</span>|
                <span>Комиссия: {{totalCommission}}</span>
            </div>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>№</th>
                    <th>Дата</th>
                    <th>Тип</th>
                    <th>Сумма</th>
                    <th>Клиент</th>
                    <th>Комиссия</th>
                    <th>Примечание</th>
                    <th class="col-md-2">Действия</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(post, i) in posts" :key="post.id"
                    v-bind:class="{'danger':post.type==='Долг','success':post.type==='Оплата'}">
                    <td>{{i + 1}}</td>
                    <td v-for="(element,index) in post" :key="element.id" v-if="index!='id'">{{element}}</td>
                    <td>
                        <router-link class="btn btn-sm btn-warning glyphicon glyphicon-edit"
                                     v-bind:to="{name:'Editpost',params:{id:post.id}}">
                        </router-link>
                        <button class="btn btn-sm btn-danger glyphicon glyphicon-remove"
                                @click="desroyEntry(post.id)">
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
            <div v-if="!this.posts.length">Нет записей</div>
        </div>
    </div>
</template>

<script>
    import {mapGetters, mapMutations, mapState,mapActions} from 'vuex';

    export default {
        data() {
            return {
                anotherTable: '',
                notification: null,
                search: {
                    typeTable: null,
                    client: null,
                    clientID: null,
                    dateStart: null,
                    dateLast: null,
                    selected: [],
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
            };
        },
        created() {
            Axios.get(this.url + "api/" + this.table).then(response => response.data).then(response => {
                this.addPosts(response.data);
                this.totalCalculated();
            });
            Axios.get(this.url + "api/clients").then(response => response.data).then(response => {
                this.addClients(response.data);
            });
        },
        computed: {
            ...mapState([
                'table',
                'posts',
                'clients',
                'url'
            ]),
            ...mapGetters([
                'totalPrice',
                'totalPlace',
                'totalKg',
                'totalCommission'
            ]),
        },
        methods: {
            ...mapMutations([
                'addPosts',
                'addClients',
                'CHANGE_TABLE'
            ]),
            changeTable() {
                this.CHANGE_TABLE(this.anotherTable);
                this.fetchSearch();
            },
            ...mapActions([
                'totalCalculated'
            ]),
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
            fetchSearch() {
                this.changeClientNameToID();
                Axios.post(this.url + "api/search/" + this.table, {
                    keyword: this.search.clientID,
                    dateStart: this.search.dateStart,
                    dateLast: this.search.dateLast,
                    table: this.table,
                    typeTable: this.search.typeTable
                }).then(response => response.data).then(response => {
                    this.addPosts(response.data);
                });
                this.totalCalculated();
            },
            prepareDataToExcel() {
                this.excel.excelData = [];
                if (this.table === "cargos") {
                    this.excel.jsonFields = {
                        Дата: "created_at",
                        Тип: "type",
                        Сумма: "price",
                        Пользователь: "client_name",
                        Мест: "count_place",
                        Вес: "kg",
                        Факс: "fax_name",
                        Примечания: "notation"
                    };
                } else {
                    this.excel.jsonFields = {
                        Дата: "created_at",
                        Тип: "type",
                        Сумма: "price",
                        Пользователь: "client_name",
                        Комиссия: "commission",
                        Примечания: "notation"
                    };
                }
                this.excel.excelData = this.posts;
            },
            desroyEntry(id) {
                let answer = confirm('Удалить запись?');
                if (answer) {
                    Axios.delete(this.url + "api/" + this.table + "/" + id).then(response => {
                        this.fetchSearch();
                        this.notification = response.data;
                    });
                }
            },
            change() {
                console.log(this.button);
            }
        }
    };
</script>