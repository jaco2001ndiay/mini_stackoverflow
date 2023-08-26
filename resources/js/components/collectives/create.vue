<template>
<div class="container">
    <div class="row justify-content-center my-5">
       <div class="alert alert-danger" role="alert" v-if="error !== null">
                    {{ error }}
                </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-secondary text-white"><h2>Créer un collectif</h2></div>

                <div class="card-body">
                    <form @submit.prevent="addCollectives">
                        @csrf
                        <div class="form-group row mb-3">
                            <label for="category_id" class="col-md-4 col-form-label text-md-right">Categorie<span class="text-danger fw-bold">*</span> </label>

                            <div class="col-md-6">
                                <select name="category_id" id="category_id"
                                    class="form-select @error('category_id') is-invalid @enderror" v-model = "collective.category_id">
                                    <option disabled selected>Choisir une catégorie</option>
                                    <template v-for="category in categories" :key="category.id">
                                        <option value="{{category.id}}">
                                            {{category.name}}
                                        </option>
                                    </template>
                                </select>

                                @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="title" class="col-md-4 col-form-label text-md-right">Titre<span class="text-danger fw-bold">*</span></label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('title') is-invalid @enderror" name="title" required autocomplete="title" autofocus v-model = "collective.title">

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>erreur a rectifier </strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Description<span class="text-danger fw-bold">*</span></label>

                            <div class="col-md-6">
                                <textarea rows="5" cols="30"
                                    class="form-control @error('description') is-invalid @enderror"
                                    name="description"
                                    required autocomplete="description" v-model = "collective.description"></textarea>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>oups </strong>
                                    </span>
                                @enderror
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
        addCollectives() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post(`/api/collectives/store`, this.collective)
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

