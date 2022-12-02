document.querySelector("#sidebar").classList.remove("active");

const formDataMaid = document.querySelector("#formDataMaid");
const formSkillWilling = document.querySelector("#form-skill-willing");
const formMedical = document.querySelector("#form-medical");
const formOther = document.querySelector("#form-other");

const prefixInput = document.querySelector("#prefixMaid");
const firstNameInput = document.querySelector("#firstName");
const lastNameInput = document.querySelector("#lastName");
const sexMaleRadio = document.querySelector("#sex-male");
const sexFemaleRadio = document.querySelector("#sex-female");
const placeOfBirthInput = document.querySelector("#placeOfBirth");
const dateOfBirthInput = document.querySelector("#dateOfBirth");
const nationalityInput = document.querySelector("#nationalityMaid");
const heightMaidInput = document.querySelector("#heightMaid");
const weightMaidInput = document.querySelector("#weightMaid");
const maritalStatusInput = document.querySelector("#maritalStatus");
const maritalStatusChoices = new Choices(maritalStatusInput);
const bloodTypeInput = document.querySelector("#bloodType");
const bloodTypeChoices = new Choices(bloodTypeInput);
const educationMaidInput = document.querySelector("#educationMaid");
const educationMaidChoices = new Choices(educationMaidInput);
const religionMaidInput = document.querySelector("#religionMaid");
const religionMaidChoices = new Choices(religionMaidInput);
const addressMaidInput = document.querySelector("#addressMaid");
const contactMaidInput = document.querySelector("#contactMaid");
const portOrAirportInput = document.querySelector("#portOrAirport");
const numberInFamilyInput = document.querySelector("#numberInFamily");
const brotherMaidInput = document.querySelector("#brotherMaid");
const sisterMaidInput = document.querySelector("#sisterMaid");
const husbandWifePassedInput = document.querySelector("#isHusbandWifePassed");
const photoFileInput = document.querySelector("#photoFileMaid");
const photoMaidImg = document.querySelector("#photoMaid");

const btnSave = document.querySelector("#btn-save");
const btnCancel = document.querySelector("#btn-cancel");

let url, data, method;

const fnMaidForms = {
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
        blockUI();

        new Datepicker(dateOfBirthInput, {
            buttonClass: "btn",
            format: "dd-mm-yyyy",
        });

        await fnMaidForms.onCreateDropdown(
            [{
                    label: "A",
                    value: 1,
                },
                {
                    label: "B",
                    value: 2,
                },
                {
                    label: "AB",
                    value: 3,
                },
                {
                    label: "O",
                    value: 4,
                },
            ],
            bloodTypeChoices,
            "Choose Blood Type",
            ""
        );

        await fnMaidForms.onCreateDropdown(
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
            educationMaidChoices,
            "Choose Education",
            ""
        );

        await fnMaidForms.onCreateDropdown(
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
            religionMaidChoices,
            "Choose Religion",
            ""
        );

        await fnMaidForms.onCreateDropdown(
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
            maritalStatusChoices,
            "Choose Marital Status",
            ""
        );

        unBlockUI();
    },

    onSave: async(url, data, method) => {
        return await fetch(url, {
                method: method,
                body: data,
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
};

fnMaidForms.onInit();

prefixInput.addEventListener("blur", async() => {
    await fetch(
            `${baseUrl}/master/maids/generate-counter?prefix=${prefixInput.value}`
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
        .then((response) => {
            if (response.data.status) {
                prefixInput.value = response.data.codeMaid;
                prefixInput.setAttribute("readonly", true);

                window.history.pushState(
                    "",
                    "",
                    `${baseUrl}/master/maids/register-maid?maid=${prefixInput.value}`
                );
            } else {
                Toastify({
                    text: response.data.message,
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#dc3545",
                }).showToast();
            }
        });
});

photoFileInput.addEventListener("change", async(event) => {
    if (event.target.files.length > 0) {
        var src = URL.createObjectURL(event.target.files[0]);
        photoMaidImg.src = src;
    }
});

btnSave.addEventListener("click", async() => {
    blockUI();

    await fnMaidForms.onSave(
        `${baseUrl}/master/maids/skills?maid=${prefixInput.value}`,
        new FormData(formSkillWilling),
        "post"
    );
    await fnMaidForms.onSave(
        `${baseUrl}/master/maids/medicals?maid=${prefixInput.value}`,
        new FormData(formMedical),
        "post"
    );
    await fnMaidForms.onSave(
        `${baseUrl}/master/maids/others?maid=${prefixInput.value}`,
        new FormData(formOther),
        "post"
    );

    const resultsData = await fnMaidForms.onSave(
        `${baseUrl}/master/maids`,
        new FormData(formDataMaid),
        "post"
    );

    unBlockUI();

    if (resultsData.data.status) {
        window.history.pushState(
            "",
            "",
            `${baseUrl}/master/maids/register-maid`
        );

        window.history.go(0);
    } else {
        if (resultsData.data.message.prefix) {
            Toastify({
                text: resultsData.data.message.prefix[0],
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#dc3545",
            }).showToast();
        }

        if (resultsData.data.message.photoFileMaid) {
            Toastify({
                text: resultsData.data.message.photoFileMaid,
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#dc3545",
            }).showToast();
        }
    }
});
