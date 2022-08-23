<template>
  <div>
    <div class="d-flex justify-content-center h-100">
      <div id="cad_usuario" class="card">
        <div class="card-header">
          <h3 align="center">Cadastro de atendente</h3>
        </div>

        <div class="container">
          <div class="card-body">

            <form @submit.prevent autocomplete="off">

              <div class="input-group form-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-signature"></i></span>
                </div>
                <input type="text" v-model="usuario.nome" class="form-control" placeholder="Informe seu nome" required>
              </div>

              <div class="input-group form-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                </div>
                <input type="text" v-model="atendente.matricula" class="form-control" placeholder="Informe sua matrícula" required>
              </div>

              <div class="input-group form-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
                <input type="text" v-model="usuario.cpf" v-mask="['###.###.###-##']" class="form-control" placeholder="Informe seu CPF" required>
              </div>

              <div class="input-group form-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-key"></i></span>
                </div>
                <input type="password" v-model="usuario.senha" class="form-control" placeholder="Informe sua senha" required>
              </div>

              <div class="form-group mt-5">
                <input type="submit" @click="cadastrarUsuario()" value="Enviar" class="btn float-right login_btn btn-light">
                <router-link to="/">
                  <input type="submit" value="Voltar" class="btn float-left login_btn btn-light">
                </router-link>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import { mask } from "vue-the-mask";
export default {
  name: "CadastroUsuario",
  directives: { mask },
  data() {
    return {
      usuario: {
        nome: "",
        cpf: "",
        senha: ""
      },
      atendente: {
        matricula: "",
        user_id: ""
      }
    };
  },
  methods: {
    cadastrarUsuario() {
      Vue.axios
        .post("user", {
          nome: this.usuario.nome,
          cpf: this.usuario.cpf,
          tipo: "atendente",
          senha: this.usuario.senha
        })
        .then(response => {
          Vue.axios
            .post("user/login", {
              cpf: this.usuario.cpf,
              senha: this.usuario.senha
            })
            .then(response => {
              localStorage.token = response.data.token;
              Vue.axios
                .post("atendente", {
                  matricula: this.atendente.matricula,
                  user_id: response.data.usuario.id
                })
                .then(response => {
                  alert("Cadastro realizado com sucesso");
                  localStorage.clear();
                  this.usuario.nome = "";
                  this.usuario.cpf = "";
                  this.usuario.senha = "";
                  this.atendente.matricula = "";
                  this.$router.push('/');
                })
                .catch(error => {
                  alert("Falha ao cadastrar atendente");
                });
            })
            .catch(error => {
              alert("Falha ao realizar login");
            });
        })
        .catch(error => {
          console.log("Falha ao cadastrar usuário");
        });
    }
  }
};
</script>
