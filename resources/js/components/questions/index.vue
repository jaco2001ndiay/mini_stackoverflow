<template>
    <div class="container">
        <div class="row justify-content-center my-5">
           <div class="alert alert-danger" role="alert" v-if="error !== null">
                    {{ error }}
                </div>
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header bg-info text-white"><h2>Liste de vos Questions</h2></div>

                    <div class="card-body">
                        <table class="table table-hover table-stripped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Titre</th>
                                    <th>Collectifs</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                                <template v-for="question in questions" :key="question.id" >
                                    <tr>
                                        <td>{{question.id}}</td>
                                        <td>{{question.title}}</td>
                                        <td>
                                            <span class="badge bg-success">
                                                {{question.collective.title}}
                                            </span>
                                        </td>
                                        <td class="d-flex justify-content-center align-items-center">
                                            <router-link to="{name: 'showquestion',params: {id:question.id}}"
                                                 class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i>
                                            </router-link>
                                            <router-link to="{name: 'editquestion', params: {id:question.id}}"  class="btn btn-sm btn-warning mx-2">
                                                <i class="fas fa-edit"></i>
                                            </router-link>
                                             <form id="{{question.id}}"  @submit.prevent="deleteQuestion(question.id)" >
                                            <a href="#"
                                                onclick="if(confirm('are you sure ?')) document.getElementById('{{question.id}}').submit()"
                                                class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                            </form>

                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            {{questions.links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            questions: {}
        }
    },
    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/questions')
                .then(response => {
                    this.questions = response.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
    },
    methods: {
        deleteQuestion(id) {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.delete('/api/questions/destroy/${id}')
                    .then(response => {
                        let i = this.questions.map(item => item.id).indexOf(id); // find index of your object
                        this.questions.splice(i, 1)
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        }
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next();
    }
}
</script>

