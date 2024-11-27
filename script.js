document.getElementById('loginForm').addEventListener('submit', async function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());

    const response = await fetch('api/autenticar.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data),
    });

    const result = await response.json();
    if (result.success) {
        alert('Login realizado com sucesso!');
        window.location.href = 'cardapio.php';
    } else {
        document.getElementById('error').textContent = result.error;
    }
});
