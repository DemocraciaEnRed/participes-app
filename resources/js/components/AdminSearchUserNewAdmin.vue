<template>
  <section>
    <error-alert v-if="error" :error="error"></error-alert>
    <div class="form-group">
      <label>Ingrese el nombre</label>
      <input v-model="userInput" type="text" class="form-control" placeholder="Ej: José">
      <small class="form-text text-muted">{{status}}</small>
    </div>
    <div class="alert alert-light my-3" v-if="isLoading">
      <i class="fas fa-sync fa-spin"></i>&nbsp;Cargando...
    </div>
    <div class="card shadow-sm" v-if="users.length == 0">
      <div class="card-body text-center">
        <i class="far fa-surprise"></i>&nbsp;¡No se encontraron miembros del equipo!
      </div>
    </div>
    <div class="card my-3 shadow-sm" v-for="user in users" :key="user.id">
        <div class="card-body d-flex align-items-start">
        <div class="w-100">
          <h5 class="my-1 is-600">{{user.surname}}, {{user.name}}</h5>
          <p class="my-1 text-smaller text-muted">Email: {{user.email}}</p>
        </div>
        <div class="ml-2">
          <form :action="formUrl" method="POST">
            <input type="hidden" name="_token" :value="crsfToken">
            <input type="hidden" name="userId" :value="user.id">
            <button type="submit" class="btn btn-sm btn-primary">
              Asignar
            </button>
          </form>
        </div>
      </div>
    </div>
    <paginator v-if="paginatorData.links && !isLoading" :paginatorData="paginatorData" @updateData="updateData" />
  </section>
</template>

<script>
import debounce from "lodash/debounce";
export default {
  props: ['fetchUrl', 'formUrl', 'crsfToken'],
  data() {
    return {
      userInput: null,
      isLoading: false,
      status: 'Comience escribiendo el nombre',
      error: null,
      users: [],
      paginatorData: {
        links: null,
        meta: null,
      },
      params: {}
    }
  },
  mounted() {
    console.log("Component mounted.");
  },
  methods: {
    searchUser: debounce(
      function() {
        this.users = [];
        this.error = null;
        this.isLoading = true;
        this.$http
          .get(this.fetchUrl,{
            params: this.params
          })
          .then(response => {
            this.status = '';
            this.users = response.data.data;
            this.paginatorData = {
              links: response.data.links,
              meta: response.data.meta
            }
          })
          .catch(error => {
            // If there is a error, probably it's a server error
            this.error = error.response
            console.error(error)
          })
          .finally(() => {
            this.isLoading = false;
          });
      },
      // This is the number of milliseconds we wait for the
      // user to stop typing.
      500
    ),
    updateData: function(data){
      this.users = data.data
      this.paginatorData = {
        links: data.links,
        meta: data.meta
      }
    }
  },
  watch: {
    userInput: function(newUserInput, oldUserInput) {
      this.status = "Tipeando...";
      this.params = {
        name: newUserInput
      }
      if (newUserInput.length >= 3) this.searchUser();
      else this.status = "Por favor, escriba más caracteres para la busqueda";
    }
  }
};
</script>
