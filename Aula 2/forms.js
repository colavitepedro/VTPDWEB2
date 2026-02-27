
document.getElementById('fotoPerfil').addEventListener('change', function(e) {
  const fileName = e.target.files[0] ? e.target.files[0].name : 'Nenhum arquivo escolhido';
  e.target.nextElementSibling.textContent = fileName;
});

document.getElementById('contrato').addEventListener('change', function(e) {
  const fileName = e.target.files[0] ? e.target.files[0].name : 'Nenhum arquivo escolhido';
  e.target.nextElementSibling.textContent = fileName;
});

document.getElementById('telefone').addEventListener('input', function(e) {
  let value = e.target.value.replace(/\D/g, '');
  value = value.replace(/^(\d{2})(\d{5})(\d{4}).*/, '($1)$2-$3');
  e.target.value = value;
});

document.getElementById('cpf').addEventListener('input', function(e) {
  let value = e.target.value.replace(/\D/g, '');
  value = value.replace(/^(\d{3})(\d{3})(\d{3})(\d{2}).*/, '$1.$2.$3-$4');
  e.target.value = value;
});

document.getElementById('cep').addEventListener('input', function(e) {
  let value = e.target.value.replace(/\D/g, '');
  value = value.replace(/^(\d{2})(\d{3})(\d{3}).*/, '$1.$2-$3');
  e.target.value = value;
});

document.getElementById('cadastroForm').addEventListener('submit', function(e) {
  e.preventDefault();
  
  const fotoPerfil = document.getElementById('fotoPerfil').files[0];
  if (fotoPerfil && !fotoPerfil.type.startsWith('image/')) {
    alert('Por favor, selecione apenas arquivos de imagem para a foto de perfil.');
    return;
  }

  const contrato = document.getElementById('contrato').files[0];
  if (contrato && contrato.type !== 'application/pdf') {
    alert('Por favor, selecione apenas arquivos PDF para o contrato.');
    return;
  }

  alert('Formulário enviado com sucesso!');
});