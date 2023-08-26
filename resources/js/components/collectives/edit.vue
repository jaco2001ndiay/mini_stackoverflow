<template>

<div class="container">
    <div class="row justify-content-center my-5">
       <div class="alert alert-danger" role="alert" v-if="error !== null">
                    {{ error }}
                </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Modification collectif</h2></div>

                <div class="card-body">
                    <form  @submit.prevent="updateCollective">


                        <div class="form-group row mb-3">
                            <label for="category_id" class="col-md-4 col-form-label text-md-right">Categorie<span class="text-danger fw-bold">*</span> </label>

                            <div class="col-md-6">
                                <select name="category_id" id="category_id"
                                    class="form-select" v-model="collective.category_id">
                                    <option disabled selected>Choose a category</option>
                                    <template v-for="category in categories" :key="category.id">
                                        <option
                                            v-if="category.id === collective.category_id"
                                            selected
                                            value="{{category.id}}">
                                            {{category.name}}
                                        </option>
                                         <option  v-else
                                            value="{{category.id}}">
                                            {{category.name}}
                                        </option>
                                    </template>
                                </select>


                                    <span class="invalid-feedback" role="alert" v-if="error !== null">
                                        <strong>Erreur de selection</strong>
                                    </span>

                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="title" class="col-md-4 col-form-label text-md-right">Titre<span class="text-danger fw-bold">*</span></label>

                            <div class="col-md-6">
                                    <input id="name" type="text" class="form-control"  autofocus v-model = "collective.title">


                                    <span class="invalid-feedback" role="alert" v-if="error !== null">
                                        <strong> probleme veuiller verifier vos choix </strong>
                                    </span>

                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Description<span class="text-danger fw-bold">*</span></label>

                            <div class="col-md-6">
                                <textarea rows="5" cols="30"
                                    class="form-control"
                                    name="description"
                                    required autocomplete="description" v-model="collective.description"></textarea>


                                    <span class="invalid-feedback" role="alert" v-if="error !== null">
                                        <strong>verifier vos choix</strong>
                                    </span>

                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Confirmer
                                </button>
                            </div>
                        </div>
                    </form>
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
            collective: {},
            categories: {}
        }
    },
    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get(`/api/collectives/edit/${this.$route.params.id}`)
                .then(response => {
                    this.collective = response.data['collective'];
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
        })
    },
    methods: {
        updateCollective() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post(`/api/collectives/update/${this.$route.params.id}`, this.collective)
                    .then(response => {
                        this.$router.push({name: 'collectives'});
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
