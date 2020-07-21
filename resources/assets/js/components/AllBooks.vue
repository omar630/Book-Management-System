<template>
    <div v-if="authenticated && user">
        <h3 class="text-center">
            All Books
        </h3>
        <br/>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th> Name </th>
                    <th>Author</th>
                    <th> Actions</th>
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
                            <router-link :to="{name: 'edit', params: { id: book.id }}" class="btn btn-primary">
                                Edit
                            </router-link>
                            <button @click="deleteBook(book.id)" class="btn btn-danger">
                                Delete
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
                books: []
            }
        },
        created() {
            this.axios
                .get('/api/book')
                .then(response => {
                console.log(response)
                    this.books = response.data;
                });
        },
        methods: {
            deleteBook(id) {
                this.axios
                    .delete(`/api/book/${id}`)
                    .then(response => {
                        let i = this.books.map(item => item.id).indexOf(id); // find index of your object
                        this.books.splice(i, 1)
                    });
            }
        }
    }
</script>
