const modalUser = new bootstrap.Modal(document.querySelector("#modalUser"));
const usernameInput = document.querySelector("#username");
const usernameFeedback = document.querySelector("#usernameFeedback");
const nameUserInput = document.querySelector("#nameUser");
const nameUserFeedback = document.querySelector("#nameUserFeedback");
const emailUserInput = document.querySelector("#emailUser");
const emailUserFeedback = document.querySelector("#emailUserFeedback");
const roleUserInput = document.querySelector("#roleUser");
const countryUserInput = document.querySelector("#countryUser");
const passwordUserInput = document.querySelector("#passwordUser");
const passwordUserFeedback = document.querySelector("#passwordUserFeedback");
const btnAdd = document.querySelector("#btn-add");
const btnSubmit = document.querySelector("#btn-submit");

const roleUserChoices = new Choices(roleUserInput);
const countryUserChoices = new Choices(countryUserInput);

let url,
    data,
    method,
    tbUser = $("#tb-user").DataTable({
        ajax: `${baseUrl}/users/get-all-data`,
        processing: true,
        serverSide: true,
    }),
    templateUser;

const user = {
    createDropdown: async(url, choices, placeholder, selected) => {
        choices.clearStore();

        choices.setChoices([{
            label: placeholder,
            value: "",
            disabled: true,
        }, ]);

        if (typeof url == "object") {
            choices.setChoices(url);
        } else {
            await fetch(url)
                .then((response) => {
                    if (!response.ok) {
                        throw new Error(
                            Toastify({
                                text: "Terjadi kesalahan saat mengambil data",
                                duration: 3000,
                                close: true,
                                gravity: "top",
                                position: "right",
                                backgroundColor: "#dc3545",
                            }).showToast()
                        );
                    }

                    return response.json();
                })
                .then((response) => choices.setChoices(response));
        }

        choices.setChoiceByValue(selected);
    },

    onLoad: async() => {
        blockUI();

        tbUser.ajax.url(`${baseUrl}/users/get-all-data`).draw();

        unBlockUI();
    },

    addNew: async() => {
        modalUser.show();
        usernameInput.classList.remove("is-invalid");
        nameUserInput.classList.remove("is-invalid");
        emailUserInput.classList.remove("is-invalid");
        passwordUserInput.classList.remove("is-invalid");

        usernameInput.value = "";
        emailUserInput.value = "";
        nameUserInput.value = "";
        passwordUserInput.value = "";
        btnSubmit.setAttribute("data-type", "add-new");

        await user.createDropdown(
            `${baseUrl}/dropdown/get-role`,
            roleUserChoices,
            "Select a role",
            ""
        );

        await user.createDropdown(
            `${baseUrl}/dropdown/get-country`,
            countryUserChoices,
            "Select a country",
            ""
        );

        templateUserCheck.forEach((item) => {
            item.checked = false;
        });
    },

    postData: async(url, data, method) => {
        return await fetch(url, {
                method: method,
                body: data,
                headers: {
                    "Content-Type": "application/json",
                },
            })
            .then((response) => {
                if (!response.ok) {
                    throw new Error(
                        Toastify({
                            text: "Terjadi kesalahan saat mengambil data",
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "#dc3545",
                        }).showToast()
                    );
                }

                return response.json();
            })
            .then((response) => response);
    },

    editData: async(username) => {
        url = `${baseUrl}/users/${username}/edit`;

        await fetch(url)
            .then((response) => {
                if (!response.ok) {
                    throw new Error(
                        Toastify({
                            text: "Terjadi kesalahan saat mengambil data",
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "#dc3545",
                        }).showToast()
                    );
                }

                return response.json();
            })
            .then(async(response) => {
                modalUser.show();
                usernameInput.classList.remove("is-invalid");
                nameUserInput.classList.remove("is-invalid");
                emailUserInput.classList.remove("is-invalid");
                passwordUserInput.classList.remove("is-invalid");

                usernameInput.disabled = true;
                usernameInput.value = response.username;
                emailUserInput.value = response.email;
                nameUserInput.value = response.name;
                passwordUserInput.value = "";

                await user.createDropdown(
                    `${baseUrl}/dropdown/get-role`,
                    roleUserChoices,
                    "Select a role",
                    parseInt(response.role_id)
                );

                await user.createDropdown(
                    `${baseUrl}/dropdown/get-country`,
                    countryUserChoices,
                    "Select a country",
                    parseInt(response.country_id)
                );

                btnSubmit.setAttribute("data-type", "edit-data");
            });
    },

    deleteData: async(id, csrf) => {
        url = `${baseUrl}/users/${id}`;

        await Swal.fire({
            icon: "info",
            title: "Delete Data",
            text: "Are you sure to delete this data?",
            showCancelButton: true,
            confirmButtonColor: "#435ebe",
            confirmButtonText: "Yes, I'm Sure",
            cancelButtonColor: "#dc3545",
            cancelButtonText: "No, Cancel",
        }).then(async(result) => {
            if (result.value) {
                blockUI();

                data = JSON.stringify({
                    _token: csrf,
                });

                const results = await user.postData(url, data, "delete");

                unBlockUI();

                if (results.data.status) {
                    Toastify({
                        text: results.data.message,
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "#198754",
                    }).showToast();

                    user.onLoad();
                } else {
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
    },
};

btnAdd.addEventListener("click", async() => {
    await user.addNew();
});

btnSubmit.addEventListener("click", async() => {
    let type = btnSubmit.dataset.type;
    let csrf = btnSubmit.dataset.csrf;

    if (type == "add-new") {
        data = JSON.stringify({
            username: usernameInput.value,
            name: nameUserInput.value,
            email: emailUserInput.value,
            role: roleUserChoices.getValue(true),
            country: countryUserChoices.getValue(true),
            password: passwordUserInput.value,
            _token: csrf,
        });

        blockModal();

        const results = await user.postData(`${baseUrl}/users`, data, "post");

        unBlockUI();

        if (results.data.status) {
            Toastify({
                text: results.data.message,
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#198754",
            }).showToast();

            modalUser.hide();
            user.onLoad();
        } else {
            if (results.data.message.username) {
                usernameInput.classList.add("is-invalid");
                usernameFeedback.innerHTML = results.data.message.username;
            } else {
                usernameInput.classList.remove("is-invalid");
            }

            if (results.data.message.name) {
                nameUserInput.classList.add("is-invalid");
                nameUserFeedback.innerHTML = results.data.message.name;
            } else {
                nameUserInput.classList.remove("is-invalid");
            }

            if (results.data.message.email) {
                emailUserInput.classList.add("is-invalid");
                emailUserFeedback.innerHTML = results.data.message.email;
            } else {
                emailUserInput.classList.remove("is-invalid");
            }

            if (results.data.message.password) {
                passwordUserInput.classList.add("is-invalid");
                passwordUserFeedback.innerHTML = results.data.message.password;
            } else {
                passwordUserInput.classList.remove("is-invalid");
            }

            if (results.data.message.role) {
                Toastify({
                    text: results.data.message.role,
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#dc3545",
                }).showToast();
            }

            if (results.data.message.country) {
                Toastify({
                    text: results.data.message.country,
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#dc3545",
                }).showToast();
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
    }

    if (type == "edit-data") {
        data = JSON.stringify({
            username: usernameInput.value,
            name: nameUserInput.value,
            email: emailUserInput.value,
            role: roleUserChoices.getValue(true),
            country: countryUserChoices.getValue(true),
            password: passwordUserInput.value,
            _token: csrf,
        });

        blockModal();

        const results = await user.postData(
            `${baseUrl}/users/${usernameInput.value}`,
            data,
            "put"
        );

        unBlockUI();

        if (results.data.status) {
            Toastify({
                text: results.data.message,
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#198754",
            }).showToast();

            modalUser.hide();
            user.onLoad();
        } else {
            if (results.data.message.role) {
                Toastify({
                    text: results.data.message.role,
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#dc3545",
                }).showToast();
            }

            if (results.data.message.country) {
                Toastify({
                    text: results.data.message.country,
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#dc3545",
                }).showToast();
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
    }
});
