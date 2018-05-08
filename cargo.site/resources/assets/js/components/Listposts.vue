<template id="post-list">
    <div class="row">
        <div>
            <div class="row">
                <div class="col-md-4">
                    <span class="glyphicon glyphicon-calendar"></span>
                    <input type="date" @change="fetchSearch" v-model="search.dateStart">
                    <input type="date" @change="fetchSearch" v-model="search.dateLast">
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
                    <select class="list-group" @change="changeTable">
                        <option value="cargos">КАРГО</option>
                        <option value="debts" v-bind:selected="table==='debts'">ДОЛГИ</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <span class="glyphicon glyphicon-th-list"></span>
                    <select class="list-group" v-model="search.typeTable" @change="fetchSearch">
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
        <div>{{notification}}</div>
        <button @click="change">Click</button>
        <div>
            <div class="row">
                <div class="col-xs-2">
                    <button type="button" @click="addNewPost" class="btn btn-block btn-success">
                        <span class="glyphicon glyphicon-plus"></span>
                        Добавить
                    </button>
                </div>
            </div>
            <div v-for="(post,index) in posty">
                <div class="row">
                    <div class="col-xs-2">
                        <label>&nbsp;</label>
                        <button type="button" @click="removePost(index)" class="btn btn-block btn-danger">
                            <span class="glyphicon glyphicon-minus"></span>
                            Удалить
                        </button>
                    </div>
                    <div class="form-group col-xs-5">
                        <label>Price (HUF)</label>
                        <input v-model="post.price" type="number"
                               name="posty[][price]" class="form-control" placeholder="Price">
                    </div>
                    <div class="form-group col-xs-5">
                        <label>Rooms (PCS)</label>
                        <input v-model="post.kg" type="number"
                               name="" class="form-control" placeholder="Rooms">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-2">
                    <button type="submit" class="btn btn-block btn-primary">
                        Сохранить
                    </button>
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
                post: {
                    created_at: '',
                    type: '',
                    price: '',
                    client_id: '',
                    count_place: '',
                    kg: '',
                    fax: '',
                    notation: ''
                },
                posty: []
            }
        },
        created() {
            this.fetchSearch();
            Axios.get(`${this.$store.state.url}api/clients`).then(response => response.data).then(response => {
                this.ADD_CLIENTS(response.data);
            });
        },
        computed: {
            ...mapState([
                'table',
                'posts',
                'search',
                'excel',
                'notification'
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
                'ADD_CLIENTS',
                'CHANGE_TABLE'
            ]),
            ...mapActions([
                'fetch',
                'destroy'
            ]),
            changeTable() {
                this.CHANGE_TABLE();
                this.fetchSearch();
            },
            fetchSearch() {
                this.fetch();
            },
            desroyEntry(id) {
                this.destroy(id);
                this.fetchSearch();
            },
            addNewPost() {
               this.posty.push(Vue.util.extend({}, this.post));
            },
            removePost(index){
                this.posty.splice(index,1);
            },
            change() {
                console.log(this.posty);
            }
        }
    };
</script>