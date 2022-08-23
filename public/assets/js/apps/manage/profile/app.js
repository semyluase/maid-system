const usernameInput = document.querySelector("#username");
const profilNameInput = document.querySelector("#profilName");
const profilEmailInput = document.querySelector("#profilEmail");
const oldPasswordInput = document.querySelector("#oldPassword");
const oldPasswordFeedback = document.querySelector("#oldPasswordFeedback");
const newPasswordInput = document.querySelector("#newPassword");
const newPasswordFeedback = document.querySelector("#newPasswordFeedback");
const confirmPasswordInput = document.querySelector("#confirmPassword");
const confirmPasswordFeedback = document.querySelector(
    "#confirmPasswordFeedback"
);
const btnSubmitProfile = document.querySelector("#simpan-profile");
const btnSubmitPassword = document.querySelector("#ganti-password");

let url, data;

const profile = {
    onLoad: async() => {
        oldPasswordInput.classList.remove("is-invalid");
        newPasswordInput.classList.remove("is-invalid");
        confirmPasswordInput.classList.remove("is-invalid");
        oldPasswordInput.value = "";
        newPasswordInput.value = "";
        confirmPasswordInput.value = "";
    },

    postData: async(url, data, method, csrf) => {
        return await fetch(url, {
                method: method,
                body: data,
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrf,
                },
            })
            .then((response) => {
                if (!response.ok) {
                    throw new Error(
                        Toastify({
                            text: "Terjadi kesalahan saat pengiriman data",
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "#EF5950",
                        }).showToast()
                    );
                }

                return response.json();
            })
            .then((response) => response);
    },
};

profile.onLoad();

btnSubmitProfile.addEventListener("click", async() => {
    let csrf = btnSubmitProfile.dataset.csrf;

    data = JSON.stringify({
        username: usernameInput.value,
        name: profilNameInput.value,
        email: profilNameInput.value,
        _token: csrf,
    });

    blockUI();

    const results = await profile.postData(
        `${baseUrl}/manage/profile/change-profile/${usernameInput.value}`,
        data,
        "put",
        csrf
    );

    unBlockUI();

    if (results.data.status) {
        Toastify({
            text: results.data.message,
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: "#769769",
        }).showToast();

        profile.onLoad();
    } else {
        Toastify({
            text: results.data.message,
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: "#EF5950",
        }).showToast();
    }
});

btnSubmitPassword.addEventListener("click", async() => {
    let csrf = btnSubmitPassword.dataset.csrf;

    data = JSON.stringify({
        oldPassword: oldPasswordInput.value,
        newPassword: newPasswordInput.value,
        confirmPassword: confirmPasswordInput.value,
        _token: csrf,
    });

    blockUI();

    const results = await profile.postData(
        `${baseUrl}/manage/profile/change-password/${usernameInput.value}`,
        data,
        "put",
        csrf
    );

    unBlockUI();

    if (results.data.status) {
        Toastify({
            text: results.data.message,
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: "#769769",
        }).showToast();

        profile.onLoad();
    } else {
        if (results.data.message.oldPassword) {
            oldPasswordInput.classList.add("is-invalid");
            oldPasswordFeedback.innerHTML = results.data.message.oldPassword;
        } else {
            oldPasswordInput.classList.remove("is-invalid");
        }

        if (results.data.message.newPassword) {
            newPasswordInput.classList.add("is-invalid");
            newPasswordFeedback.innerHTML = results.data.message.newPassword;
        } else {
            newPasswordInput.classList.remove("is-invalid");
        }

        if (results.data.message.confirmPassword) {
            confirmPasswordInput.classList.add("is-invalid");
            confirmPasswordFeedback.innerHTML =
                results.data.message.confirmPassword;
        } else {
            confirmPasswordInput.classList.remove("is-invalid");
        }

        if (typeof results.data.message === "string") {
            Toastify({
                text: results.data.message,
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#dc3545",
            }).showToast();
        }
    }
});