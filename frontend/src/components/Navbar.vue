<template>
  <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #110573;">
    <router-link to="/home">
      <img src="@/assets/images/prontuario-eletronico.png" width="150">
    </router-link>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto ml-3">
        <li class="nav-item active">
          <router-link class="nav-link" to="/home">
            <i class="fas fa-home"></i>
            Home
          </router-link>
        </li>
        <li class="nav-item active">
          <router-link class="nav-link" to="/medico" v-if="usuarioTipo === 'atendente'">
            <i class="fas fa-user-md"></i>
            Cadastro de médico
          </router-link>
        </li>
        <li class="nav-item active">
          <router-link class="nav-link" to="/familia" v-if="usuarioTipo === 'atendente'">
            <i class="fas fa-users"></i>
            Cadastro de família
          </router-link>
        </li>
        <li class="nav-item active">
          <router-link class="nav-link" to="/paciente" v-if="usuarioTipo === 'atendente'">
            <i class="fas fa-user-injured"></i>
            Cadastro de paciente
          </router-link>
        </li>
        <li class="nav-item active">
          <router-link class="nav-link" to="/consulta" v-if="usuarioTipo === 'atendente'">
            <i class="fas fa-stethoscope"></i>
            Marcar consulta
          </router-link>
        </li>
        <li class="nav-item active">
          <router-link class="nav-link" to="/historico" v-if="usuarioTipo === 'paciente'">
            <i class="fas fa-file-medical"></i>
            Histórico de paciente
          </router-link>
        </li>
        <li class="nav-item active">
          <router-link class="nav-link" to="/atendimento" v-if="usuarioTipo === 'medico'">
            <i class="fas fa-syringe"></i>
            Atendimento
          </router-link>
        </li>
        <li class="nav-item active">
          <router-link class="nav-link" to="/busca" v-if="usuarioTipo === 'atendente'">
            <i class="fas fa-search"></i>
            Busca de pacientes
          </router-link>
        </li>
      </ul>

      <ul class="nav ml-auto">
        <li class="nav-item">
          <a class="nav-link text-center" style="color: #fff;" href="#">Olá, {{usuarioNome}}</a>
        </li>
        <li class="nav-item">
          <button class="btn btn-outline-light my-2 my-sm-0" type="button" @click="logout()">
            <i class="fas fa-reply"></i>
            Sair
          </button>
        </li>
      </ul>

    </div>
  </nav>
</template>

<script>
export default {
  name: "Navbar",
  data() {
    return {
      usuarioTipo: localStorage.tipo,
      usuarioNome: localStorage.nome
    }
  },
  methods: {
    logout() {
      localStorage.clear();
      this.$router.push("/");
    }
  }
};
</script>
