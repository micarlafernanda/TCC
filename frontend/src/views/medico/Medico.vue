<template>
  <div>
    <div class="card mb-3 mt-3">
      <div class="card-header">
        <h5 align="center">Cadastro de Médico</h5>
      </div>
      <div class="card-body">
        <form @submit.prevent autocomplete="off">
          <div class="form-row">
            <div class="form-group col-6">
              <label for="nome">Nome completo</label>
              <input v-model="novoMedico.nome" type="text" class="form-control" required="required">
            </div>
            <div class="form-group col-3">
              <label for="nome">CPF</label>
              <input v-model="novoMedico.cpf" v-mask="['###.###.###-##']" type="text" class="form-control cpf" required="required">
            </div>
            <div class="form-group col-3">
              <label for="senha">Senha</label>
              <input v-model="novoMedico.senha" type="password" class="form-control" required="required">
            </div>
          </div>

          <div class="form-row">

            <div class="form-group col-6">
              <label for="especialidade">Especialidade</label>
              <select v-model="novoMedico.especialidade" name="especialidade" type="text" class="form-control" id="especialidade" required="required">
                <option :selected="novoMedico.especialidade === especialidade.nome ? 'selected' : ''" v-for="especialidade in listaEspecialidades" :key="especialidade.nome" :value="especialidade.nome">{{especialidade.nome}}</option>
              </select>
            </div>

            <div class="form-group col-6">
              <label for="nome">CRM</label>
              <input v-model="novoMedico.crm" v-mask="['CRM/RN ######']" type="text" class="form-control" required="required">
            </div>

          </div>

          <div class="form-row">
          </div>
          <button type="submit" class="btn btn-primary" @click="cadastrarMedico()" v-if="!edicao">Cadastrar</button>
          <button type="submit" class="btn btn-success" @click="atualizarMedico()" v-if="edicao">Atualizar</button>
          <button type="submit" class="btn btn-danger ml-2" @click="limparFormulario()">Limpar</button>
        </form>
      </div>
    </div>

    <div class="card mb-3">
      <div class="card-header">
        <i class="fas fa-table"></i>
        Lista de médicos</div>
      <div class="card-body">
        <div class="table-responsive table-bordered table-striped">
          <table class="table" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th class="text-center">Nome</th>
                <th class="text-center">CPF</th>
                <th class="text-center">CRM</th>
                <th class="text-center">Especialidade</th>
                <th class="text-center">Opções</th>
              </tr>
            </thead>
            <tbody>

              <tr v-for="medico in listaMedicos" :key="medico.id">
                <td class="text-center align-middle">{{medico.user.nome}}</td>
                <td class="text-center align-middle">{{medico.user.cpf}}</td>
                <td class="text-center align-middle">{{medico.crm}}</td>
                <td class="text-center align-middle">{{medico.especialidade}}</td>
                <td class="text-center align-middle">
                  <div class="btn-group">
                    <button class="btn btn-info mr-2" @click="exibirMedico(medico)"><i class="fas fa-fw fa-plus"></i> Exibir </button>
                    <button class="btn btn-danger" @click="excluirMedico(medico)"><i class="far fa-fw fa-trash-alt"></i> Excluir </button>
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
  name: "Medico",
  directives: { mask },
  components: {},
  data() {
    return {
      edicao: false,
      novoMedico: {
        nome: "",
        cpf: "",
        senha: "",
        tipo: "medico",
        especialidade: "",
        crm: "",
        user_id: "",
        id: ""
      },
      listaMedicos: [],
      listaEspecialidades: [
        { nome: "" },
        { nome: "Acupuntura" },
        { nome: "Alergia e imunologia" },
        { nome: "Anestesiologia" },
        { nome: "Angiologia" },
        { nome: "Cancerologia" },
        { nome: "Cardiologia" },
        { nome: "Cirurgia cardiovascular" },
        { nome: "Cirurgia de mão" },
        { nome: "Cirurgia de cabeça e pescoço" },
        { nome: "Cirurgia do Aparelho Digestivo" },
        { nome: "Cirurgia Pediátrica" },
        { nome: "Cirurgia Plástica" },
        { nome: "Cirurgia Vascular" },
        { nome: "Clínica Médica" },
        { nome: "Coloproctologia" },
        { nome: "Dermatologia" },
        { nome: "Endocrinologia e Metabologia" },
        { nome: "Endoscopia" },
        { nome: "Gastroenterologia" },
        { nome: "Genética médica" },
        { nome: "Geriatria" },
        { nome: "Ginecologia e obstetrícia" },
        { nome: "Hematologia e Hemoterapia" },
        { nome: "Homeopatia" },
        { nome: "Infectologia" },
        { nome: "Mastologia" },
        { nome: "Medicina de Família e Comunidade" },
        { nome: "Medicina do Trabalho" },
        { nome: "Medicina do Tráfego" },
        { nome: "Medicina Esportiva" },
        { nome: "Medicina Física e Reabilitação" },
        { nome: "Medicina Intensiva" },
        { nome: "Medicina Legal e Perícia Médica" },
        { nome: "Medicina Nuclear" },
        { nome: "Medicina Preventiva e Social" },
        { nome: "Nefrologia" },
        { nome: "Neurocirurgia" },
        { nome: "Neurologia" },
        { nome: "Obstetrícia" },
        { nome: "Oftalmologia" },
        { nome: "Ortopedia e Traumatologia" },
        { nome: "Otorrinolaringologia" },
        { nome: "Patologia" },
        { nome: "Patologia Clínica/Medicina laboratorial" },
        { nome: "Pediatria" },
        { nome: "Pneumologia" },
        { nome: "Psiquiatria" },
        { nome: "Radiologia" },
        { nome: "Radioterapia" },
        { nome: "Reumatologia" },
        { nome: "Urologia" }
      ]
    };
  },
  methods: {
    cadastrarMedico() {
      Vue.axios
        .post("user", {
          nome: this.novoMedico.nome,
          cpf: this.novoMedico.cpf,
          senha: this.novoMedico.senha,
          tipo: this.novoMedico.tipo
        })
        .then(response => {
          Vue.axios
            .post("medico", {
              especialidade: this.novoMedico.especialidade,
              crm: this.novoMedico.crm,
              user_id: response.data.id
            })
            .then(response => {
              alert("Médico cadastrado com sucesso");
              this.limparFormulario();
              this.atualizarLista();
            })
            .catch(() => {
              alert("Falha ao cadastrar médico");
            });
        })
        .catch(() => {
          alert("Falha ao cadastrar usuário");
        });
    },
    exibirMedico(medico) {
      this.edicao = true;
      this.novoMedico.nome = medico.user.nome;
      this.novoMedico.cpf = medico.user.cpf;
      this.novoMedico.especialidade = medico.especialidade;
      this.novoMedico.crm = medico.crm;
      this.novoMedico.id = medico.id;
    },
    excluirMedico(medico) {
      if (confirm("Deseja realmente excluir este médico?")) {
        Vue.axios
          .get(`medico/${medico.id}?expand=user`)
          .then(response => {
            const userID = response.data.user_id;
            const medicoID = response.data.id;
            Vue.axios
              .delete(`medico/${medicoID}`)
              .then(response => {
                Vue.axios
                  .delete(`user/${userID}`)
                  .then(response => {
                    alert("Médico deletado com sucesso");
                    this.atualizarLista();
                  })
                  .catch(() => {
                    alert("Falha ao deletar médico");
                  });
              })
              .catch(() => {
                alert("Falha ao deletar médico");
              });
          })
          .catch(() => {
            alert("Falha ao recuperar médico");
          });
      }
      this.limparFormulario();
    },
    atualizarMedico() {
      if (confirm("Deseja realmente atualizar este médico?")) {
        Vue.axios
          .get(`medico/${this.novoMedico.id}?expand=user`)
          .then(response => {
            const userID = response.data.user.id;
            const medicoID = response.data.id;

            if (this.novoMedico.senha.length === 0) {
              delete this.novoMedico.senha;
            }
            Vue.axios
              .put(`user/${userID}`, {
                nome: this.novoMedico.nome,
                cpf: this.novoMedico.cpf,
                senha: this.novoMedico.senha
              })
              .then(response => {
                Vue.axios
                  .put(`medico/${medicoID}`, {
                    especialidade: this.novoMedico.especialidade,
                    crm: this.novoMedico.crm
                  })
                  .then(response => {
                    alert("Médico atualizado com sucesso");
                    this.limparFormulario();
                    this.atualizarLista();
                  })
                  .catch(() => {
                    alert("Falha ao atualizar dados");
                  });
              })
              .catch(() => {
                alert("Falha ao atualizar dados");
              });
          })
          .catch(() => {
            alert("Falha ao recuperar dados");
          });
      }
    },
    atualizarLista() {
      Vue.axios
        .get("medico?expand=user")
        .then(response => {
          this.listaMedicos = response.data;
        })
        .catch(() => {
          alert("Falha ao recuperar médicos");
        });
    },
    limparFormulario() {
      this.edicao = false;
      this.novoMedico.nome = "";
      this.novoMedico.cpf = "";
      this.novoMedico.senha = "";
      this.novoMedico.especialidade = "";
      this.novoMedico.crm = "";
      this.novoMedico.user_id = "";
    }
  },
  created() {
    this.atualizarLista();
  }
};
</script>
