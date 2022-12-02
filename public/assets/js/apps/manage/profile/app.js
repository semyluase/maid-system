const usernameInput = document.querySelector("#username");
const profilNameInput = document.querySelector("#profilName");
const profilEmailInput = document.querySelector("#profilEmail");
const profilAboutMeInput = document.querySelector("#aboutMe");
const oldPasswordInput = document.querySelector("#oldPassword");
const oldPasswordFeedback = document.querySelector("#oldPasswordFeedback");
const newPasswordInput = document.querySelector("#newPassword");
const newPasswordFeedback = document.querySelector("#newPasswordFeedback");
const confirmPasswordInput = document.querySelector("#confirmPassword");
const confirmPasswordFeedback = document.querySelector(
    "#confirmPasswordFeedback"
);
const profilePicture = document.querySelector("#profilePicture");
const profilePictureFile = document.querySelector("#profilePictureFile");
const aboutMe = document.querySelector("#aboutMeText");

const formUser = document.querySelector("#form-profile");
const btnSave = document.querySelector("#simpan-profile");

let url, data;

const profile = {
    onLoad: async() => {
        oldPasswordInput.classList.remove("is-invalid");
        newPasswordInput.classList.remove("is-invalid");
        confirmPasswordInput.classList.remove("is-invalid");
        oldPasswordInput.value = "";
        newPasswordInput.value = "";
        confirmPasswordInput.value = "";

        await fetch(
                `${baseUrl}/manage/profile-get-profile/${usernameInput.value}`
            )
            .then((response) => {
                if (!response.ok) {
                    throw new Error(
                        Toastify({
                            text: "Something wrong while send data",
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
            .then((response) => {
                aboutMe.innerHTML = response.about_me;
            });
    },

    postData: async(url, data, method) => {
        return await fetch(url, {
                method: method,
                body: data,
            })
            .then((response) => {
                if (!response.ok) {
                    throw new Error(
                        Toastify({
                            text: "Something wrong while send data",
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

btnSave.addEventListener("click", async(e) => {
    blockUI();

    const results = await profile.postData(
        `${baseUrl}/manage/profile/change-profile`,
        new FormData(formUser),
        "post"
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

        history.replaceState(null, null, `${baseUrl}/manage/profile`);
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

profilePictureFile.addEventListener("change", async(e) => {
    profilePicture.src = URL.createObjectURL(e.target.files[0]);
});