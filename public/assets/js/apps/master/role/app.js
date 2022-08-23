const modalRole = new bootstrap.Modal(document.querySelector("#modalRole"));
const idRoleInput = document.querySelector("#idRole");
const oldSlugRoleInput = document.querySelector("#oldSlugRole");
const nameRoleInput = document.querySelector("#nameRole");
const nameRoleFeedback = document.querySelector("#nameRoleFeedback");
const descriptionRoleInput = document.querySelector("#descriptionRole");
const descriptionRoleFeedback = document.querySelector(
    "#descriptionRoleFeedback"
);
const btnAdd = document.querySelector("#btn-add");
const btnSubmit = document.querySelector("#btn-submit");

let url, data;

const role = {
    onLoad: async() => {
        blockUI();
        const results = await fetch(`${baseUrl}/master/roles/get-all-data`)
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
            .then((response) => role.setTable(response));

        unBlockUI();
    },

    setTable: (results) => {
        $("#tb-role").DataTable({
            processing: true,
            destroy: true,
            data: results,
        });
    },

    onInit: () => {
        role.onLoad();
    },

    addNew: () => {
        modalRole.show();
        nameRoleInput.classList.remove("is-invalid");
        descriptionRoleInput.classList.remove("is-invalid");
        idRoleInput.value = "";
        oldSlugRoleInput.value = "";
        nameRoleInput.value = "";
        descriptionRoleInput.value = "";
        btnSubmit.setAttribute("data-type", "add-new");
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

    editData: async(slug) => {
        await fetch(`${baseUrl}/master/roles/${slug}/edit`)
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
            .then((response) => {
                modalRole.show();
                nameRoleInput.classList.remove("is-invalid");
                descriptionRoleInput.classList.remove("is-invalid");
                idRoleInput.value = response.id;
                slugRoleInput.value = response.slug;
                oldSlugRoleInput.value = response.slug;
                nameRoleInput.value = response.name;
                descriptionRoleInput.value = response.description;
                btnSubmit.setAttribute("data-type", "edit-data");
            });
    },

    deleteData: async(slug, csrf) => {
        url = `${baseUrl}/master/roles/${slug}`;

        await Swal.fire({
            icon: "info",
            title: "Hapus Data",
            text: "Anda yakin akan mengubah data ini?",
            showCancelButton: true,
            confirmButtonColor: "#435ebe",
            confirmButtonText: "Ya",
            cancelButtonColor: "#dc3545",
            cancelButtonText: "Tidak",
        }).then(async(result) => {
            if (result.value) {
                blockUI();

                data = JSON.stringify({
                    slug: slug,
                    _token: csrf,
                });

                const results = await role.postData(url, data, "delete");

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

                    role.onInit();
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

role.onInit();

btnAdd.addEventListener("click", () => {
    role.addNew();
});

btnSubmit.addEventListener("click", async() => {
    let type = btnSubmit.dataset.type;
    let csrf = btnSubmit.dataset.csrf;

    if (type == "add-new") {
        url = `${baseUrl}/master/roles`;

        data = JSON.stringify({
            name: nameRoleInput.value,
            description: descriptionRoleInput.value,
            _token: csrf,
        });

        blockModal();

        const results = await role.postData(url, data, "post");

        unBlockModal();

        if (results.data.status) {
            Toastify({
                text: results.data.message,
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#198754",
            }).showToast();

            modalRole.hide();
            role.onInit();
        } else {
            if (results.data.message.name || results.data.message.slug) {
                nameRoleInput.classList.add("is-invalid");
                nameRoleFeedback.innerHTML = results.data.message.slug ?
                    results.data.message.slug :
                    results.data.message.name;
            } else {
                nameRoleInput.classList.remove("is-invalid");
            }

            if (results.data.message.description) {
                descriptionRoleInput.classList.add("is-invalid");
                descriptionRoleFeedback.innerHTML =
                    results.data.message.description;
            } else {
                descriptionRoleInput.classList.remove("is-invalid");
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
        url = `${baseUrl}/master/roles/${oldSlugRoleInput.value}`;

        data = JSON.stringify({
            name: nameRoleInput.value,
            description: descriptionRoleInput.value,
            _token: csrf,
        });

        blockModal();

        const results = await role.postData(url, data, "put");

        unBlockModal();

        if (results.data.status) {
            Toastify({
                text: results.data.message,
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#198754",
            }).showToast();

            modalRole.hide();
            role.onInit();
        } else {
            if (results.data.message.name || results.data.message.slug) {
                nameRoleInput.classList.add("is-invalid");
                nameRoleFeedback.innerHTML = results.data.message.slug ?
                    results.data.message.slug :
                    results.data.message.name;
            } else {
                nameRoleInput.classList.remove("is-invalid");
            }

            if (results.data.message.description) {
                descriptionRoleInput.classList.add("is-invalid");
                descriptionRoleFeedback.innerHTML =
                    results.data.message.description;
            } else {
                descriptionRoleInput.classList.remove("is-invalid");
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