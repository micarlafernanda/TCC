<template>
  <div>
    <div class="card mb-3 mt-3">
      <div class="card-header">
        <h5 align="center">Marcar Consultas</h5>
      </div>
      <div class="card-body">
        <form @submit.prevent autocomplete="off">
          <div class="form-row">
            <div class="form-group col-6">
              <label for="especialidade">Paciente</label>
              <select v-model="novaConsulta.paciente_id" type="text" class="form-control" required="required">
                <option :selected="novaConsulta.paciente_id === paciente.id ? 'selected' : ''" v-for="paciente in listaPacientes" :key="paciente.id" :value="paciente.id">{{paciente.user.nome}} - {{paciente.user.cpf}}</option>
              </select>
            </div>
            <div class="form-group col-6">
              <label for="especialidade">Médico</label>
              <select v-model="novaConsulta.medico_id" type="text" class="form-control" required="required">
                <option :selected="novaConsulta.medico_id === medico.id ? 'selected' : ''" v-for="medico in listaMedicos" :key="medico.id" :value="medico.id">{{medico.user.nome}} - {{medico.especialidade}}</option>
              </select>
            </div>
          </div>

          <div class="form-row">
          </div>
          <button type="submit" class="btn btn-primary" @click="cadastrarConsulta()">Cadastrar</button>
          <button type="submit" class="btn btn-danger ml-2" @click="limparFormulario()">Limpar</button>
        </form>
      </div>
    </div>

    <div class="card mb-3">
      <div class="card-header">
        <i class="fas fa-table"></i>
        Lista de consultas</div>
      <div class="card-body">
        <div class="table-responsive table-bordered table-striped">
          <table class="table" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th class="text-center">Data</th>
                <th class="text-center">Paciente</th>
                <th class="text-center">Médico</th>
                <th class="text-center">Opções</th>
              </tr>
            </thead>
            <tbody>

              <tr v-for="consulta in listaConsultas" :key="consulta.id">
                <td class="text-center align-middle">{{consulta.data}}</td>
                <td class="text-center align-middle">{{consulta.paciente_nome}}</td>
                <td class="text-center align-middle">{{consulta.medico_nome}}</td>
                <td class="text-center align-middle">
                  <div class="btn-group">
                    <button class="btn btn-danger" @click="excluirConsulta(consulta)"><i class="far fa-fw fa-trash-alt"></i> Excluir </button>
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
  name: "Consulta",
  directives: { mask },
  components: {},
  data() {
    return {
      novaConsulta: {
        data: new Date().toLocaleDateString(),
        paciente_id: "",
        medico_id: "",
        paciente_nome: "",
        medico_nome: "",
        id: ""
      },
      listaConsultas: [],
      listaPacientes: [],
      listaMedicos: []
    };
  },
  methods: {
    cadastrarConsulta() {
      Vue.axios
        .get(`paciente/${this.novaConsulta.paciente_id}?expand=user,familia`)
        .then(response => {
          this.novaConsulta.paciente_nome = response.data.user.nome;
          Vue.axios
            .get(`medico/${this.novaConsulta.medico_id}?expand=user,familia`)
            .then(response => {
              this.novaConsulta.medico_nome = response.data.user.nome;
              Vue.axios
                .post("consulta", {
                  data: this.novaConsulta.data,
                  medico_id: this.novaConsulta.medico_id,
                  paciente_id: this.novaConsulta.paciente_id,
                  medico_nome: this.novaConsulta.medico_nome,
                  paciente_nome: this.novaConsulta.paciente_nome
                })
                .then(response => {
                  alert("Consulta cadastrada com sucesso");
                  this.limparFormulario();
                  this.atualizarLista();
                })
                .catch(() => {
                  alert("Falha ao cadastrar consulta");
                });
            });
        });
    },
    excluirConsulta(consulta) {
      if (confirm("Deseja realmente excluir esta consulta?")) {
        Vue.axios
          .delete(`consulta/${consulta.id}`)
          .then(response => {
            alert("Consulta deletada com sucesso");
            this.atualizarLista();
          })
          .catch(() => {
            alert("Falha ao deletar consulta");
          });
      }
    },
    atualizarLista() {
      Vue.axios
        .get("paciente?expand=user,familia")
        .then(response => {
          this.listaPacientes = response.data;
        })
        .catch(() => {
          alert("Falha ao recuperar pacientes");
        });

      Vue.axios
        .get("medico?expand=user")
        .then(response => {
          this.listaMedicos = response.data;
        })
        .catch(() => {
          alert("Falha ao recuperar médicos");
        });

      Vue.axios
        .get("consulta?expand=medico,paciente")
        .then(response => {
          this.listaConsultas = response.data;
        })
        .catch(() => {
          alert("Falha ao recuperar consultas");
        });
    },
    limparFormulario() {
      this.novaConsulta.medico_id = "";
      this.novaConsulta.paciente_id = "";
      this.novaConsulta.data = new Date().toLocaleDateString();
    }
  },
  created() {
    this.atualizarLista();
  }
};
</script>
