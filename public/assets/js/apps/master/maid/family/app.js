const maidCodeInput = document.querySelector("#maid-code");
const idFamilyInput = document.querySelector("#family-id");
const nameFamilyInput = document.querySelector("#family-name");
const dobFamilyInput = document.querySelector("#family-dob");
const passedAwayFamilyCheck = document.querySelector("#family-passed-away");
const relationFamilyInput = document.querySelector("#family-relation");
const relationFamilyChoices = new Choices(relationFamilyInput);

const fnFamily = {
    init: {
        modal: {
            modalFamily: new bootstrap.Modal(
                document.querySelector("#modal-families")
            ),
        },
        datePicker: {
            dobFamilyInput: new Datepicker(dobFamilyInput, {
                buttonClass: "btn",
                format: "dd-mm-yyyy",
            }),
        },
        buttons: {
            btnSave: document.querySelector("#btn-save-families"),
            btnAdd: document.querySelector("#btn-add-family"),
        },
        table: {
            tbFamily: $("#tb-families").DataTable({
                ajax: `${baseUrl}/master/maids/families/get-all-data?maid=${maidCodeInput.value}`,
                length: [-1],
            }),
        },
    },

    onCreateDropdown: async(url, choices, placeholder, selected) => {
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
                                text: "Something wrong while getting the data",
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
            .then((response) => response);
    },

    onEdit: async(id) => {
        await fetch(`${baseUrl}/master/maids/families/${id}/edit`)
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
            .then(async(response) => {
                await fnFamily.init.modal.modalFamily.show();

                idFamilyInput.value = response.id;
                codeFamilyInput.value = response.maid.code_maid;
                nameFamilyInput.value = response.name;
                dobFamilyInput.value = moment(
                    response.date_of_birth,
                    "YYYY-MM-DD"
                ).format("DD-MM-YYYY");
                passedAwayFamilyCheck.checked = response.is_passed_away ?
                    true :
                    false;

                await fnFamily.onCreateDropdown(
                    [{
                            label: "Father",
                            value: 1,
                        },
                        {
                            label: "Mother",
                            value: 2,
                        },
                        {
                            label: "Spouse",
                            value: 3,
                        },
                        {
                            label: "Brother",
                            value: 4,
                        },
                        {
                            label: "Sister",
                            value: 5,
                        },
                        {
                            label: "Child",
                            value: 6,
                        },
                    ],
                    relationFamilyChoices,
                    "Choose Relation",
                    parseInt(response.relation_id)
                );

                await fnFamily.init.buttons.btnSave.setAttribute(
                    "data-type",
                    "edit-data"
                );
            });
    },

    onDelete: async(id, csrf) => {
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

                    const results = await fnFamily.onSave(
                        `${baseUrl}/master/maids/families/${id}`,
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

                        history.go(0);
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

fnFamily.init.buttons.btnAdd.addEventListener("click", async() => {
    await fnFamily.init.modal.modalFamily.show();

    idFamilyInput.value = "";
    nameFamilyInput.value = "";
    dobFamilyInput.value = "";

    await fnFamily.onCreateDropdown(
        [{
                label: "Father",
                value: 1,
            },
            {
                label: "Mother",
                value: 2,
            },
            {
                label: "Spouse",
                value: 3,
            },
            {
                label: "Brother",
                value: 4,
            },
            {
                label: "Sister",
                value: 5,
            },
            {
                label: "Child",
                value: 6,
            },
        ],
        relationFamilyChoices,
        "Choose Relation",
        ""
    );

    await fnFamily.init.buttons.btnSave.setAttribute("data-type", "add-data");
});

fnFamily.init.buttons.btnSave.addEventListener("click", async() => {
    switch (fnFamily.init.buttons.btnSave.dataset.type) {
        case "add-data":
            url = `${baseUrl}/master/maids/families`;

            data = JSON.stringify({
                name: nameFamilyInput.value,
                dob: moment(dobFamilyInput.value, "DD-MM-YYYY").format(
                    "YYYY-MM-DD"
                ),
                relation: relationFamilyChoices.getValue(true),
                passedAway: passedAwayFamilyCheck.checked ? true : false,
                maid: codeFamilyInput.value,
                _token: fnFamily.init.buttons.btnSave.dataset.csrf,
            });

            method = "post";
            break;

        case "edit-data":
            url = `${baseUrl}/master/maids/families/${idFamilyInput.value}`;

            data = JSON.stringify({
                name: nameFamilyInput.value,
                dob: moment(dobFamilyInput.value, "DD-MM-YYYY").format(
                    "YYYY-MM-DD"
                ),
                relation: relationFamilyChoices.getValue(true),
                passedAway: passedAwayFamilyCheck.checked ? true : false,
                _token: fnFamily.init.buttons.btnSave.dataset.csrf,
            });

            method = "put";
            break;
    }

    blockUI();

    const results = await fnFamily.onSave(url, data, method);

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

        await fnFamily.init.modal.modalFamily.hide();

        history.go(0);
    } else {
        if (results.data.message.relation) {
            Swal.fire("", results.data.message.relation[0], "error");
        }

        if (typeof results.data.message == "string") {
            Swal.fire("", results.data.message, "error");
        }
    }
});