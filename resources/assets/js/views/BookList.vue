<template>
  <div>
    <div class="row">
      <h1>
        My Books
      </h1>
      <h4>
        New book
      </h4>
      <form @submit.prevent="AddBook()" action="#">
        <div class="input-group">
          <input autofocus="" class="form-control" name="body" type="text" v-model="book.body">
          <span class="input-group-btn">
            <button class="btn btn-primary" type="submit">
              New book
            </button>
          </span>
        </input>
      </div>
    </form>
    <h4>
      All books
    </h4>
    <ul class="list-group">
      <li v-if="list.length === 0">
        There are no books yet!
      </li>
      <li class="list-group-item" v-for="(book, index) in list">
        {{ book.body }}
        <button @click="deletebook(book.id)" class="btn btn-danger btn-xs pull-right">
          Delete
        </button>
      </li>
    </ul>
  </div>
</div>
</template>
<script>
export default {
  data() {
    return {
      list: [],
      book: {
        id: '',
        body: ''
      }
    };
  },
  
  created() {
    this.fetchbookList();
  },
  
  methods: {
    fetchbookList() {
      axios.get('api/books').then((res) => {
        this.list = res.data;
      });
    },
    
    AddBook() {
      axios.post('api/books', this.book)
      .then((res) => {
        this.book.body = '';
        this.edit = false;
        this.fetchbookList();
      })
      .catch((err) => console.error(err));
    },
    
    deletebook(id) {
      axios.delete('api/books/' + id)
      .then((res) => {
        this.fetchbookList()
      })
      .catch((err) => console.error(err));
    },
  }
}
</script>
