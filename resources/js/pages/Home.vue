<template>
   <div class="container">
        <div class="row my-5">
            <div class="col-md-8">
                <div class="card">
                    <div class=" bg-primary card-header"><h5 style="color: white">Derniers Questions</h5></div>
                    <div class="card-body">
                        <ul class="list-group"   v-for ="question in questions" :key ="question.id" >
                                <li class="list-group-item d-flex justify-content-between">
                       <router-link :to="{name: 'showquestion', params: { id:question.id }}" class="btn btn-primary">
                                             {{question.title}}
                                      </router-link>

                                    <router-link :to="{name: 'showcollective', params: {id: question.collective.id}}" class="text-decoration-none">
                                        <span class="badge bg-secondary p-2">
                                            {{question.collective.title}}
                                        </span>
                                    </router-link>
                                </li>

                        </ul>
                        <div class="d-flex justify-content-center my-2">
                            {{questions.links()}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-success"><h5 style="color: white">Categories</h5></div>

                    <div class="card-body">
                        <ul class="list-group"  v-for ="category in categories" :key ="category.id">

                                <li class="list-group-item d-flex justify-content-between">
                                    <router-link :to="{name: 'home', params: {id: category.id}}" class="text-decoration-none">
                                        {{category.name}}
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
            questions: {},
            categories: {},
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
        }),
          this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/collectives/create')
                .then(response => {
                    this.categories = response.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        }
        )
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next();
    }
}
</script>
