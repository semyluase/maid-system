const modalCountry = new bootstrap.Modal(
    document.querySelector("#modalCountry")
);
const idCountryInput = document.querySelector("#idCountry");
const oldSlugCountryInput = document.querySelector("#oldSlugCountry");
const codeCountryInput = document.querySelector("#codeCountry");
const codeCountryFeedback = document.querySelector("#codeCountryFeedback");
const nameCountryInput = document.querySelector("#nameCountry");
const nameCountryFeedback = document.querySelector("#nameCountryFeedback");

const btnAdd = document.querySelector("#btn-add");
const btnSubmit = document.querySelector("#btn-submit");

let url, data, method, tbCountry;

const fnCountry = {
    onInit: () => {
        blockUI();
        tbCountry = $("#tb-country").DataTable({
            ajax: `${baseUrl}/master/countries/get-all-data`,
            serverSide: true,
            columnDefs: [{ orderable: false, targets: [3, 4, 5] }],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"],
            ],
            processing: true,
        });

        unBlockUI();
    },

    onLoad: async() => {
        tbCountry.ajax.url(`${baseUrl}/master/countries/get-all-data`).draw();
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
        modalCountry.show();

        codeCountryInput.classList.remove("is-invalid");
        nameCountryInput.classList.remove("is-invalid");
        idCountryInput.value = "";
        oldSlugCountryInput.value = "";
        codeCountryInput.value = "";
        nameCountryInput.value = "";

        btnSubmit.setAttribute("data-type", "add-data");
    },

    onEdit: async(slug) => {
        blockUI();
        await fetch(`${baseUrl}/master/countries/${slug}/edit`)
            .then((response) => {
                if (!response.ok) {
                    unBlockUI();
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
                modalCountry.show();

                codeCountryInput.classList.remove("is-invalid");
                nameCountryInput.classList.remove("is-invalid");
                idCountryInput.value = response.id;
                oldSlugCountryInput.value = response.slug;
                codeCountryInput.value = response.code;
                nameCountryInput.value = response.name;

                btnSubmit.setAttribute("data-type", "edit-data");
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

                    const results = await fnCountry.onSave(
                        `${baseUrl}/master/countries/${slug}`,
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

                        fnCountry.onLoad();
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

    onShow: (code) => {
        window.open(`${baseUrl}/master/maids?country=${code}`);
    },
};

fnCountry.onInit();

btnAdd.addEventListener("click", () => {
    blockUI();

    fnCountry.onAdd();

    unBlockUI();
});

btnSubmit.addEventListener("click", async() => {
    switch (btnSubmit.dataset.type) {
        case "add-data":
            url = `${baseUrl}/master/countries`;

            data = JSON.stringify({
                code: codeCountryInput.value,
                name: nameCountryInput.value,
                _token: btnSubmit.dataset.csrf,
            });

            method = "post";
            break;

        case "edit-data":
            url = `${baseUrl}/master/countries/${oldSlugCountryInput.value}`;

            data = JSON.stringify({
                code: codeCountryInput.value,
                name: nameCountryInput.value,
                _token: btnSubmit.dataset.csrf,
            });

            method = "put";
            break;
    }

    blockModal();

    const results = await fnCountry.onSave(url, data, method);

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

        modalCountry.hide();
        fnCountry.onLoad();
    } else {
        if (results.data.message.name || results.data.message.slug) {
            nameCountryInput.classList.add("is-invalid");
            nameCountryFeedback.innerHTML = results.data.message.slug ?
                results.data.message.slug :
                results.data.message.name;
        } else {
            nameCountryInput.classList.remove("is-invalid");
        }

        if (results.data.message.code) {
            codeCountryInput.classList.add("is-invalid");
            codeCountryFeedback.innerHTML = results.data.message.code;
        } else {
            codeCountryInput.classList.remove("is-invalid");
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