// phone mask
$(document).ready(function() {
    $('#phone').on('input', function(event) {
        let phone = event.target.value.replace(/\D/g, '');
        let formattedPhone = '';

        if (phone.length <= 10) {
            formattedPhone = phone.replace(/^(\d{2})(\d{4})(\d{4})$/, '($1) $2-$3');
        } else if (phone.length > 10) {
            formattedPhone = phone.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
        }

        event.target.value = formattedPhone;
    });
});

// pre-validation password
document.addEventListener('DOMContentLoaded', function () {
    const passwordInput = document.getElementById('password');
    const passwordFormGroup = document.getElementById('password-group');
    const passwordHint = document.querySelector('.password-hint');
    
    if(passwordHint){
        passwordHint.style.display = 'none';

        passwordInput.addEventListener('focus', function () {
            passwordHint.style.display = 'block'
        });

        passwordInput.addEventListener('blur', function () {
            passwordHint.style.display = 'none';
        });

        passwordInput.addEventListener('input', function () {
            const passwordValue = passwordInput.value;
            const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+{}\[\]:;<>,.?/~`|\\-]).{8,}$/;
                        
            if (!regex.test(passwordValue)) {
                passwordInput.classList.add('border-danger');
            } else {
                passwordInput.classList.remove('border-danger');
            }
        });
    }
});

// need this to work together with AccessControl and redirection when there are registration/login errors/problems.
document.addEventListener("DOMContentLoaded", function () {
    const pagesToRedirect = [
        { page: "processRegister.php", redirectUrl: "/registration" },
        { page: "processLogin.php", redirectUrl: "/" }
    ];

    pagesToRedirect.forEach(function (page) {
        if (window.location.pathname.includes(page.page)) {
            setTimeout(function () {
                window.location.href = page.redirectUrl;
            }, 3000);
        }
    });
});

// Logout button
document.addEventListener('DOMContentLoaded', function() {
    const logoutBtn = document.getElementById('logoutBtn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function () {
            fetch('/backend/logout.php', {
                method: 'POST',
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '/';
                } else {
                    alert('Erro ao tentar sair.');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Houve um erro ao tentar sair.');
            });
        });
    }
});

// remove mask
function removeMask(phone) {
    return phone.replace(/\D/g, '');
}

// remove mask on submit
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('myForm');
    if (form) {
        form.addEventListener('submit', function (event) {
            const phoneInput = document.getElementById('phone');
            if (phoneInput) {
                phoneInput.value = removeMask(phoneInput.value);
            }
        });
    }
});

// mark task as completed
function markAsCompleted(taskId) {
    fetch('/backend/processTask.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `ID=${taskId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const button = document.querySelector(`button[onclick="markAsCompleted(${taskId})"]`);
            button.classList.remove("btn-success");
            button.classList.add("btn-secondary");
            button.disabled = true;
            button.textContent = "Concluído";

            const taskItem = button.closest(".todo-item");
            const dateElement = document.createElement("small");
            dateElement.className = "text-muted";
            dateElement.textContent = `Concluída em: ${data.completionDate}`;
            taskItem.appendChild(dateElement);
        } else {
            alert("Erro ao concluir a tarefa.");
        }
    })
    .catch(error => console.error("Erro:", error));
}
