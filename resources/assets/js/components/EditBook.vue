<template>
  <div>
    <h3 class="text-center">
      Edit Book
    </h3>
    <div class="row">
      <div class="col-md-6">
        <form @submit.prevent="updateBook">
          <div class="form-group">
            <label>
              Name
            </label>
            <input class="form-control" type="text" v-model="book.name">
          </input>
        </div>
        <div class="form-group">
          <label>
            Author
          </label>
          <input class="form-control" type="text" v-model="book.author">
        </input>
      </div>
      <button class="btn btn-primary" type="submit">
        Update Book
      </button>
    </form>
  </div>
</div>
</div>
</template>
<script>
export default {
  data() {
    return {
      book: {}
    }
  },
  created() {
    this.axios
    .get(`/api/book/${this.$route.params.id}`)
    .then((response) => {
      this.book = response.data.data;
                    // console.log(response.data);
                  });
  },
  methods: {
    updateBook() {
      this.axios
      .put(`/api/book/${this.$route.params.id}`, this.book)
      .then((response) => {
        this.$router.push({name: 'home'});
      });
    }
  }
}
</script>
