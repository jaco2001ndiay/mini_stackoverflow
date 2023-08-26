<template>
    <div class="container">
        <div class="row justify-content-center my-5">
           <div class="alert alert-danger" role="alert" v-if="error !== null">
                    {{ error }}
                </div>
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header bg-secondary text-white"><h2>Mes Collectifs</h2></div>

                    <div class="card-body">
                        <table class="table table-hover table-stripped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Titre</th>
                                    <th>Questions</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>   <tr v-for="collective in collectives" :key="collective.id">
                                        <td>{{collective.id}}</td>
                                        <td>{{collective.title}}</td>
                                        <td>
                                            <span class="badge bg-success">
                                                {{collective.questions.count()}}
                                            </span>
                                        </td>
                                        <td class="d-flex justify-content-center align-items-center">
                                            <router-link :to="{name: 'showcollective',params: {id:collective.id}}"
                                                 class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i>
                                            </router-link>
                                            <router-link :to= "{name: 'editcollective', params: {id:collective.id}}"
                                                 class="btn btn-sm btn-warning mx-2">
                                                <i class="fas fa-edit"></i>
                                            </router-link>
                                            <form id="{{collective.id}}"  @submit.prevent="deleteCollective(collective.id)" >
                                            </form>
                                            <a href="#"
                                                onclick="if(confirm('Etes vous sur ?')) document.getElementById('{{collective.id}}').submit()"
                                                class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>

                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            {{collectives.links()}}
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
            collectives: {}
        }
    },
    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/collectives')
                .then(response => {
                    this.collectives = response.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
    },
    methods: {
        deleteCollective(id) {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.delete('/api/collectives/destroy/${id}')
                    .then(response => {
                        let i = this.collectives.map(item => item.id).indexOf(id); // find index of your object
                        this.collectives.splice(i, 1)
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

