
<template>
  <section>
    <div class="input-group mb-3">
      <div class="input-group-prepend" v-if="selected">
        <span class="input-group-text"><i :class="`${selected} fa-fw`"></i></span>
      </div>
      <input type="text" class="form-control" :name="name" readonly :value="selected">
      <div class="input-group-append">
        <button class="btn btn-outline-secondary" @click.prevent="toggleShowIconSearch" ><i :class="`fas ${showIconSearch ? 'fa-angle-double-up' : 'fa-angle-double-down'} fa-fw`"></i></button>
      </div>
    </div>
    <div v-if="showIconSearch" class="card p-2 mt-2">
      <div class="card-body">

      <label>Buscar icono</label>
      <div class="input-group input-group-sm mb-3">
        <div class="input-group-prepend">
          <button class="btn" :class="selectedType == 'solid' ? 'btn-primary' : 'btn-outline-secondary'" @click.prevent="changeType('solid')">Solid</button>
          <button class="btn" :class="selectedType == 'regular' ? 'btn-primary' : 'btn-outline-secondary'" @click.prevent="changeType('regular')">Regular</button>
          <button class="btn" :class="selectedType == 'brands' ? 'btn-primary' : 'btn-outline-secondary'" @click.prevent="changeType('brands')">Brands</button>
        </div>
        <input type="text" class="form-control" v-model="iconInput" placeholder="Comience escribiendo que busca en ingles. Ej: 'building' o 'user' o 'tree'...">
      </div>
      <small class="form-text text-muted">La plataforma utiliza <a href="https://fontawesome.com/icons?d=gallery&m=free">Font Awesome 5</a> para usar sus iconos. Puede ver la galeria entranado en la web.</small>
      <small class="form-text text-muted">{{status}}</small>
      <p class="icon-select d-inline-block my-1 mr-2 text-smaller" @click="selected = icon" v-for="(icon,i) in filteredList" :key="`icon${i}`"><i :class="`${icon} fa-fw fa-lg`"></i> {{icon}}</p>
      </div>
    </div>
  </section>
</template>

<script>
import debounce from "lodash/debounce";
import data from './fontawesome-icons'
export default {
  props: {
    name: {
      type: String,
      default: null
    },
    value: {
      type: String,
      default: null,
    }
  },
  data() {
    return {
      selected: null,
      iconInput: null,
      availableIcons: data,
      selectedType: 'solid',
      filteredList: [],
      showIconSearch: false,
      status: null
    }
  },
  mounted: function(){
    if(this.value != null) this.selected = this.value
  },
  methods: {
    searchIcon: debounce(
      function() {
        this.filteredList = this.availableIcons[this.selectedType].filter((icon) => {
          return this.iconInput.toLowerCase().split(' ').every(v => icon.toLowerCase().includes(v));
        });
        this.status = null;  
      }
    , 500),
    toggleShowIconSearch: function(){
      if(this.showIconSearch) {
        this.showIconSearch = false
        this.filteredList = []
      } else {
        this.showIconSearch = true
      }
    },
    changeType: function(type){
      this.selectedType = type
      this.searchIcon()
    }
  },
  watch: {
    iconInput: function(newIconInput, oldIconInput) {
      this.status = "Tipeando...";
      if (newIconInput.length >= 3) this.searchIcon();
      else this.status = "Por favor, escriba más caracteres para la busqueda";
    }
    
  }
}
</script>

<style lang="scss" scoped>
.icon-select:hover{
  cursor: pointer;
  color: #2c59fb;
}
</style>
