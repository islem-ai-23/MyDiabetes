document.addEventListener('DOMContentLoaded', () => {
    const container = document.querySelector('.container');
    const registerBtn = document.querySelector('.register-btn');
    const loginBtn = document.querySelector('.login-btn');

    const registerForm = document.querySelector('.form-box.Register form');
    const loginForm = document.querySelector('.form-box.login form');

    let registeredUser = null;

    // Animation bascule entre login / register
    registerBtn.addEventListener('click', () => {
        container.classList.add('active');
    });

    loginBtn.addEventListener('click', () => {
        container.classList.remove('active');
    });

    // Validation email
    function isValidEmail(email) {
        // Regex simple pour valider le format email
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

    // Validation mot de passe
   // function isValidPassword(password) {
   //     const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
    ////    return regex.test(password);
   // }

    // Validation nom d'utilisateur
    function isValidUsername(username) {
        const regex = /^[a-zA-Z0-9]{4,20}$/;
        return regex.test(username);
    }

    // Formulaire d'inscription
    
   
});
