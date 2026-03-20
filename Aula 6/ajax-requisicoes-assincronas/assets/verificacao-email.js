document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('emailForm');
  const input = document.getElementById('email');
  const feedback = document.getElementById('emailFeedback');
  const submitButton = document.getElementById('emailSubmitButton');
  const originalButtonText = submitButton.textContent;

  const limparFeedback = () => {
    input.classList.remove('is-valid', 'is-invalid');
    feedback.textContent = '';
    feedback.className = 'feedback-text small mt-2';
  };

  const aplicarFeedback = (dados) => {
    input.classList.remove('is-valid', 'is-invalid');

    if (dados.fieldClass) {
      input.classList.add(dados.fieldClass);
    }

    feedback.textContent = dados.mensagem ?? '';
    feedback.className = `feedback-text small mt-2 ${dados.feedbackClass ?? ''}`.trim();
  };

  form.addEventListener('submit', async (event) => {
    event.preventDefault();
    limparFeedback();

    const emailAtual = (input.value || '').trim().toLowerCase();
    input.value = emailAtual;

    const formData = new FormData(form);

    submitButton.disabled = true;
    submitButton.textContent = 'Verificando...';

    try {
      const response = await fetch('verificar-email.php', {
        method: 'POST',
        body: formData,
      });

      const dados = await response.json().catch(() => ({
        status: 'error',
        mensagem: 'Não foi possível interpretar a resposta do servidor.',
        fieldClass: 'is-invalid',
        feedbackClass: 'text-danger',
      }));

      aplicarFeedback(dados);
    } catch (error) {
      aplicarFeedback({
        mensagem: 'Não foi possível concluir a verificação agora.',
        fieldClass: 'is-invalid',
        feedbackClass: 'text-danger',
      });
    } finally {
      submitButton.disabled = false;
      submitButton.textContent = originalButtonText;
    }
  });
});
