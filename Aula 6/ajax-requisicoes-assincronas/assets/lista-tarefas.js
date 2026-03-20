document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('taskForm');
  const statusBox = document.getElementById('taskStatus');
  const tableContainer = document.getElementById('taskTableContainer');
  const submitButton = document.getElementById('taskSubmitButton');
  const clearButton = document.getElementById('clearTasksButton');
  const originalSubmitText = submitButton.textContent;
  const originalClearText = clearButton.textContent;

  const mostrarMensagem = (mensagem, tipo) => {
    statusBox.textContent = mensagem;
    statusBox.className = `alert alert-${tipo} status-alert mt-4`;
  };

  const esconderMensagem = () => {
    statusBox.textContent = '';
    statusBox.className = 'alert d-none status-alert mt-4';
  };

  const atualizarTabela = (htmlTabela) => {
    tableContainer.innerHTML = htmlTabela;
  };

  const carregarTarefas = async () => {
    try {
      const response = await fetch('tarefas.php?acao=listar');
      const dados = await response.json();

      if (dados.htmlTabela) {
        atualizarTabela(dados.htmlTabela);
      }

      if (dados.status !== 'success') {
        mostrarMensagem(dados.mensagem || 'Não foi possível carregar a lista de tarefas.', 'danger');
      }
    } catch (error) {
      mostrarMensagem('Não foi possível carregar a lista de tarefas.', 'danger');
    }
  };

  form.addEventListener('submit', async (event) => {
    event.preventDefault();
    esconderMensagem();

    const formData = new FormData(form);
    formData.append('acao', 'cadastrar');

    submitButton.disabled = true;
    submitButton.textContent = 'Cadastrando...';

    try {
      const response = await fetch('tarefas.php', {
        method: 'POST',
        body: formData,
      });

      const dados = await response.json();

      if (dados.htmlTabela) {
        atualizarTabela(dados.htmlTabela);
      }

      if (dados.status === 'success') {
        mostrarMensagem(dados.mensagem, 'success');
        form.reset();

        const prioridadeAlta = document.getElementById('prioridadeAlta');

        if (prioridadeAlta) {
          prioridadeAlta.checked = true;
        }
      } else {
        mostrarMensagem(dados.mensagem, 'danger');
      }
    } catch (error) {
      mostrarMensagem('Não foi possível cadastrar a tarefa agora.', 'danger');
    } finally {
      submitButton.disabled = false;
      submitButton.textContent = originalSubmitText;
    }
  });

  clearButton.addEventListener('click', async () => {
    const confirmou = window.confirm('Deseja realmente apagar todas as tarefas?');

    if (!confirmou) {
      return;
    }

    esconderMensagem();
    clearButton.disabled = true;
    clearButton.textContent = 'Apagando...';

    try {
      const formData = new FormData();
      formData.append('acao', 'apagar');

      const response = await fetch('tarefas.php', {
        method: 'POST',
        body: formData,
      });

      const dados = await response.json();

      if (dados.htmlTabela) {
        atualizarTabela(dados.htmlTabela);
      }

      if (dados.status === 'success') {
        mostrarMensagem(dados.mensagem, 'warning');
      } else {
        mostrarMensagem(dados.mensagem, 'danger');
      }
    } catch (error) {
      mostrarMensagem('Não foi possível apagar as tarefas agora.', 'danger');
    } finally {
      clearButton.disabled = false;
      clearButton.textContent = originalClearText;
    }
  });

  carregarTarefas();
});
