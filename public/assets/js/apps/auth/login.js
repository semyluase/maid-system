const passwordInput = document.querySelector("#password");
const passwordIcon = document.querySelector("#password-icon");

const login = {
    onLoad: () => {
        passwordInput.setAttribute("type", "password");
        passwordIcon.style.cursor = "pointer";
        passwordIcon.innerHTML = '<i class="fas fa-eye"></i>';
    },
};

login.onLoad();

passwordIcon.addEventListener("click", () => {
    switch (passwordInput.getAttribute("type")) {
        case "password":
            passwordInput.setAttribute("type", "text");
            passwordIcon.innerHTML = '<i class="fas fa-eye-slash"></i>';
            break;

        default:
            passwordInput.setAttribute("type", "password");
            passwordIcon.innerHTML = '<i class="fas fa-eye"></i>';
            break;
    }
});