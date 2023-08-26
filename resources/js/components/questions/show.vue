<template>
    <div class="container"  id="app">
        <div class="row my-5">
           <div class="alert alert-danger" role="alert" v-if="error !== null">
                    {{ error }}
                </div>
            <vote-component id="{{question.id}}" votes="{{question.votes}}"></vote-component>
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header bg-info">
                        <h3>{{ question.title }}</h3>
                    </div>

                    <div class="card-body">
                        <div class="card-text">
                            {{question.body}}
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <span class="fw-bold">
                            {{question.user.name}}
                        </span>
                        <span class="fw-bold">
                            {{question.created_at.diffForhumans()}}
                        </span>
                    </div>
                </div>
                <comment-component
                    question_id="{{question.id}}"
                    user_id="{{auth().check() ? auth().user().id : null}}"
                    verified_user="{{auth().check() && auth().user().email_verified_at !== null ? true : false}}"
                        ></comment-component>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            question: {}
        }
    },
    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/questions/show/${id}')
                .then(response => {
                    this.question = response.data;
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
