document.querySelector("#sidebar").classList.remove("active");

const formData = document.querySelector("#form-data-edit");

const codeMaidInput = document.querySelector("#codeMaid");
const countryRequestInput = document.querySelector("#countryRequest");
const dateTrainingMaidInput = document.querySelector("#dateTrainingMaid");
const dobMaidInput = document.querySelector("#dobMaid");
const photoMaidFile = document.querySelector("#photoMaid");
const photoMaidPreview = document.querySelector("#photoMaidPreview");

const idWorkMaidInput = document.querySelector("#idWorkMaid");
const locationWorkInput = document.querySelector("#locationWork");
const overseasWorkInput = document.querySelector("#overseasWork");
const descriptionWorkInput = document.querySelector("#descriptionWork");

let url, data, method;

const fnFormMaid = {
    init: {
        buttons: {
            btnAddWork: document.querySelector("#btn-add-work"),
            btnSaveWork: document.querySelector("#btn-save-work"),
            btnSaveMaid: document.querySelector("#btn-save"),
            btnCalendarTraining: document.querySelector(
                "#btn-calendar-training"
            ),
            btnCalendarDob: document.querySelector("#btn-calendar-dob"),
        },
        datePicker: {
            dateTraining: new Datepicker(dateTrainingMaidInput, {
                format: "dd-mm-yyyy",
                buttonClass: "btn",
                todayBtn: true,
                autohide: true,
                prevArrow: '<i class="fas fa-arrow-left"></i>',
                nextArrow: '<i class="fas fa-arrow-right"></i>',
            }),
            dob: new Datepicker(dobMaidInput, {
                format: "dd-mm-yyyy",
                buttonClass: "btn",
                todayBtn: true,
                autohide: true,
                prevArrow: '<i class="fas fa-arrow-left"></i>',
                nextArrow: '<i class="fas fa-arrow-right"></i>',
            }),
        },
        dropdowns: {
            educationMaidChoices: new Choices(
                document.querySelector("#educationMaid"), {
                    shouldSort: false,
                }
            ),
            religionMaidChoices: new Choices(
                document.querySelector("#religionMaid"), {
                    shouldSort: false,
                }
            ),
            maritalMaidChoices: new Choices(
                document.querySelector("#maritalMaid"), {
                    shouldSort: false,
                }
            ),
            startWorkChoices: new Choices(
                document.querySelector("#startWork"), {
                    shouldSort: false,
                }
            ),
            endWorkChoices: new Choices(document.querySelector("#endWork"), {
                shouldSort: false,
            }),
        },
        modals: {
            workExperienceModal: new bootstrap.Modal(
                document.querySelector("#modal-work-experience")
            ),
        },
        notification: {
            confirmProcess: {
                title: "Generate Code",
                text: "Are you sure to generate Code with this Prefix ?",
                showCancelButton: true,
                confirmButtonText: "Yes, I'm Sure",
                cancelButtonText: "No",
                reverseButtons: true,
            },
        },
        tables: {
            tbWorkExperience: $("#tb-work-experience").DataTable({
                ajax: `${baseUrl}/master/maids/get-work-experience?country=${countryRequestInput.value}&maid=${codeMaidInput.value}`,
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

    onInit: async() => {
        await fetch(
                `${baseUrl}/master/maids/get-data-maid/${codeMaidInput.value}`
            )
            .then((response) => {
                if (!response.ok) {
                    unBlockModal();
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
                await fnFormMaid.onCreateDropdown(
                    [{
                            label: "Single",
                            value: 1,
                        },
                        {
                            label: "Married",
                            value: 2,
                        },
                        {
                            label: "Widowed",
                            value: 3,
                        },
                        {
                            label: "Divorced",
                            value: 4,
                        },
                    ],
                    fnFormMaid.init.dropdowns.maritalMaidChoices,
                    "Marital Status",
                    parseInt(response.marital)
                );

                await fnFormMaid.onCreateDropdown(
                    [{
                            label: "Moeslim",
                            value: 1,
                        },
                        {
                            label: "Catholic",
                            value: 2,
                        },
                        {
                            label: "Christian Protestant",
                            value: 3,
                        },
                        {
                            label: "Buddha",
                            value: 4,
                        },
                        {
                            label: "Hindu",
                            value: 5,
                        },
                        {
                            label: "Confucianism",
                            value: 6,
                        },
                    ],
                    fnFormMaid.init.dropdowns.religionMaidChoices,
                    "Religion",
                    parseInt(response.religion)
                );

                await fnFormMaid.onCreateDropdown(
                    [{
                            label: "Kindergarten",
                            value: 1,
                        },
                        {
                            label: "Primary School",
                            value: 2,
                        },
                        {
                            label: "Junior High School",
                            value: 3,
                        },
                        {
                            label: "Senior High School",
                            value: 4,
                        },
                        {
                            label: "Bachelor",
                            value: 5,
                        },
                        {
                            label: "Master",
                            value: 6,
                        },
                        {
                            label: "Doctor",
                            value: 7,
                        },
                    ],
                    fnFormMaid.init.dropdowns.educationMaidChoices,
                    "Education Background",
                    parseInt(response.education)
                );
            });
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

    onSaveForm: async(url, data, method) => {
        return await fetch(url, {
                method: method,
                body: data,
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
    onEditWork: async(id) => {
        await fetch(`${baseUrl}/master/maids/get-work-experience/${id}/edit`)
            .then((response) => {
                if (!response.ok) {
                    unBlockModal();
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
                fnFormMaid.init.modals.workExperienceModal.show();

                idWorkMaidInput.value = response.id;
                locationWorkInput.value = response.country;
                descriptionWorkInput.value = response.description;
                overseasWorkInput.checked =
                    response.work_overseas == 1 ? true : false;

                fnFormMaid.onCreateDropdown(
                    `${baseUrl}/dropdown/get-year`,
                    fnFormMaid.init.dropdowns.startWorkChoices,
                    "From",
                    parseInt(response.year_start)
                );

                fnFormMaid.onCreateDropdown(
                    `${baseUrl}/dropdown/get-year`,
                    fnFormMaid.init.dropdowns.endWorkChoices,
                    "To",
                    parseInt(response.year_end)
                );

                fnFormMaid.init.buttons.btnSaveWork.setAttribute(
                    "data-type",
                    "edit-data"
                );
            });
    },
    onDeleteWork: async(id, csrf) => {
        await swalWithBootstrapButtons
            .fire({
                icon: "info",
                title: "Delete Work",
                text: "Are you sure to delete this data ?",
                showCancelButton: true,
                confirmButtonColor: "#435ebe",
                confirmButtonText: "Yes, I'm sure",
                cancelButtonColor: "#dc3545",
                cancelButtonText: "No, cancel it",
            })
            .then(async(result) => {
                if (result.value) {
                    await fnFormMaid
                        .onSave(
                            `${baseUrl}/master/maids/get-work-experience/${id}`,
                            JSON.stringify({ _token: csrf }),
                            "delete"
                        )
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
                        .then(async(response) => {
                            if (response.data.status) {
                                Toastify({
                                    text: results.data.message,
                                    duration: 3000,
                                    close: true,
                                    gravity: "top",
                                    position: "right",
                                    backgroundColor: "#198754",
                                }).showToast();

                                await fnFormMaid.init.tables.tbWorkExperience.ajax
                                    .url(
                                        `${baseUrl}/master/maids/get-work-experience?country=${countryRequestInput.value}&maid=${codeMaidInput.value}`
                                    )
                                    .load();
                            } else {
                                Swal.fire("", response.data.message, "error");
                            }
                        });
                }
            });
    },
};

fnFormMaid.onInit();

fnFormMaid.init.buttons.btnCalendarDob.addEventListener("click", () => {
    fnFormMaid.init.datePicker.dob.show();
});

fnFormMaid.init.buttons.btnCalendarTraining.addEventListener("click", () => {
    fnFormMaid.init.datePicker.dateTraining.show();
});

photoMaidFile.addEventListener("change", async(event) => {
    if (event.target.files.length > 0) {
        var src = URL.createObjectURL(event.target.files[0]);
        photoMaidPreview.src = src;
    }
});

fnFormMaid.init.buttons.btnAddWork.addEventListener("click", () => {
    fnFormMaid.init.modals.workExperienceModal.show();

    idWorkMaidInput.value = "";
    locationWorkInput.value = "";
    descriptionWorkInput.value = "";
    overseasWorkInput.checked = false;

    fnFormMaid.onCreateDropdown(
        `${baseUrl}/dropdown/get-year`,
        fnFormMaid.init.dropdowns.startWorkChoices,
        "From",
        parseInt(moment().format("YYYY"))
    );

    fnFormMaid.onCreateDropdown(
        `${baseUrl}/dropdown/get-year`,
        fnFormMaid.init.dropdowns.endWorkChoices,
        "To",
        parseInt(moment().format("YYYY"))
    );

    fnFormMaid.init.buttons.btnSaveWork.setAttribute("data-type", "add-data");
});

codeMaidInput.addEventListener("keypress", async(e) => {
    if (e.keyCode === 13) {
        await swalWithBootstrapButtons
            .fire(fnFormMaid.init.notification.confirmProcess)
            .then(async(result) => {
                if (result.value) {
                    await fetch(
                            `${baseUrl}/master/maids/generate-counter?country=${countryRequestInput.value}&maid=${codeMaidInput.value}`
                        )
                        .then((response) => {
                            if (!response.ok) {
                                unBlockModal();
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
                            if (response.data.status) {
                                codeMaidInput.value = response.data.codeMaid;
                                codeMaidInput.readonly = true;

                                window.history.pushState(
                                    "",
                                    "",
                                    `${baseUrl}/master/maids/register-maid?country=${countryRequestInput.value}&maid=${codeMaidInput.value}`
                                );

                                fnFormMaid.init.tables.tbWorkExperience.ajax
                                    .url(
                                        `${baseUrl}/master/maids/get-work-experience?maid=${codeMaidInput.value}`
                                    )
                                    .load();
                            }
                        });
                }
            });
    }
});

fnFormMaid.init.buttons.btnSaveWork.addEventListener("click", async() => {
    switch (fnFormMaid.init.buttons.btnSaveWork.dataset.type) {
        case "add-data":
            url = `${baseUrl}/master/maids/add-work-experience`;

            data = JSON.stringify({
                maid: codeMaidInput.value,
                country: countryRequestInput.value,
                start: fnFormMaid.init.dropdowns.startWorkChoices.getValue(
                    true
                ),
                end: fnFormMaid.init.dropdowns.endWorkChoices.getValue(true),
                location: locationWorkInput.value,
                overseas: overseasWorkInput.checked,
                description: descriptionWorkInput.value,
                _token: fnFormMaid.init.buttons.btnSaveWork.dataset.csrf,
            });

            method = "post";
            break;

        case "edit-data":
            url = `${baseUrl}/master/maids/add-work-experience/${idWorkMaidInput.value}`;

            data = JSON.stringify({
                maid: codeMaidInput.value,
                country: countryRequestInput.value,
                start: fnFormMaid.init.dropdowns.startWorkChoices.getValue(
                    true
                ),
                end: fnFormMaid.init.dropdowns.endWorkChoices.getValue(true),
                location: locationWorkInput.value,
                overseas: overseasWorkInput.checked,
                description: descriptionWorkInput.value,
                _token: fnFormMaid.init.buttons.btnSaveWork.dataset.csrf,
            });

            method = "put";
            break;
    }

    blockUI();

    const results = await fnFormMaid.onSave(url, data, method);

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

        fnFormMaid.init.modals.workExperienceModal.hide();

        fnFormMaid.init.tables.tbWorkExperience.ajax
            .url(
                `${baseUrl}/master/maids/get-work-experience?country=${countryRequestInput.value}&maid=${codeMaidInput.value}`
            )
            .load();
    } else {
        Swal.fire("", results.data.message, "error");
    }
});

fnFormMaid.init.buttons.btnSaveMaid.addEventListener("click", async() => {
    url = `${baseUrl}/master/maids/${codeMaidInput.value}`;

    blockUI();

    const results = await fnFormMaid.onSaveForm(
        `${baseUrl}/master/maids`,
        new FormData(formData),
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

        window.history.pushState(
            "",
            "",
            `${baseUrl}/master/maids/${codeMaidInput.value}/edit?country=${countryRequestInput.value}`
        );

        history.go(0);
    } else {
        Swal.fire("", results.data.message, "error");
    }
});