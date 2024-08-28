document.getElementById('registration-form').addEventListener('submit', function (event) {
    let errorMessage = '';
    const nome = document.getElementById('nome').value.trim();
    const email = document.getElementById('email').value.trim();
    const senha = document.getElementById('senha').value.trim();
    if (!nome) {
      errorMessage += 'Preencha os Campos.\n';
    }
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      errorMessage += 'Digite um e-mail válido.\n';
    }
    if (senha.length < 8) {
      errorMessage += 'A senha deve conter pelo menos 8 caracteres.\n';
    }
    if (errorMessage) {
      document.getElementById('error-message').textContent = errorMessage;
      event.preventDefault();
    }
  });
  