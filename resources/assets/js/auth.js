class Auth {
  constructor() {
   this.token = window.localStorage.getItem('token');
   //console.log(this.token)

   let userData = window.localStorage.getItem('user');
   this.user = userData ? JSON.parse(userData) : null;

   if (this.token) {
    axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.token;
    this.getUser();
  }
}
login (token, user) {        
  window.localStorage.setItem('token', token);
  window.localStorage.setItem('user', JSON.stringify(user));

  axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
  this.token = token;
  this.user = user;

  Event.$emit('userLoggedIn');
}
logout () {        
  window.localStorage.setItem('token', null);
  window.localStorage.setItem('user', null);
  this.token = null;
  this.user = null;

  Event.$emit('userLoggedOut');
}
check () {
  return !! this.token;
}
getUser() {
  axios.get('/api/user')
  .then(({data}) => {
    this.user = data;
  })
  .catch(({response}) => {
    if (response.status === 401) {
      this.logout();
    }
  });
}
}

export default Auth;
