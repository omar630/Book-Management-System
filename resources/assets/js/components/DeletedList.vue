<template>
  <div v-if="authenticated">
    <h3 class="text-center">
      All Deleted Books({{ count }})
    </h3>
    <br/>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>
            Name
          </th>
          <th>
            Author
          </th>
          <th>
            Actions
          </th>
        </tr>
      </thead>
      <tbody>
        <tr :key="book.id" v-for="book in books">
          <td>
            {{ book.name }}
          </td>
          <td>
            {{ book.author }}
          </td>
          <td>
            <div class="btn-group" role="group">
              <button @click="deleteBook(book.id)" class="btn btn-danger">
                Delete permanently
              </button>
              <button @click="restore(book.id)" class="btn btn-primary">
                Restore
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<script>
export default {
  data() {
    return {
      authenticated: auth.check(),
      user: auth.user,
      books: [],
      count: 0
    }
  },
  created() {
    this.axios
    .get('/api/books/deletedbooks')
    .then(response => {
      console.log(response)
      this.books = response.data.data;
      this.count = response.data.meta.book_count;
    });
  },
  methods: {
    deleteBook(id) {
      this.axios
      .delete(`/api/book/${id}`)
      .then(response => {
                        let i = this.books.map(item => item.id).indexOf(id); // find index of your object
                        this.books.splice(i, 1)
                        this.count = this.count-1;
                      });                      
    },
    restore(id) {
      this.axios
      .head(`/api/book/${id}/restore`)
      .then(response => {
                        let i = this.books.map(item => item.id).indexOf(id); // find index of your object
                        this.books.splice(i, 1)
                        this.count = this.count-1;
                      });
    }
  }
}
</script>
