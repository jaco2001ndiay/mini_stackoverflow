<template>
    <div class="container">
        <div class="row justify-content-center my-5">
           <div class="alert alert-danger" role="alert" v-if="error !== null">
                    {{ error }}
                </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"> {{ collective.title }}</div>

                    <div class="card-body">
                        <ul class="list-group" v-for= "question in collective.questions" :key="question.id">
                                <li class="list-group-item list-group-item-action">
                                    <router-link :to="{name: 'showquestion',params: {id: question.id}}"
                                        class="btn btn-link text-decoration-none text-primary">
                                        {{question.title}}
                                    </router-link>
                                </li>

                        </ul>
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
            collective: {}
        }
    },
    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/collectives/show/${id}')
                .then(response => {
                    this.collective = response.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
    },
    methods: {

    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next();
    }
}
</script>
