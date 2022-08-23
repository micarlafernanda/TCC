<template>
  <div>
    <div class="card mb-3 mt-3">
      <div class="card-header">
        <h5 align="center">Histórico</h5>
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
                <th class="text-center">Médico</th>
                <th class="text-center">Peso em Kg</th>
                <th class="text-center">Temperatura</th>
                <th class="text-center">Pressão arterial</th>
                <th class="text-center">Diagnóstico</th>
                <th class="text-center">Conduta</th>
              </tr>
            </thead>
            <tbody>

              <tr v-for="consulta in listaConsultas" :key="consulta.id">
                <td class="text-center align-middle">{{consulta.data}}</td>
                <td class="text-center align-middle">{{consulta.medico_nome}}</td>
                <td class="text-center align-middle">{{consulta.peso}}</td>
                <td class="text-center align-middle">{{consulta.temperatura}}</td>
                <td class="text-center align-middle">{{consulta.pressaoArterial}}</td>
                <td class="text-center align-middle">{{consulta.diagnostico}}</td>
                <td class="text-center align-middle">{{consulta.conduta}}</td>
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
      listaConsultas: [],
      listaPacientes: [],
      listaMedicos: [],
    };
  },
  methods: {
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
          this.listaConsultas = response.data.filter(consulta => consulta.paciente_nome === localStorage.nome).filter(consulta => consulta.conduta !== null);
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
