const modalAnnouncement = new bootstrap.Modal(
    document.querySelector("#modalAnnouncement")
);
const idAnnouncementInput = document.querySelector("#idAnnouncement");
const oldSlugAnnouncementInput = document.querySelector("#oldSlugAnnouncement");
const titleAnnouncementInput = document.querySelector("#titleAnnouncement");
const titleAnnouncementFeedback = document.querySelector(
    "#titleAnnouncementFeedback"
);
let editorData;
const bodyAnnouncementInput = ClassicEditor.create(
        document.querySelector("#bodyAnnouncement")
    )
    .then((editor) => {
        editor.model.document.on("change:data", () => {
            editorData = editor.getData();
        });
    })
    .then((editor) => {
        editor.setData(editorData);
    })
    .catch((e) => {
        console.error(e);
    });
const bodyAnnouncementFeedback = document.querySelector(
    "#bodyAnnouncementFeedback"
);
const startDateInput = document.querySelector("#startDate");
const endDateInput = document.querySelector("#endDate");
const rangeDateAnnouncementInput = document.querySelector(
    "#rangeDateAnnouncement"
);
const rangeDateAnnouncementFeedback = document.querySelector(
    "#rangeDateAnnouncementFeedback"
);
new DateRangePicker(rangeDateAnnouncementInput, {
    buttonClass: "btn",
    format: "dd-mm-yyyy",
});
const btnAdd = document.querySelector("#btn-add");
const btnSave = document.querySelector("#btn-save");

const tableCard = document.querySelector("#table-card");
const createCard = document.querySelector("#create-card");

let url, data, method, tbAnnouncement;

const fnAnnouncement = {
    onInit: async() => {
        blockUI();

        tbAnnouncement = $("#tb-announcement").DataTable({
            ajax: `${baseUrl}/master/announcements/get-all-data`,
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
        tbAnnouncement.ajax
            .url(`${baseUrl}/master/announcements/get-all-data`)
            .draw();
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

    onAdd: async() => {
        modalAnnouncement.show();
        titleAnnouncementInput.classList.remove("is-invalid");
        rangeDateAnnouncementInput.classList.remove("is-invalid");

        idAnnouncementInput.value = "";
        oldSlugAnnouncementInput.value = "";
        titleAnnouncementInput.value = "";
        bodyAnnouncementInput.value = "";

        startDateInput.value = moment().format("DD-MM-YYYY");
        endDateInput.value = moment().format("DD-MM-YYYY");

        btnSave.setAttribute("data-type", "add-data");
    },

    onEdit: async(slug) => {
        blockUI();

        await fetch(`${baseUrl}/master/announcements/${slug}/edit`)
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
            .then((response) => {
                modalAnnouncement.show();
                titleAnnouncementInput.classList.remove("is-invalid");
                rangeDateAnnouncementInput.classList.remove("is-invalid");

                idAnnouncementInput.value = response.id;
                oldSlugAnnouncementInput.value = response.slug;
                titleAnnouncementInput.value = response.title;
                editorData = response.body;
                // bodyAnnouncementInput.value = response.body;

                startDateInput.value = moment(
                    response.date_start,
                    "YYYY-MM-DD"
                ).format("DD-MM-YYYY");
                endDateInput.value = moment(
                    response.date_end,
                    "YYYY-MM-DD"
                ).format("DD-MM-YYYY");

                btnSave.setAttribute("data-type", "edit-data");
            });
        unBlockUI();
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

                    const results = await country.onSave(
                        `${baseUrl}/master/announcements/${slug}`,
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

btnAdd.addEventListener("click", async() => {
    fnAnnouncement.onAdd();
});

btnSave.addEventListener("click", async() => {
    switch (btnSave.dataset.type) {
        case "add-data":
            url = `${baseUrl}/master/announcements`;

            data = JSON.stringify({
                title: titleAnnouncementInput.value,
                body: editorData,
                dateStart: moment(startDateInput.value, "DD-MM-YYYY").format(
                    "YYYY-MM-DD"
                ),
                dateEnd: moment(endDateInput.value, "DD-MM-YYYY").format(
                    "YYYY-MM-DD"
                ),
                _token: btnSave.dataset.csrf,
            });

            method = "post";
            break;

        case "edit-data":
            url = `${baseUrl}/master/announcements/${oldSlugCountryInput.value}`;

            data = JSON.stringify({
                title: titleAnnouncementInput.value,
                body: editorData,
                dateStart: moment(startDateInput.value, "DD-MM-YYYY").format(
                    "YYYY-MM-DD"
                ),
                dateEnd: moment(endDateInput.value, "DD-MM-YYYY").format(
                    "YYYY-MM-DD"
                ),
                _token: btnSave.dataset.csrf,
            });

            method = "put";
            break;
    }

    blockModal();

    const results = await fnAnnouncement.onSave(url, data, method);

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

        modalAnnouncement.hide();
        fnAnnouncement.onLoad();
    } else {
        if (results.data.message.title) {
            titleAnnouncementInput.classList.add("is-invalid");
            titleAnnouncementFeedback.innerHTML = results.data.message.title;
        } else {
            titleAnnouncementInput.classList.remove("is-invalid");
        }

        if (results.data.message.body) {
            bodyAnnouncementInput.classList.add("is-invalid");
            bodyAnnouncementFeedback.innerHTML = results.data.message.body;
        } else {
            bodyAnnouncementInput.classList.remove("is-invalid");
        }

        if (typeof results.data.message == "string") {
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