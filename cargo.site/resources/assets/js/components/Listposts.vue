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
                        <option v-for="(client,index) in allClients" :key="index" v-bind:value="client.name">
                            {{client.id}}
                        </option>
                    </datalist>
                </div>
                <div class="col-md-2">
                    <span class="glyphicon glyphicon-th-list"></span>
                    <select class="list-group" @change="changeTable()">
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
    import {mapActions, mapGetters, mapMutations, mapState} from 'vuex';

    export default {
        data() {
            return {

            };
        },
        created() {
            Axios.get(this.$store.state.url + "api/" + this.table).then(response => response.data).then(response => {
                this.ADD_POSTS(response.data);
            });
            Axios.get(this.$store.state.url + "api/clients").then(response => response.data).then(response => {
                this.ADD_CLIENTS(response.data);
            });
        },
        computed: {
            ...mapState([
                'table',
                'posts',
                'search',
                'excel'
            ]),
            ...mapGetters([
                'totalPrice',
                'totalPlace',
                'totalKg',
                'totalCommission',
                'allClients'
            ])
        },
        methods: {
            ...mapMutations([
                'ADD_POSTS',
                'ADD_CLIENTS',
                'CHANGE_TABLE',
                'TOTAL_CALCULATED',
                'CHANGE_CLIENT_NAME_TO_ID',
                'PREPARE_DATA_TO_EXCEL'
            ]),
            ...mapActions([
                'fetch'
            ]),
            changeTable() {
                this.CHANGE_TABLE();
                this.fetchSearch();
            },
            fetchSearch() {
                this.fetch();
            },
            desroyEntry(id) {
                if (confirm('Удалить запись?')) {
                    Axios.delete(this.url + "api/" + this.table + "/" + id).then(response => {
                        this.fetchSearch();
                    });
                }
            }
        }
    };
</script>