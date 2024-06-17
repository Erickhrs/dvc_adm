document.getElementById('change-password-form').addEventListener('submit', function(event) {
    event.preventDefault();
    
    const currentPassword = document.getElementById('current-password').value;
    const newPassword = document.getElementById('new-password').value;
    const confirmPassword = document.getElementById('confirm-password').value;
    const messageElement = document.getElementById('message');
    
    if (newPassword !== confirmPassword) {
        messageElement.textContent = 'As novas senhas não coincidem.';
        return;
    }
    
    if (newPassword.length < 6) {
        messageElement.textContent = 'A nova senha deve ter pelo menos 6 caracteres.';
        return;
    }
    
    messageElement.style.color = 'green';
    messageElement.textContent = 'Senha alterada com sucesso!';
    
    // Aqui você pode adicionar a lógica para enviar os dados ao servidor
});