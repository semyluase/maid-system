const modalEnum = new bootstrap.Modal(document.querySelector("#modalEnum"));
const idEnumInput = document.querySelector("#idEnum");
const oldSlugEnumInput = document.querySelector("#oldSlugEnum");
const codeEnumInput = document.querySelector("#codeEnum");
const codeEnumFeedback = document.querySelector("#codeEnumFeedback");
const nameEnumInput = document.querySelector("#nameEnum");
const nameEnumFeedback = document.querySelector("#nameEnumFeedback");
const nameHKEnumInput = document.querySelector("#nameHKEnum");
const nameHKEnumFeedback = document.querySelector("#nameHKEnumFeedback");
const categoryEnumInput = document.querySelector("#categoryEnum");
const categoryEnumFeedback = document.querySelector("#categoryEnumFeedback");
const btnAdd = document.querySelector("#btn-add");
const btnSave = document.querySelector("#btn-submit");

let url, data, method, tbEnum;

const enumeration = {
    onInit: async() => {
        blockUI();
        tbEnum = $("#tb-enum").DataTable({
            ajax: `${baseUrl}/master/enumerations/get-all-data`,
            serverSide: true,
            columnDefs: [{ orderable: false, targets: [6] }],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"],
            ],
            processing: true,
        });

        unBlockUI();
    },

    onLoad: async() => {
        tbEnum.ajax.url(`${baseUrl}/master/enumerations/get-all-data`).draw();
    },

    onSave: async(url, data, method) => {
        return await fetch(url, {
                method: method,
                body: data,
                headers: {
                    "Content-Type": "application/json",
                },
            })
            .then((response) => {
                if (!response.ok) {
                    unBlockModal();
                    throw new Error(
                        Toastify({
                            text: "Something wrong while sending the data",
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
    onAdd: async() => {
        blockModal();

        modalEnum.show();

        codeEnumInput.classList.remove("is-invalid");
        nameEnumInput.classList.remove("is-invalid");
        nameHKEnumInput.classList.remove("is-invalid");
        categoryEnumInput.classList.remove("is-invalid");

        idEnumInput.value = "";
        oldSlugEnumInput.value = "";
        codeEnumInput.value = "";
        nameEnumInput.value = "";
        nameHKEnumInput.value = "";
        categoryEnumInput.value = "";

        btnSave.setAttribute("data-type", "add-data");

        unBlockModal();
    },

    onEdit: async(slug) => {
        blockUI();
        await fetch(`${baseUrl}/master/enumerations/${slug}/edit`)
            .then((response) => {
                if (!response.ok) {
                    unBlockUI();
                    throw new Error(
                        Toastify({
                            text: "Something wrong while get the data",
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
                modalEnum.show();

                codeEnumInput.classList.remove("is-invalid");
                nameEnumInput.classList.remove("is-invalid");
                nameHKEnumFeedback.classList.remove("is-invalid");
                categoryEnumInput.classList.remove("is-invalid");

                idEnumInput.value = response.id;
                oldSlugEnumInput.value = response.slug;
                codeEnumInput.value = response.code;
                nameEnumInput.value = response.name;
                nameHKEnumInput.value = response.name_hk;
                categoryEnumInput.value = response.category;

                btnSave.setAttribute("data-type", "edit-data");
                unBlockUI();
            });
    },

    onDelete: async(slug, csrf) => {
        await swalWithBootstrapButtons
            .fire({
                icon: "info",
                title: "Delete Data",
                text: "Are you sure to delete this data?",
                showCancelButton: true,
                confirmButtonColor: "#435ebe",
                confirmButtonText: "Yes, I'm Sure",
                cancelButtonColor: "#dc3545",
                cancelButtonText: "No, Cancel",
            })
            .then(async(result) => {
                if (result.value) {
                    blockUI();

                    data = JSON.stringify({
                        _token: csrf,
                    });

                    const results = await enumeration.onSave(
                        `${baseUrl}/master/enumerations/${slug}`,
                        data,
                        "delete"
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

                        enumeration.onLoad();
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

enumeration.onInit();

btnAdd.addEventListener("click", async() => {
    await enumeration.onAdd();
});

btnSave.addEventListener("click", async() => {
    switch (btnSave.dataset.type) {
        case "add-data":
            url = `${baseUrl}/master/enumerations`;

            data = JSON.stringify({
                code: codeEnumInput.value,
                name: nameEnumInput.value,
                nameHK: nameHKEnumInput.value,
                category: categoryEnumInput.value,
                _token: btnSave.dataset.csrf,
            });

            method = "post";
            break;

        case "edit-data":
            url = `${baseUrl}/master/enumerations/${oldSlugEnumInput.value}`;

            data = JSON.stringify({
                code: codeEnumInput.value,
                name: nameEnumInput.value,
                nameHK: nameHKEnumInput.value,
                category: categoryEnumInput.value,
                _token: btnSave.dataset.csrf,
            });

            method = "put";
            break;
    }

    blockModal();

    const results = await enumeration.onSave(url, data, method);

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

        modalEnum.hide();
        enumeration.onLoad();
    } else {
        if (results.data.message.code || results.data.message.slug) {
            codeEnumInput.classList.add("is-invalid");
            codeEnumFeedback.innerHTML = results.data.message.slug ?
                results.data.message.slug :
                results.data.message.code;
        } else {
            codeEnumInput.classList.remove("is-invalid");
        }

        if (results.data.message.name) {
            nameEnumInput.classList.add("is-invalid");
            nameEnumFeedback.innerHTML = results.data.message.name;
        } else {
            nameEnumInput.classList.remove("is-invalid");
        }

        if (results.data.message.nameHK) {
            nameHKEnumInput.classList.add("is-invalid");
            nameHKEnumFeedback.innerHTML = results.data.message.nameHK;
        } else {
            nameHKEnumInput.classList.remove("is-invalid");
        }

        if (results.data.message.category) {
            categoryEnumInput.classList.add("is-invalid");
            categoryEnumFeedback.innerHTML = results.data.message.category;
        } else {
            categoryEnumInput.classList.remove("is-invalid");
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