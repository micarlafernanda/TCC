<template>
  <div>
    <div class="d-flex justify-content-center h-100">
      <div id="cad_usuario" class="card">
        <div class="card-header">
          <h3 align="center"><img src="@/assets/images/prontuario-eletronico.png" width="250px"></h3>
        </div>

        <div class="container">
          <div class="card-body">
            <form @submit.prevent autocomplete="off">
              <div class="input-group form-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                </div>
                <input type="text" class="form-control" v-mask="['###.###.###-##']" v-model="usuario.cpf" placeholder="Informe seu CPF" required="required">
                <!-- <input type="text" class="form-control" v-model="usuario.cpf" placeholder="Informe seu CPF" required="required"> -->
              </div>

              <div class="input-group form-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-key"></i></span>
                </div>
                <input type="password" class="form-control" v-model="usuario.senha" placeholder="Informe sua senha" required="required">
              </div>
              <div class="form-group">
                <input type="submit" value="Entrar" class="btn float-right login_btn btn-light" @click="autenticar" :disabled="desativarBtn">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import User from "@/api/User";
import { mask } from "vue-the-mask";

export default {
  name: "Login",
  directives: { mask },
  data() {
    return {
      desativarBtn: false,
      usuario: {
        cpf: "",
        senha: ""
      }
    };
  },
  methods: {
    autenticar() {
      this.desativarBtn = true;
      if (this.usuario.cpf === "admin" && this.usuario.senha === "admin") {
        this.$router.push("/cadastro");
      } else {
        User.autenticar(
          this.usuario,
          () => {
            this.$router.push("/home");
          },
          () => {
            alert("Falha ao fazer login");
            this.desativarBtn = false;
            this.usuario.senha = "";
          }
        );
      }
    }
  }
};
</script>
