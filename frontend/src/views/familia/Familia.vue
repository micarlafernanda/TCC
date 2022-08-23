<template>
  <div>
    <div class="card mb-3 mt-3">
      <div class="card-header">
        <h5 align="center">Cadastro de Família</h5>
      </div>
      <div class="card-body">
        <form @submit.prevent autocomplete="off">
          <div class="form-row">
            <div class="form-group col-6">
              <label for="nome">Número prontuário</label>
              <input v-model="novaFamilia.numeroProntuario" disabled type="text" class="form-control" required="required">
            </div>
            <div class="form-group col-6">
              <label for="especialidade">UBS</label>
              <select v-model="novaFamilia.ubs" name="especialidade" type="text" class="form-control" id="especialidade" required="required">
                <option :selected="novaFamilia.ubs === ubs.nome ? 'selected' : ''" v-for="ubs in listaUbs" :key="ubs.nome" :value="ubs.nome">{{ubs.nome}}</option>
              </select>
            </div>
            <div class="form-group col-5">
              <label for="nome">Responsável pela família (nome completo)</label>
              <input v-model="novaFamilia.nomeResponsavel"  type="text" class="form-control" required="required">
            </div>
            <div class="form-group col-6">
              <label for="posicao">Posição na Família</label>
              <select v-model="novaFamilia.posicaoFamiliar" name="posicao" type="text" class="form-control" id="posicao" required="required">
                <option :selected="novaFamilia.posicaoFamiliar === posicaoFamiliar.tipo ? 'selected' : ''" v-for="posicaoFamiliar in listaParentesco" :key="posicaoFamiliar.tipo" :value="posicaoFamiliar.tipo">{{posicaoFamiliar.tipo}}</option>
              </select>
            </div>

          </div>

          <div class="form-row">

            <div class="form-group col-5">
              <label for="nome">Logradouro</label>
              <input v-model="novoEndereco.logradouro" type="text" class="form-control" required="required">
            </div>
            <div class="form-group col-2">
              <label for="nome">Número</label>
              <input v-model="novoEndereco.numero" type="text" class="form-control" required="required">
            </div>
            <div class="form-group col-5">
              <label for="nome">Bairro</label>
              <input v-model="novoEndereco.bairro" type="text" class="form-control" required="required">
            </div>

          </div>

          <div class="form-row">
          </div>
          <button type="submit" class="btn btn-primary" @click="cadastrarFamilia()" v-if="!edicao">Cadastrar</button>
          <button type="submit" class="btn btn-success" @click="atualizarFamilia()" v-if="edicao">Atualizar</button>
          <button type="submit" class="btn btn-danger ml-2" @click="limparFormulario()">Limpar</button>
        </form>
      </div>
    </div>

    <div class="card mb-3">
      <div class="card-header">
        <i class="fas fa-table"></i>
        Lista de familias</div>
      <div class="card-body">
        <div class="table-responsive table-bordered table-striped">
          <table class="table" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th class="text-center">UBS</th>
                <th class="text-center">Prontuário</th>
                <th class="text-center">Responsável pela família</th>
                <th class="text-center">Posição na Família </th>
                <th class="text-center">Logradouro</th>
                <th class="text-center">Bairro</th>
                <th class="text-center">Opções</th>
              </tr>
            </thead>
            <tbody>

              <tr v-for="familia in listaFamilias" :key="familia.id">
                <td class="text-center align-middle">{{familia.familia.ubs}}</td>
                <td class="text-center align-middle">{{familia.familia.numeroProntuario}}</td>
                <td class="text-center align-middle">{{familia.familia.nomeResponsavel}}</td>
                <td class="text-center align-middle">{{familia.familia.posicaoFamiliar}}</td>
                <td class="text-center align-middle">{{familia.logradouro}}, {{familia.numero}}</td>
                <td class="text-center align-middle">{{familia.bairro}}</td>
                <td class="text-center align-middle">
                  <div class="btn-group">
                    <button class="btn btn-info mr-2" @click="exibirFamilia(familia)"><i class="fas fa-fw fa-plus"></i> Exibir </button>
                    <button class="btn btn-danger" @click="excluirFamilia(familia)"><i class="far fa-fw fa-trash-alt"></i> Excluir </button>
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
  name: "Familia",
  directives: { mask },
  components: {},
  data() {
    return {
      edicao: false,
      novaFamilia: {
        numeroProntuario: String(Math.random())
          .split(".")[1]
          .substr(2, 6),
        ubs: "",
        nomeResponsavel: "",
        posicaoFamiliar: "",
        id: ""
      },
      novoEndereco: {
        logradouro: "",
        numero: "",
        bairro: "",
        familia_id: "",
        id: ""
      },
      listaFamilias: [],
      listaUbs: [
        { nome: "" },
        { nome: "ESF I – Centro de Saúde Francisco Assis do Amaral"},
        { nome: "ESF II – José Aurélio de Medeiros"},
        { nome: "ESF JUCURI II - Raimundo Garcia de Araújo"},
        { nome: "ESF III – Posto de Saúde do Assentamento João da Cruz"},
        { nome: "ESF IV – José Cândido"},
        { nome: "Pronto Atendimento Médico de Urgência Francisco Nobre de Almeida"}
      ],
      listaParentesco: [
        { tipo: "Mãe" },     
        { tipo: "Pai" },  
        { tipo: "Filho (a)" },   
        { tipo: "Outros" }, 
      ]
    };
  },
  methods: {
    cadastrarFamilia() {
      Vue.axios
        .post("familia", {
          numeroProntuario: this.novaFamilia.numeroProntuario,
          ubs: this.novaFamilia.ubs,
          nomeResponsavel: this.novaFamilia.nomeResponsavel,
          posicaoFamiliar: this.novaFamilia.posicaoFamiliar
        })
        .then(response => {
          Vue.axios
            .post("endereco", {
              logradouro: this.novoEndereco.logradouro,
              numero: this.novoEndereco.numero,
              bairro: this.novoEndereco.bairro,
              familia_id: response.data.id
            })
            .then(response => {
              alert("Família cadastrada com sucesso");
              this.limparFormulario();
              this.atualizarLista();
            })
            .catch(() => {
              alert("Falha ao cadastrar endereço");
            });
        })
        .catch(() => {
          alert("Falha ao cadastrar família");
        });
    },
    exibirFamilia(familia) {
      this.edicao = true;
      this.novaFamilia.numeroProntuario = familia.familia.numeroProntuario;
      this.novaFamilia.id = familia.familia.id;
      this.novaFamilia.posicaoFamiliar = familia.familia.posicaoFamiliar;
      this.novaFamilia.ubs = familia.familia.ubs;
      this.novaFamilia.nomeResponsavel = familia.familia.nomeResponsavel;
      this.novoEndereco.id = familia.id;
      this.novoEndereco.logradouro = familia.logradouro;
      this.novoEndereco.numero = familia.numero;
      this.novoEndereco.bairro = familia.bairro;
    },
    excluirFamilia(familia) {
      const familiaID = familia.familia_id;
      const enderecoID = familia.id;

      if (confirm("Deseja realmente excluir esta família?")) {
        Vue.axios
          .delete(`endereco/${enderecoID}`)
          .then(response => {
            Vue.axios
              .delete(`familia/${familiaID}`)
              .then(response => {
                alert("Família deletada com sucesso");
                this.atualizarLista();
              })
              .catch(() => {
                alert("Falha ao deletar família");
              });
          })
          .catch(() => {
            alert("Falha ao deletar endereço");
          });
      }
      this.limparFormulario();
    },
    atualizarFamilia() {
      if (confirm("Deseja realmente atualizar esta família?")) {
        Vue.axios
          .put(`endereco/${this.novoEndereco.id}`, {
            logradouro: this.novoEndereco.logradouro,
            numero: this.novoEndereco.numero,
            bairro: this.novoEndereco.bairro,
          })
          .then(response => {
            Vue.axios
              .put(`familia/${this.novaFamilia.id}`, {
                numeroProntuario: this.novaFamilia.numeroProntuario,
                ubs: this.novaFamilia.ubs,
                nomeResponsavel: this.novaFamilia.nomeResponsavel,
                posicaoFamiliar: this.novaFamilia.posicaoFamiliar
              })
              .then(response => {
                alert("Família atualizada com sucesso");
                this.limparFormulario();
                this.atualizarLista();
              })
              .catch(() => {
                alert("Falha ao atualizar família");
              });
          })
          .catch(() => {
            alert("Falha ao atualizar endereço");
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
    },
    limparFormulario() {
      this.edicao = false;
      this.novaFamilia.numeroProntuario = String(Math.random())
        .split(".")[1]
        .substr(2, 6);
      this.novaFamilia.ubs = "";
      this.novaFamilia.posicaoFamiliar= "";
      this.novaFamilia.nomeResponsavel = "";
      this.novaFamilia.id = "";
      this.novoEndereco.logradouro = "";
      this.novoEndereco.numero = "";
      this.novoEndereco.bairro = "";
      this.novoEndereco.familia_id = "";
      this.novoEndereco.id = "";
    }
  },
  created() {
    this.atualizarLista();
  }
};
</script>
