const codeMaidInput = document.querySelector("#code-maid");
const workIDInput = document.querySelector("#work-id");
const workLocationInput = document.querySelector("#work-location");
const workStartMonthInput = document.querySelector("#work-start-month");
const workEndMonthInput = document.querySelector("#work-end-month");
const workStartMonthChoices = new Choices(workStartMonthInput, {
    shouldSort: false,
});
const workEndMonthChoices = new Choices(workEndMonthInput, {
    shouldSort: false,
});
const workStartYearInput = document.querySelector("#work-start-year");
const workEndYearInput = document.querySelector("#work-end-year");
const workStartYearChoices = new Choices(workStartYearInput, {
    shouldSort: false,
});
const workEndYearChoices = new Choices(workEndYearInput, {
    shouldSort: false,
});
const workPresentCheck = document.querySelector("#work-present");
const workDescriptionInput = document.querySelector("#work-description");
const overseasCheck = document.querySelector("#work-overseas");
const singaporeCheck = document.querySelector("#work-singpore");
const workEmployeerInput = document.querySelector("#work-employeer");
const employeerFeedbackInput = document.querySelector("#work-feedback");

const fnWorkExperience = {
    init: {
        buttons: {
            btnAddWork: document.querySelector("#btn-add-work"),
            btnSaveWork: document.querySelector("#btn-save-work"),
        },
        modals: {
            modalWork: new bootstrap.Modal(
                document.querySelector("#modal-work")
            ),
        },
        tables: {
            tbWorkExperience: $("#tb-work-experience").DataTable({
                ajax: `${baseUrl}/master/maids/work-experiences/get-all-data?maid=${codeMaidInput.value}`,
            }),
        },
    },

    onCreateDropdown: async (url, choices, placeholder, selected) => {
        choices.clearStore();

        choices.setChoices([
            {
                label: placeholder,
                value: "",
                disabled: true,
            },
        ]);

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
            .then((response) => response);
    },

    onLoadTable: async (type, params) => {
        switch (type) {
            case "work":
                await fnWorkExperience.init.tables.tbWorkExperience.ajax
                    .url(
                        `${baseUrl}/master/maids/work-experiences/get-all-data?maid=${codeMaidInput.value}`
                    )
                    .load();
                break;
        }
    },

    onEdit: async (id) => {
        await fetch(`${baseUrl}/master/maids/work-experiences/${id}/edit`)
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
            .then(async (response) => {
                await fnWorkExperience.init.modals.modalWork.show();

                workIDInput.value = response.id;
                codeMaidInput.value = response.maid.code_maid;
                workLocationInput.value = response.location;
                workDescriptionInput.value = response.description;
                workPresentCheck.checked = response.is_present ? true : false;
                overseasCheck.checked = response.is_overseas ? true : false;
                singaporeCheck.checked = response.is_singapore ? true : false;
                employeerFeedbackInput.value = response.employer_feedback;
                workEmployeerInput.value = response.employer_name;

                let start = response.from.split(" ");
                console.log(start);
                let end = response.end.split(" ");
                await fnWorkExperience.onCreateDropdown(
                    `${baseUrl}/dropdown/get-month`,
                    workStartMonthChoices,
                    "Select Month",
                    start[0]
                );

                await fnWorkExperience.onCreateDropdown(
                    `${baseUrl}/dropdown/get-year`,
                    workStartYearChoices,
                    "Select Year",
                    parseInt(start[1])
                );

                await fnWorkExperience.onCreateDropdown(
                    `${baseUrl}/dropdown/get-month`,
                    workEndMonthChoices,
                    "Select Month",
                    end[0]
                );

                await fnWorkExperience.onCreateDropdown(
                    `${baseUrl}/dropdown/get-year`,
                    workEndYearChoices,
                    "Select Year",
                    parseInt(end[1])
                );

                fnWorkExperience.init.buttons.btnSaveWork.setAttribute(
                    "data-type",
                    "edit-data"
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

                    const results = await fnWorkExperience.onSave(
                        `${baseUrl}/master/maids/work-experiences/${id}`,
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

                        await fnWorkExperience.onLoadTable("work");
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

fnWorkExperience.init.buttons.btnAddWork.addEventListener("click", async () => {
    await fnWorkExperience.init.modals.modalWork.show();

    workIDInput.value = "";
    workLocationInput.value = "";
    workPresentCheck.checked = false;
    overseasCheck.checked = false;
    singaporeCheck.checked = false;
    workDescriptionInput.value = "";
    workEmployeerInput.value = "";
    employeerFeedbackInput.value = "";

    await fnWorkExperience.onCreateDropdown(
        `${baseUrl}/dropdown/get-month`,
        workStartMonthChoices,
        "Select Month",
        ""
    );

    await fnWorkExperience.onCreateDropdown(
        `${baseUrl}/dropdown/get-year`,
        workStartYearChoices,
        "Select Year",
        ""
    );

    await fnWorkExperience.onCreateDropdown(
        `${baseUrl}/dropdown/get-month`,
        workEndMonthChoices,
        "Select Month",
        ""
    );

    await fnWorkExperience.onCreateDropdown(
        `${baseUrl}/dropdown/get-year`,
        workEndYearChoices,
        "Select Year",
        ""
    );

    fnWorkExperience.init.buttons.btnSaveWork.setAttribute(
        "data-type",
        "add-data"
    );
});

fnWorkExperience.init.buttons.btnSaveWork.addEventListener(
    "click",
    async () => {
        switch (fnWorkExperience.init.buttons.btnSaveWork.dataset.type) {
            case "add-data":
                url = `${baseUrl}/master/maids/work-experiences`;

                data = JSON.stringify({
                    maid: codeMaidInput.value,
                    location: workLocationInput.value,
                    start:
                        workStartMonthChoices.getValue(true) +
                        " " +
                        workStartYearChoices.getValue(true),
                    end:
                        workEndMonthChoices.getValue(true) +
                        " " +
                        workEndYearChoices.getValue(true),
                    description: workDescriptionInput.value,
                    present: workPresentCheck.checked,
                    overseas: overseasCheck.checked,
                    singapore: singaporeCheck.checked,
                    employeer: workEmployeerInput.value,
                    feedback: employeerFeedbackInput.value,
                    _token: fnWorkExperience.init.buttons.btnSaveWork.dataset
                        .csrf,
                });

                method = "post";
                break;

            case "edit-data":
                url = `${baseUrl}/master/maids/work-experiences/${workIDInput.value}`;

                data = JSON.stringify({
                    maid: codeMaidInput.value,
                    location: workLocationInput.value,
                    start:
                        workStartMonthChoices.getValue(true) +
                        " " +
                        workStartYearChoices.getValue(true),
                    end:
                        workEndMonthChoices.getValue(true) +
                        " " +
                        workEndYearChoices.getValue(true),
                    description: workDescriptionInput.value,
                    present: workPresentCheck.checked,
                    overseas: overseasCheck.checked,
                    singapore: singaporeCheck.checked,
                    employeer: workEmployeerInput.value,
                    feedback: employeerFeedbackInput.value,
                    _token: fnWorkExperience.init.buttons.btnSaveWork.dataset
                        .csrf,
                });

                method = "put";
                break;
        }

        blockUI();

        const results = await fnWorkExperience.onSave(url, data, method);

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

            await fnWorkExperience.init.modals.modalWork.hide();
            await fnWorkExperience.onLoadTable("work");
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
