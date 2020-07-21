<template>
  <div>
    <div class="alert alert-danger" v-if="error && !success">
      <p>
        There was an error, unable to complete registration.
      </p>
    </div>
    <div class="alert alert-success" v-if="success">
      <p>
        Registration completed. You can now
        <router-link :to="{name:'login'}">
          sign in.
        </router-link>
      </p>
    </div>
    <form @submit.prevent="register" autocomplete="off" method="post" v-if="!success">
      <div class="form-group" v-bind:class="{ 'has-error': error && errors.name }">
        <label for="name">
          Name
        </label>
        <input class="form-control" id="name" required="" type="text" v-model="name">
        <span class="help-block" v-if="error && errors.name">
          {{ errors.name }}
        </span>
      </input>
    </div>
    <div class="form-group" v-bind:class="{ 'has-error': error && errors.email }">
      <label for="email">
        E-mail
      </label>
      <input class="form-control" id="email" placeholder="user@example.com" required="" type="email" v-model="email">
      <span class="help-block" v-if="error && errors.email">
        {{ errors.email }}
      </span>
    </input>
  </div>
  <div class="form-group" v-bind:class="{ 'has-error': error && errors.password }">
    <label for="password">
      Password
    </label>
    <input class="form-control" id="password" required="" type="password" v-model="password">
    <span class="help-block" v-if="error && errors.password">
      {{ errors.password }}
    </span>
  </input>
</div>
<button class="btn btn-default" type="submit">
  Submit
</button>
</form>
</div>
</template>
<script>
export default {
  data(){
    return {
      name: '',
      email: '',
      password: '',
      error: false,
      errors: {},
      success: false
    };
  },
  methods: {
    register(){
      axios.post('/api/register',{
        name: this.name,
        email: this.email,
        password: this.password
      })
      .then(({data}) => {
        console.log(data.data);
        auth.login(data.token, data.data);


        this.$router.push('/');
      })
      .catch(({response}) => {                    
        alert(response.data.message);
      });   
    }
  }
}
</script>
