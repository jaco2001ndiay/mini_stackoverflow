<template>
   <div class="text-center" style="margin: 20px 0px 20px 0px;">
            <span class="text-secondary">Mini Stack OverFlow</span>
    </div>

<nav class="navbar navbar-expand-lg navbar-light bg-withe">
  <div class="container-fluid">

    <router-link to="/"><img src="{{ asset('images/question-reponse.jpg') }}"  style="width:150px; height:50x"></router-link>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
            <router-link to="/" class="nav-link active" aria-current="page" >Accueil</router-link>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Compte
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown"  >
                        <li  v-if="isLoggedIn">
                            <!-- <form id="logoutForm" action="{{route('logout')}}" method="post"> -->
                            <!-- </form> -->
                            <a class="nav-item nav-link" style="cursor: pointer;" @click="logout" >déconnecte</a>
                        </li>

                        <li v-else>
                            <router-link to="/login" class="nav-item nav-link">Se Connecter</router-link><br/>
                            <router-link to="/register" class="nav-item nav-link">Créer un compte</router-link>
                        </li>


                </ul>
            </li>
            <li class="nav-item dropdown" v-if="isLoggedIn">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Collectifs
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li>
                        <router-link to="\collectives" class="dropdown-item"  >
                            Mes Collectifs
                        </router-link>
                    </li>
                    <li>
                        <router-link to="\addcollective" class="dropdown-item" >
                            Créer un Collectifs
                        </router-link>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown" v-if="isLoggedIn">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Questions
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li>
                        <router-link to="\questions" class="dropdown-item"  >
                            Mes Questions
                        </router-link>
                    </li>
                    <li>
                        <router-link to="\addquestion" class="dropdown-item" >
                            Créer une question
                        </router-link>
                    </li>
                </ul>
            </li>

      </ul>
    </div>
  </div>
</nav>

</template>


<script>
export default {
    name: "App",
    data() {
        return {
            isLoggedIn: false,
        }
    },
    created() {
        if (window.Laravel.isLoggedin) {
            this.isLoggedIn = true
        }
    },
    methods: {
        logout(e) {
            console.log('ss')
            e.preventDefault()
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/logout')
                    .then(response => {
                        if (response.data.success) {
                            window.location.href = "/"
                        } else {
                            console.log(response)
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        }
    },
}
</script>
