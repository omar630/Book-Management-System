import AllBooks from './components/AllBooks.vue';
import EditBook from './components/EditBook.vue';
import AddBook from './components/AddBook.vue';
import Register from './components/Register.vue';
import Login from './components/Login.vue';
import DeletedList from './components/DeletedList.vue';

export const routes = [

{
  name: 'home',
  path: '/',
  component: AllBooks,
  meta: {
    auth: true
  }
},
{
  name: 'addBook',
  path: '/api/book/add',
  component: AddBook,
  meta: {
    auth: true
  }
},
{
  name: 'deletedList',
  path: '/api/book/deleted',
  component: DeletedList,
  meta: {
    auth: true
  }
},
{
  name: 'edit',
  path: '/api/book/:id',
  component: EditBook,
  meta: {
    auth: true
  }
},
{
  name: 'add',
  path: '/api/book/add',
  component: AddBook,
  meta: {
    auth: true
  }
},{
  path: '/api/register',
  name: 'register',
  component: Register,
  meta: {
    auth: false
  }
},{
  path: '/api/login',
  name: 'login',
  component: Login,
  meta: {
    auth: false
  }
},

];
