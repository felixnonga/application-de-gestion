// logout.js
document.getElementById('logoutButton').addEventListener('click', function() {
    fetch('logout.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = 'login.php'; // Rediriger vers la page de connexion
        } else {
            alert('Échec de la déconnexion. Veuillez réessayer.');
        }
    })
    .catch(error => console.error('Erreur:', error));
});
