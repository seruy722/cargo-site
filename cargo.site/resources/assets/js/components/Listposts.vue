<template id="post-list">
    <div class="row">
        <div class="pull-right">
            <router-link class="btn btn-sm btn-primary" v-bind:to="{path:'/add-post'}">
                <span class="glyphicon glyphicon-plus"></span>
                Оплата
            </router-link>
            <router-link class="btn btn-sm btn-primary" v-bind:to="{path:'/post'}">
                <span class="glyphicon glyphicon-plus"></span>
                Долг
            </router-link>
            <download-excel
                    class="btn btn-success"
                    :data='excel.excelData'
                    :fields="excel.json_fields"
                    :name="search.keyword">
                Excel
            </download-excel>
            <br><br>
            <button @click="change()">Send</button>
        </div>
        <div>
            <label for="date1">Дата</label>
            <input type="date" @change="fetchSearch()" v-model="search.date1">
            <input type="date" @change="fetchSearch()" v-model="search.date2">
            <div>
                <input list="client" v-model="search.keyword" @change="fetchSearch()">
                <datalist id="client">
                    <option value="">Все</option>
                    <option v-for="(client,index) in clients" :key="index" v-bind:value="client.id">{{client.name}}
                    </option>
                </datalist>
            </div>
            <select class="list-group" v-model="table" @change="fetchSearch()">
                <option value="cargos">КАРГО</option>
                <option value="debts">ДОЛГИ</option>
            </select>
        </div>
        <div v-if="this.table==='cargos'">
            <div v-if="this.posts.length">
                <span>Сумма: {{search.price}}</span>|
                <span>Кол. мест: {{search.countPlace}}</span>|
                <span>Вес: {{search.kg}}</span>
            </div>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>№</th>
                    <th>Дата</th>
                    <th>Тип</th>
                    <th>Сумма</th>
                    <th>Пользователь</th>
                    <th>Мест</th>
                    <th>Вес</th>
                    <th>Факс</th>
                    <th>Примечание</th>
                    <th class="col-md-2">Действия</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(post, i) in filteredPosts" :key="post.id"
                    v-bind:class="{'danger':post.type=='Долг','success':post.type=='Оплата'}">
                    <td>{{i + 1}}</td>
                    <td v-for="(element,index) in post" :key="element.id" v-if="index!='id'">{{element}}</td>
                    <td>
                        <router-link class="btn btn-sm btn-warning" v-bind:to="{name:'Editpost',params:{id:post.id}}">
                            Редактировать
                        </router-link>
                        <router-link class="btn btn-sm btn-danger" v-bind:to="{name:'Deletepost',params:{id:post.id}}">
                            Удалить
                        </router-link>
                    </td>
                </tr>
                </tbody>
            </table>
            <div v-if="!this.posts.length">Нет записей</div>
        </div>
        <div v-if="this.table==='debts'">
            <div v-if="this.posts.length">
                <span>Сумма: {{search.price}}</span>|
                <span>Комиссия: {{search.commission}}</span>
            </div>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>№</th>
                    <th>Дата</th>
                    <th>Тип</th>
                    <th>Сумма</th>
                    <th>Пользователь</th>
                    <th>Комиссия</th>
                    <th>Примечание</th>
                    <th class="col-md-2">Действия</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(post, i) in filteredPosts" :key="post.id"
                    v-bind:class="{'danger':post.type=='Долг','success':post.type=='Оплата'}">
                    <td>{{i + 1}}</td>
                    <td v-for="(element,index) in post" :key="element.id" v-if="index!='id'">{{element}}</td>
                    <td>
                        <router-link class="btn btn-sm btn-warning" v-bind:to="{name:'Editpost',params:{id:post.id}}">
                            Редактировать
                        </router-link>
                        <router-link class="btn btn-sm btn-danger" v-bind:to="{name:'Deletepost',params:{id:post.id}}">
                            Удалить
                        </router-link>
                    </td>
                </tr>
                </tbody>
            </table>
            <div v-if="!this.posts.length">Нет записей</div>
        </div>

    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                table: "cargos",
                posts: [],
                clients: [],
                url: "http://cargo.site/",
                search: {
                    keyword: "",
                    date1: null,
                    date2: null,
                    selected: [],
                    price: 0,
                    countPlace: 0,
                    kg: 0,
                    commission: 0
                },
                excel: {
                    json_fields: {},
                    excelData: [],
                    json_meta: [
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
        created: function () {
            Axios.get(this.url + "api/cargos").then(response => response.data).then(response => {
                this.posts = response.data;
            });
            Axios.get(this.url + "api/clients").then(response => response.data).then(response => {
                this.clients = response.data;
            });
        },
        computed: {
            filteredPosts: function () {
                if (this.posts.length) {
                    this.search.price = 0;
                    this.search.countPlace = 0;
                    this.search.kg = 0;
                    this.search.commission = 0;
                    let arrayForPosts = [];
                    this.posts.forEach(element => {
                        this.search.price += element["price"];
                        this.search.countPlace += element["count_place"];
                        this.search.kg += element["kg"];
                        this.search.commission += element["commission"];
                        let elem = element;
                        elem.created_at = this.formatDate(elem.created_at.date);
                        arrayForPosts.push(elem);
                    });
                    this.posts = arrayForPosts;
                    return this.posts;
                }
                this.prepareDataToExcel();
            }
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
            fetchSearch() {
                if (this.table === "cargos") {
                    Axios.post(this.url + "api/search/cargos", {
                        keyword: this.search.keyword,
                        date1: this.search.date1,
                        date2: this.search.date2,
                        table: this.table
                    }).then(response => response.data).then(response => {
                        this.posts = response.data;
                    });
                } else {
                    Axios.post(this.url + "api/search/debts", {
                        keyword: this.search.keyword,
                        date1: this.search.date1,
                        date2: this.search.date2,
                        table: this.table
                    }).then(response => response.data).then(response => {
                        this.posts = response.data;
                    });
                }
                this.prepareDataToExcel();
            },
            prepareDataToExcel() {
                this.excel.excelData = [];
                if (this.table === "cargos") {
                    this.excel.json_fields = {
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
                    this.excel.json_fields = {
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
            change() {
                console.log(this.excel.excelData);
            }
        }
    };
</script>