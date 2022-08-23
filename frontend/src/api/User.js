import Vue from 'vue';

export default {
  cadastrar (user, success, error) {
    Vue.axios.post('user', { ...user }).then((response) => {
      if (Math.floor(response.status / 100) == 2) {
        if (success) success(response.data);
      }
    }).catch((err) => {
      if (error) error(err);
    });
  },
  autenticar (user, success, error) {
    Vue.axios.post('user/login', {
      ...user
    }).then((response) => {
      if (response.status == 200) {
        if ((typeof response.data.token != 'undefined') && (response.data.token != '')) {
          localStorage.setItem("token", response.data.token);
          localStorage.setItem("cpf", response.data.usuario.cpf);
          localStorage.setItem("nome", response.data.usuario.nome);
          localStorage.setItem("tipo", response.data.usuario.tipo);
          localStorage.setItem("id", Number(response.data.usuario.id));
          if (success) success(response.data);
        }
      } else error();
    }).catch(() => {
      if (error) error();
    });
  },
  atualizar (user, success, error) {
    if (user.senha.length === 0) {
      delete user.senha
    }
    
    Vue.axios.put(`user/${user.id}`, { ...user }).then((response) => {
      if (Math.floor(response.status / 100) == 2) {
        localStorage.removeItem("user");
        localStorage.removeItem("nome");
        localStorage.removeItem("email");

        localStorage.setItem("user", user.login);
        localStorage.setItem("nome", user.nome);
        localStorage.setItem("email", user.email);
        if (success) success(response.data);
      }
    }).catch((err) => {
      if (error) error(err);
    });
  },
};
