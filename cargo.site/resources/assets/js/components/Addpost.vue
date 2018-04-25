<template id="post-list">
  <div class="row">
     <div class="pull-right">
          <router-link class="btn btn-sm btn-primary" v-bind:to="{path:'/add-post'}">
              <span class="glyphicon glyphicon-plus"></span>
              Добавить КАРГО
          </router-link>
          <br><br>
      </div>
      <div>
        <label for="date1">Дата</label>
          <input type="date" @change="fetch()" v-model="search.date1">
          <input type="date" @change="fetch()" v-model="search.date2">

              <input type="text" @keyup="fetch()"  v-model="keywords" class="form-control" placeholder="Введите первый символ">
              <select class="form-control" v-model="keywords" @change="fetch()">
                  <option value="">Все</option>
                  <option v-for="client in search.clients" :key="client" v-bind:value="client">{{client}}</option>
              </select>
               <select class="form-control" v-model="keywords">
                  <option value="">Все</option>
                  <option value="">КАРГО</option>
                  <option value="">ДОЛГИ</option>
              </select>
      </div>
      <div>
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
              <tr v-for="(post, index) in FilteredPosts" :key="post.id" v-bind:class="{'danger':post.type=='Долг','success':post.type=='Оплата'}">
                  <td>{{index + 1}}</td>
                  <td>{{formatDate(post.created_at)}}</td>
                  <td>{{post.type}}</td>
                  <td @change="change()">{{post.price}}</td>
                  <td>{{post.client_id}}</td>
                  <td>{{post.count_place}}</td>
                  <td>{{post.kg}}</td>
                  <td>{{post.fax_name}}</td>
                  <td>{{post.notation}}</td>
                  <td>
                      <router-link class="btn btn-sm btn-warning" v-bind:to="{name:'Editpost',params:{id:post.id}}">Редактировать</router-link>
                      <router-link class="btn btn-sm btn-danger" v-bind:to="{name:'Deletepost',params:{id:post.id}}">Удалить</router-link>
                  </td>
              </tr>
          </tbody>
      </table>
  </div>
</template>


<script>
export default {
  data: function() {
    return {
      keywords: null,
      posts: "",
      url: "http://exel.site/",
      search: {
        date1: null,
        date2: null,
        selected: [],
        price: 0,
        countPlace: 0,
        kg: 0,
        clients: []
      }
    };
  },
  created: function() {
    Axios.get(this.url + "posts/").then(response => {
      this.posts = response.data;
    });
  },
  computed: {
    FilteredPosts: function() {
      if (this.posts.length) {
        this.search.price = 0;
        this.search.countPlace = 0;
        this.search.kg = 0;
        this.search.clients = [];
        this.posts.forEach(element => {
          this.search.price += element["price"];
          this.search.countPlace += element["count_place"];
          this.search.kg += element["kg"];
          this.search.clients.push(element["client_id"]);
        });
        this.search.clients = this.search.clients.filter(
          (value, index, arr) => arr.indexOf(value) === index
        );
        return this.posts;
      }
    }
  },
  methods: {
    formatDate: function(date) {
      let data = new Date(date);
      let dd = data.getDate();
      if (dd < 10) dd = "0" + dd;
      let mm = data.getMonth() + 1;
      if (mm < 10) mm = "0" + mm;
      let yy = data.getFullYear() % 100;
      if (yy < 10) yy = "0" + yy;
      return dd + "." + mm + "." + yy;
    },
    fetch() {
      Axios.post(this.url + "search", {
        keywords: this.keywords,
        date1: this.search.date1,
        date2: this.search.date2
      }).then(response => {
        this.posts = response.data;
      });
    },
    change() {
      alert(this.search.date1);
    }
  }
};
</script>