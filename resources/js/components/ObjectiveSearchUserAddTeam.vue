<template>
  <section>
    <error-alert v-if="error" :error="error"></error-alert>
    <div class="card mb-3">
      <div class="card-header">Buscar usuario</div>
      <div class="card-body">
        <div class="form-group">
          <label>Ingrese el nombre</label>
          <input v-model="userInput" type="text" class="form-control" placeholder="Ej: José">
          <small class="form-text text-muted">{{status}}</small>
        </div>
      </div>
    </div>
    <form :action="formUrl" ref="theForm" method="POST">
      <input type="hidden" name="_token" :value="crsfToken">
      <input type="hidden" name="userId" :value="userSelected">
      <input type="hidden" name="role" :value="roleSelected">
    </form>
        <table class="table table-sm">
          <thead>
            <tr>
              <th>Nombre y Apellido</th>
              <th width="200" class="text-center">Acción</th>  
            </tr>
          </thead>
          <tbody v-if="!isFetching">
            <tr v-for="user in users" :key="user.id">
              <td>
                <p>{{user.name}}</p>
              </td>
              <td class="text-center">
                <div class="dropdown">
                  <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="roleSelector" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Seleccione rol
                  </button>
                  <div class="dropdown-menu" aria-labelledby="roleSelector">
                    <a class="dropdown-item is-clickable" @click="submit(user.id, 'manager')">Coordinador</a>
                    <a class="dropdown-item is-clickable" @click="submit(user.id, 'reporter')">Reportero</a>
                  </div>
                </div>
              </td>
            </tr>
            <tr v-if="users.length == 0">
              <td class="text-center" colspan="2">
                <p><i>No se encontraron usuarios</i></p>
              </td>
            </tr>
          </tbody>
          <tbody v-else>
            <tr>
              <td class="text-center" colspan="2">
                <p><i>Cargando...</i></p>
              </td>
            </tr>
          </tbody>
        </table>
        <paginator v-if="paginatorData.links && !isFetching" :paginatorData="paginatorData" @updateData="updateData" />
  </section>

</template>

<script>
import debounce from "lodash/debounce";
export default {
  props: ['fetchUrl', 'formUrl', 'crsfToken'],
  data() {
    return {
      userInput: null,
      isFetching: false,
      status: 'Comience escribiendo el nombre',
      error: null,
      users: [],
      roleSelected: null,
      userSelected: null,
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
        this.isFetching = true;
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
            this.isFetching = false;
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
    },
    submit: function(userId, role){
      this.userSelected = userId;
      this.roleSelected = role;
      this.$nextTick(() => {
          this.$refs.theForm.submit();
      });
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
