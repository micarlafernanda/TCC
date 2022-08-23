<template>
  <div>
    <div class="card mb-3 mt-3">
      <div class="card-header">
        <h5 align="center">Cadastro de Paciente</h5>
      </div>
      <div class="card-body">
        <form @submit.prevent autocomplete="off">
          <div class="form-row">
            <div class="form-group col-4">
              <label for="nome">Nome completo</label>
              <input v-model="novoUsuario.nome" type="text" class="form-control" required="required">
            </div>
            <div class="form-group col-4">
              <label for="nome">CPF</label>
              <input v-model="novoUsuario.cpf" v-mask="['###.###.###-##']" type="text" class="form-control cpf" required="required">
            </div>
            <div class="form-group col-4">
              <label for="senha">Cartão SUS</label>
              <input v-model="novoPaciente.cartaoSUS" v-mask="['### #### #### ####']" type="text" class="form-control" required="required">
            </div>
             <div class="form-group col-6">
              <label for="especialidade">Família (nº prontuário)</label>
              <select v-model="novoPaciente.familia_id" name="especialidade" type="text" class="form-control" id="especialidade" required="required">
                <option :selected="novoPaciente.familia_id === familia.id ? 'selected' : ''" v-for="familia in listaFamilias" :key="familia.id" :value="familia.familia.id">{{familia.familia.nomeResponsavel}} - {{familia.familia.posicaoFamiliar}}</option>
              </select>
            </div>
            <div class="form-group col-6">
              <label for="senha">Senha</label>
              <input v-model="novoUsuario.senha" type="password" class="form-control" required="required">
            </div>

          </div>

          <div class="form-row">
          </div>
          <button type="submit" class="btn btn-primary" @click="cadastrarPaciente()" v-if="!edicao">Cadastrar</button>
          <button type="submit" class="btn btn-success" @click="atualizarPaciente()" v-if="edicao">Atualizar</button>
          <button type="submit" class="btn btn-danger ml-2" @click="limparFormulario()">Limpar</button>
        </form>
      </div>
    </div>

    <div class="card mb-3">
      <div class="card-header">
        <i class="fas fa-table"></i>
        Lista de pacientes</div>
      <div class="card-body">
        <div class="table-responsive table-bordered table-striped">
          <table class="table" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th class="text-center">Nome</th>
                <th class="text-center">CPF</th>
                <th class="text-center">Cartão SUS</th>
                <th class="text-center">Família (nº prontuário)</th>
                <th class="text-center">Opções</th>
              </tr>
            </thead>
            <tbody>

              <tr v-for="paciente in listaPacientes" :key="paciente.id">
                <td class="text-center align-middle">{{paciente.user.nome}}</td>
                <td class="text-center align-middle">{{paciente.user.cpf}}</td>
                <td class="text-center align-middle">{{paciente.cartaoSUS}}</td>
                <td class="text-center align-middle">{{paciente.familia.numeroProntuario}}</td>
                <td class="text-center align-middle">
                  <div class="btn-group">
                    <button class="btn btn-info mr-2" @click="exibirPaciente(paciente)"><i class="fas fa-fw fa-plus"></i> Exibir </button>
                    <button class="btn btn-danger" @click="excluirPaciente(paciente)"><i class="far fa-fw fa-trash-alt"></i> Excluir </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mask } from "vue-the-mask";
import Vue from "vue";

