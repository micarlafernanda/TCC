<template>
  <div>
    <div class="card mb-3 mt-3">
      <div class="card-header">
        <h5 align="center">Atendimento</h5>
      </div>
      <div class="card-body">
        <form @submit.prevent autocomplete="off">
          <div class="form-row">
            <div class="form-group col-6">
              <label for="especialidade">Paciente</label>
              <select disabled v-model="consultaAtual.paciente_id" type="text" class="form-control" required="required">
                <option :selected="consultaAtual.paciente_id === paciente.id ? 'selected' : ''" v-for="paciente in listaPacientes" :key="paciente.id" :value="paciente.id">{{paciente.user.nome}} - {{paciente.user.cpf}}</option>
              </select>
            </div>
            <div class="form-group col-6">
              <label for="especialidade">Data</label>
              <input v-model="consultaAtual.data" disabled type="text" class="form-control" required="required">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-4">
              <label for="especialidade">Peso</label>
              <input v-model="consultaAtual.peso" v-mask="['##', '##.#', '##.##', '###.##']" type="text" class="form-control" required="required">
            </div>
            <div class="form-group col-4">
              <label for="especialidade">Temperatura</label>
              <input v-model="consultaAtual.temperatura" v-mask="['##', '##.#']" type="text" class="form-control" required="required">
            </div>
            <div class="form-group col-4">
              <label for="especialidade">Pressão arterial</label>
              <input v-model="consultaAtual.pressaoArterial" v-mask="['##/#', '##/##', '###/##', '###/###']" type="text" class="form-control" required="required">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-6">
              <label for="especialidade">Diagnóstico</label>
              <textarea v-model="consultaAtual.diagnostico" class="form-control" required="required"></textarea>
            </div>
            <div class="form-group col-6">
              <label for="especialidade">Conduta</label>
              <textarea v-model="consultaAtual.conduta" class="form-control" required="required"></textarea>
            </div>
          </div>

          <div class="form-row">
          </div>
          <button type="submit" class="btn btn-primary" @click="finalizarConsulta()">Finalizar</button>
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
                    <button class="btn btn-primary" @click="abrirAtendimento(consulta)"><i class="fas fa-syringe"></i> Atender </button>
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
      consultaAtual: {
        paciente_id: "",
        data: "",
        id: "",
        peso: "",
        pressaoArterial: "",
        temperatura: "",
        diagnostico: "",
        conduta: ""
      },
      listaConsultas: [],
      listaPacientes: [],
      listaMedicos: []
    };
  },
  methods: {
    finalizarConsulta() {
      if(this.consultaAtual.conduta.length === 0){
        delete this.consultaAtual.conduta;
      }
      Vue.axios
        .put(`consulta/${this.consultaAtual.id}`, {
          pressaoArterial: this.consultaAtual.pressaoArterial,
          temperatura: this.consultaAtual.temperatura,
          peso: this.consultaAtual.peso,
          diagnostico: this.consultaAtual.diagnostico,
          conduta: this.consultaAtual.conduta
        })
        .then(response => {
          alert("Consulta finalizada com sucesso");
          this.limparFormulario();
          this.atualizarLista();
        })
        .catch(() => {
          alert("Falha ao finalizar consulta");
        });
    },
    abrirAtendimento(consulta) {
      this.consultaAtual.paciente_id = consulta.paciente_id;
      this.consultaAtual.data = consulta.data;
      this.consultaAtual.id = consulta.id;
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
          this.listaConsultas = response.data.filter(consulta => consulta.conduta === null).filter(consulta => consulta.medico_nome === localStorage.nome);
          // this.listaConsultas = response.data.filter(consulta => consulta.conduta === null);
        })
        .catch(() => {
          alert("Falha ao recuperar consultas");
        });
    },
    limparFormulario() {
      this.consultaAtual.paciente_id = "";
      this.consultaAtual.data = "";
      this.consultaAtual.id = "";
      this.consultaAtual.peso = "";
      this.consultaAtual.pressaoArterial = "";
      this.consultaAtual.temperatura = "";
      this.consultaAtual.diagnostico = "";
      this.consultaAtual.conduta = "";
    }
  },
  created() {
    this.atualizarLista();
  }
};
</script>
