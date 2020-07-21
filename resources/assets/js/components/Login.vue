<template>
  <div>
    <form @submit.prevent="login" autocomplete="off" method="post">
      <div class="form-group">
        <label for="email">
          E-mail
        </label>
        <input class="form-control" id="email" placeholder="user@example.com" required="" type="email" v-model="email">
      </input>
    </div>
    <div class="form-group">
      <label for="password">
        Password
      </label>
      <input class="form-control" id="password" required="" type="password" v-model="password">
    </input>
  </div>
  <button @click="login" class="btn btn-default" type="submit">
    Sign in
  </button>
</form>
</div>
</template>
<script type="text/javascript">
export default {
  data(){
    return {
      email: "",
      password: ""
    }
  },
  methods: {
    login(){
      axios.post('/api/login',{
        email: this.email,
        password: this.password
      })
      .then(({data}) => {
        auth.login(data.token, data.user);

        this.$router.push('/');
      })
      .catch(({response}) => {                    
        alert(response.data.message);
      });
    }
  }        
}
</script>
