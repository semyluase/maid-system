const countryInput = document.querySelector("#country");
const workersInput = document.querySelector("#workers");
const agenciesInput = document.querySelector("#agencies");

const fnAvailableMail = {
    init: {
        dropdowns: {
            countryChoices: new Choices(countryInput, { shouldSort: false }),
            workersChoices: new Choices(workersInput, { shouldSort: false }),
        },
        buttons: {
            btnSend: document.querySelector("#btn-send"),
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

    onInit: async() => {
        await fnAvailableMail.onCreateDropdown(
            `${baseUrl}/dropdown/get-country-mail`,
            fnAvailableMail.init.dropdowns.countryChoices,
            "Choose Country",
            ""
        );

        await fnAvailableMail.onCreateDropdown(
            `${baseUrl}/dropdown/get-maid-mails?country=`,
            fnAvailableMail.init.dropdowns.workersChoices,
            "Worker",
            null
        );
    },
};

fnAvailableMail.onInit();

countryInput.addEventListener("change", async() => {
    await fnAvailableMail.onCreateDropdown(
        `${baseUrl}/dropdown/get-maid-mails?country=${fnAvailableMail.init.dropdowns.countryChoices.getValue(
            true
        )}`,
        fnAvailableMail.init.dropdowns.workersChoices,
        "Worker",
        null
    );
});

fnAvailableMail.init.buttons.btnSend.addEventListener("click", async() => {
    const results = await fnAvailableMail.onSave(
        `${baseUrl}/master/maids/send-batch-mail/sending`,
        JSON.stringify({
            country: fnAvailableMail.init.dropdowns.countryChoices.getValue(true),
            workers: fnAvailableMail.init.dropdowns.workersChoices.getValue(true),
            agencies: agenciesInput.value,
            _token: fnAvailableMail.init.buttons.btnSend.dataset.csrf,
        }),
        "post"
    );

    if (results.data.status) {
        await Swal.fire(
            "Success Sending Mail",
            results.data.message,
            "success"
        );

        window.close();
    } else {
        await Swal.fire("Error Sending Mail", results.data.message, "error");
    }
});
