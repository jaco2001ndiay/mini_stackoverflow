<template>
<div class="container">
    <div class="row justify-content-center my-5">
       <div class="alert alert-danger" role="alert" v-if="error !== null">
                    {{ error }}
                </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-info text-white"><h2>Modifier une question</h2></div>

                <div class="card-body">
                    <form  @submit.prevent="updateQuestion">
                        @csrf

                        <div class="form-group row mb-3">
                            <label for="collective_id" class="col-md-4 col-form-label text-md-right">Collectif</label>

                            <div class="col-md-6">
                                <select name="collective_id" id="category_id"
                                    class="form-select" v-model ="question.collective_id">
                                    <option disabled selected>Choisir une question</option>
                                    <template v-for="collective in collectives" :key="collective.id"  >
                                        <option v-if="collective.id === question.collective_id" selected value="{{collective.id}}">
                                            {{collective.title}}
                                        </option>
                                        <option v-else value="{{collective.id}}" >
                                        {{collecive.title}}
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
                            <label for="category_id" class="col-md-4 col-form-label text-md-right">Categorie <span class="text-danger fw-bold">*</span> </label>

                            <div class="col-md-6">
                                <select name="category_id" id="category_id"
                                    class="form-select @error('category_id') is-invalid @enderror" v-model = "question.category_id" >
                                    <option disabled selected>Choisir une catégorie</option>
                                    <template v-for="category in categories" :key="category.id">

                                        <option v-if="category.id === question.category_id" selected value = "category.id" >

                                            {{category.name}}
                                        </option>
                                        <option v-else value="category.id">
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
                                <input id="name" type="text" class="form-control @error('title') is-invalid @enderror" name="title" v-model ="question.title"  required autocomplete="title" autofocus>

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>probleme occured </strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="body" class="col-md-4 col-form-label text-md-right">Question<span class="text-danger fw-bold">*</span></label>

                            <div class="col-md-6">
                                <textarea rows="5" cols="30"
                                    class="form-control @error('body') is-invalid @enderror"
                                    name="body"
                                    required autocomplete="body" v-model = "question.body" ></textarea>

                                @error('body')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>proleme occured </strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Envoyer
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
            question: {},
            collectives: {},
            categories: {}
        }
    },
    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get(`/api/questions/edit/${this.$route.params.id}`)
                .then(response => {
                    this.question = response.data['question'];
                    this.categories = response.data['categories'];
                    this.collectives = response.data['collectives'];
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
    },
    methods: {
        updateQuestion() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post(`/api/questions/update/${this.$route.params.id}`, this.question)
                    .then(response => {
                        this.$router.push({name: 'questions'});
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