export default {
  name: "Paciente",
  directives: { mask },
  components: {},
  data() {
    return {
      edicao: false,
      novoUsuario: {
        nome: "",
        cpf: "",
        senha: "",
        tipo: "paciente",
        id: ""
      },
      novoPaciente: {
        cartaoSUS: "",
        user_id: "",
        familia_id: "",
        id: ""
      },
      listaPacientes: [],
      listaFamilias: []
    };
  },
  methods: {
    cadastrarPaciente() {
      // this.novoPaciente.cartaoSUS;
      // this.novoPaciente.user_id;
      // this.novoPaciente.familia_id;
      // this.novoPaciente.id;
      // this.novoUsuario.nome;
      // this.novoUsuario.tipo;
      // this.novoUsuario.cpf;
      // this.novoUsuario.senha;
      // this.novoUsuario.id;
      Vue.axios
        .post("user", {
          nome: this.novoUsuario.nome,
          cpf: this.novoUsuario.cpf,
          senha: this.novoUsuario.senha,
          tipo: this.novoUsuario.tipo
        })
        .then(response => {
          Vue.axios
            .post("paciente", {
              cartaoSUS: this.novoPaciente.cartaoSUS,
              familia_id: this.novoPaciente.familia_id,
              user_id: response.data.id
            })
            .then(response => {
              alert("Paciente cadastrado com sucesso");
              this.limparFormulario();
              this.atualizarLista();
            })
            .catch(() => {
              alert("Falha ao cadastrar paciente");
            });
        })
        .catch(() => {
          alert("Falha ao cadastrar usuário");
        });
    },
    exibirPaciente(paciente) {
      this.edicao = true;

      this.novoPaciente.cartaoSUS = paciente.cartaoSUS;
      this.novoPaciente.user_id = paciente.user_id;
      this.novoPaciente.familia_id = paciente.familia_id;
      this.novoPaciente.id = paciente.id;
      this.novoUsuario.nome = paciente.user.nome;
      this.novoUsuario.cpf = paciente.user.cpf;
      this.novoUsuario.id = paciente.user.id;
    },
    excluirPaciente(paciente) {
      if (confirm("Deseja realmente excluir este paciente?")) {
        Vue.axios
          .delete(`paciente/${this.novoPaciente.id}`)
          .then(response => {
            Vue.axios
              .delete(`user/${this.novoUsuario.id}`)
              .then(response => {
                alert("Paciente deletado com sucesso");
                this.atualizarLista();
              })
              .catch(() => {
                alert("Falha ao deletar usuário");
              });
          })
          .catch(() => {
            alert("Falha ao deletar paciente");
          });
      }
    },
    atualizarPaciente() {
      if (confirm("Deseja realmente atualizar este paciente?")) {
        if (this.novoUsuario.senha.length === 0) {
          delete this.novoUsuario.senha;
        }
        Vue.axios
          .put(`user/${this.novoUsuario.id}`, {
            nome: this.novoUsuario.nome,
            cpf: this.novoUsuario.cpf,
            senha: this.novoUsuario.senha
          })
          .then(response => {
            Vue.axios
              .put(`paciente/${this.novoPaciente.id}`, {
                cartaoSUS: this.novoPaciente.cartaoSUS,
                familia_id: this.novoPaciente.familia_id
              })
              .then(response => {
                alert("Paciente atualizado com sucesso");
                this.limparFormulario();
                this.atualizarLista();
              })
              .catch(() => {
                alert("Falha ao atualizar paciente");
              });
          })
          .catch(() => {
            alert("Falha ao atualizar usuário");
          });
      }
    },
    atualizarLista() {
      Vue.axios
        .get("endereco?expand=familia")
        .then(response => {
          this.listaFamilias = response.data;
        })
        .catch(() => {
          alert("Falha ao recuperar famílias");
        });

      Vue.axios
        .get("paciente?expand=user,familia")
        .then(response => {
          this.listaPacientes = response.data;
        })
        .catch(() => {
          alert("Falha ao recuperar pacientes");
        });
    },
    limparFormulario() {
      this.edicao = false;
      this.novoPaciente.cartaoSUS = "";
      this.novoPaciente.user_id = "";
      this.novoPaciente.familia_id = "";
      this.novoPaciente.id = "";
      this.novoUsuario.nome = "";
      this.novoUsuario.cpf = "";
      this.novoUsuario.senha = "";
      this.novoUsuario.id = "";
    }
  },
  created() {
    this.atualizarLista();
  }
};
</script>
