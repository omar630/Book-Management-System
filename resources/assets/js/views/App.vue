<template>
  <div class="container">
    <div class="text-center" style="margin: 20px 0px 20px 0px;">
      <h1>
        Book Management System
      </h1>
    </div>
    <nav class="navbar navbar-expand-sm navbar-light bg-light">
      <div class="collapse navbar-collapse">
        <div class="navbar-nav">
          <router-link :to="{ name: 'home' }" class="nav-item nav-link">
            Home
          </router-link>
          <router-link :to="{ name: 'addBook' }" class="nav-item nav-link">
            Add Book
          </router-link>
          <router-link :to="{ name: 'deletedList' }" class="nav-item nav-link">
            view deleted books
          </router-link>
          <div v-if="authenticated && user">
            <button @click.prevent="logout" class="nav-item nav-link" type="button">
              <i class="fa fa-sign-in">
              </i>
              Logout
            </button>
          </div>
          <div v-else="" style="display: contents;">
            <router-link class="nav-item nav-link" to="/api/login">
              Login
            </router-link>
            <router-link class="nav-item nav-link" to="/api/register">
              Register
            </router-link>
          </div>
        </div>
      </div>
    </nav>
    <div v-if="authenticated && user">
            <p>
              Hello, {{ user.name }}
            </p>
          </div>
    <br/>
    <router-view>
    </router-view>
  </div>
</template>
<style type="text/css">
.nav-link{
  text-decoration: none;
  padding: 10px;
  border: 1px solid transparent;
  border-top-left-radius: 0.25rem;
  border-top-right-radius: 0.25rem;
}
</style>
<script>
export default {        
  data() {
    return {
      authenticated: auth.check(),
      user: auth.user,
      books: []
    }
  },
  mounted() {
    Event.$on('userLoggedIn', () => {
      this.authenticated = true;
      this.user = auth.user;
    });
  },
  created() {
    if(this.authenticated){
      console.log(auth)
      this.user = auth.user;
      this.axios
      .get('/api/book')
      .then(response => {
        this.books = response.data;
      })
      .catch(({response}) => {
        if (response.status === 401) {
          this.logout();
        }
      });
    }
  },
  methods: {
    logout() {
      this.axios
      .get('/api/logout')
      .then(response => {
        auth.logout();
        location.reload();
      });
    }
  }        
}
</script>
