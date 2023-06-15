const bodyInput = document.querySelector("#body");
const nameInput = document.querySelector("#name");
const idInput = document.querySelector("#id-contact");
const branchInput = document.querySelector("#branch");
const whatsappInput = document.querySelector("#whatsapp");
const codeInput = document.querySelector("#code");

let url, data, method;

const fnAnnouncement = {
    init: {
        modals: {
            contactPersons: new bootstrap.Modal(
                document.querySelector("#modal-contact-person")
            ),
            contactPersonsSort: new bootstrap.Modal(
                document.querySelector("#modal-sort-contact-person")
            ),
        },
        buttons: {
            btnSaveAnnoucement: document.querySelector(
                "#btn-save-announcement"
            ),
            btnAddContact: document.querySelector("#btn-add-contact-person"),
            btnSaveContact: document.querySelector("#btn-save"),
            btnSaveSortContact: document.querySelector("#btn-save-sort"),
            btnSortContact: document.querySelector("#btn-sort-contact-person"),
        },
        tables: {
            tbContactPerson: $("#tb-contact-person").DataTable({
                ajax: `${baseUrl}/master/announcements/get-all-data`,
                serverSide: true,
                paging: false,
                orderable: [
                    {
                        targets: [0, 1, 2, 3, 4, 5],
                        orderable: false,
                    },
                ],
            }),
        },
    },

    onInit: async () => {
        blockUI();

        new Quill(bodyInput, {
            bounds: "#full-container .editor",
            modules: {
                toolbar: [
                    [{ font: [] }, { size: [] }],
                    ["bold", "italic", "underline", "strike"],
                    [{ color: [] }, { background: [] }],
                    [{ script: "super" }, { script: "sub" }],
                    [
                        { list: "ordered" },
                        { list: "bullet" },
                        { indent: "-1" },
                        { indent: "+1" },
                    ],
                    ["direction", { align: [] }],
                    ["link", "image", "video"],
                    ["clean"],
                ],
            },
            theme: "snow",
        });

        unBlockUI();
    },

    onLoad: async () => {
        fnAnnouncement.init.tables.tbContactPerson.ajax
            .url(`${baseUrl}/master/announcements/get-all-data`)
            .draw();
    },

    onSave: async (url, data, method) => {
        return await fetch(url, {
            method: method,
            body: data,
            headers: {
                "Content-Type": "application/json",
            },
        })
            .then((response) => {
                if (!response.ok) {
                    method == "delete" ? unBlockUI() : unBlockModal();
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

    onEdit: async (id) => {
        await fetch(`${baseUrl}/master/announcements/${id}/edit`)
            .then((response) => {
                if (!response.ok) {
                    unBlockUI();
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
            .then(async (response) => {
                await fnAnnouncement.init.modals.contactPersons.show();

                idInput.value = response.id;
                nameInput.value = response.name;
                branchInput.value = response.branch;
                whatsappInput.value = response.whatsapp;
                codeInput.value = response.code;

                fnAnnouncement.init.buttons.btnSaveContact.setAttribute(
                    "data-type",
                    "edit-contact"
                );
            });
    },

    onDelete: async (id, csrf) => {
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
            .then(async (result) => {
                if (result.value) {
                    blockUI();

                    data = JSON.stringify({
                        _token: csrf,
                    });

                    const results = await fnAnnouncement.onSave(
                        `${baseUrl}/master/announcements/${id}`,
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

                        fnAnnouncement.onLoad();
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

fnAnnouncement.onInit();

fnAnnouncement.init.buttons.btnAddContact.addEventListener("click", () => {
    fnAnnouncement.init.modals.contactPersons.show();

    idInput.value = "";
    nameInput.value = "";
    branchInput.value = "";
    whatsappInput.value = "";
    codeInput.value = "";

    fnAnnouncement.init.buttons.btnSaveContact.setAttribute(
        "data-type",
        "add-new-contact"
    );
});

fnAnnouncement.init.buttons.btnSaveAnnoucement.addEventListener(
    "click",
    async () => {
        bodyInput.removeChild(document.querySelector(".ql-clipboard"));
        bodyInput.removeChild(document.querySelector(".ql-tooltip"));
        blockUI();

        const results = await fnAnnouncement.onSave(
            `${baseUrl}/master/announcements`,
            JSON.stringify({
                body: bodyInput.innerHTML,
                type: "announcement",
                _token: fnAnnouncement.init.buttons.btnSaveAnnoucement.dataset
                    .csrf,
            }),
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
                backgroundColor: "#198754",
            }).showToast();

            window.location = `${baseUrl}/master/announcements`;
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
);

fnAnnouncement.init.buttons.btnSaveContact.addEventListener(
    "click",
    async () => {
        switch (fnAnnouncement.init.buttons.btnSaveContact.dataset.type) {
            case "add-new-contact":
                console.log(true);
                url = `${baseUrl}/master/announcements`;

                data = JSON.stringify({
                    name: nameInput.value,
                    branch: branchInput.value,
                    whatsapp: whatsappInput.value,
                    code: codeInput.value,
                    type: "contact",
                    _token: fnAnnouncement.init.buttons.btnSaveContact.dataset
                        .csrf,
                });

                method = "post";
                break;

            case "edit-contact":
                url = `${baseUrl}/master/announcements/${idInput.value}`;

                data = JSON.stringify({
                    name: nameInput.value,
                    branch: branchInput.value,
                    whatsapp: whatsappInput.value,
                    code: codeInput.value,
                    type: "contact",
                    _token: fnAnnouncement.init.buttons.btnSaveContact.dataset
                        .csrf,
                });

                method = "put";
                break;
        }
        blockUI();

        const results = await fnAnnouncement.onSave(url, data, method);

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

            fnAnnouncement.init.modals.contactPersons.hide();
            fnAnnouncement.onLoad();
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
);

fnAnnouncement.init.buttons.btnSortContact.addEventListener(
    "click",
    async () => {
        blockUI();
        await fetch(`${baseUrl}/master/announcements/sorted-data`)
            .then((response) => {
                if (!response.ok) {
                    unBlockUI();
                    throw new Error(
                        Toastify({
                            text: "Something wrong while get data",
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
                unBlockUI();
                if (response.data != null) {
                    document.querySelector("#example1").innerHTML =
                        response.data;
                    fnAnnouncement.init.modals.contactPersonsSort.show();
                } else {
                    Toastify({
                        text: "Something wrong while get data",
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "#dc3545",
                    }).showToast();
                }
            });
    }
);

// $(".table-sortable tbody").on("click", function () {
//     console.log(
//         $(this).sortable({
//             handle: "tr",
//         })
//     );
// });

// document.querySelector("#tb-sort tbody").addEventListener("click", () => {});
new Sortable(document.querySelector("#example1"), {
    animation: 150,
    ghostClass: "blue-background-class",
});

fnAnnouncement.init.buttons.btnSaveSortContact.addEventListener(
    "click",
    async () => {
        let sortIndex = document.querySelectorAll("#index-sort");

        let arrIndex = [];
        sortIndex.forEach((item) => {
            arrIndex.push(item.dataset.id);
        });

        blockUI();

        const results = await fnAnnouncement.onSave(
            `${baseUrl}/master/announcements/sort-contact`,
            JSON.stringify({
                arrIndex: arrIndex,
                _token: fnAnnouncement.init.buttons.btnSaveSortContact.dataset
                    .csrf,
            }),
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
                backgroundColor: "#198754",
            }).showToast();

            fnAnnouncement.init.modals.contactPersonsSort.hide();
            fnAnnouncement.onLoad();
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
);
