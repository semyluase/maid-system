const workersInput = document.querySelector("#workers");
const agenciesInput = document.querySelector("#agencies");

const fnAvailableMail = {
    init: {
        dropdowns: {
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
            `${baseUrl}/dropdown/get-maid-user-mails`,
            fnAvailableMail.init.dropdowns.workersChoices,
            "Worker",
            null
        );
    },
};

fnAvailableMail.onInit();

fnAvailableMail.init.buttons.btnSend.addEventListener("click", async() => {
    const results = await fnAvailableMail.onSave(
        `${baseUrl}/workers/send-batch-mail`,
        JSON.stringify({
            workers: fnAvailableMail.init.dropdowns.workersChoices.getValue(true),
            agencies: agenciesInput.value,
            _token: fnAvailableMail.init.buttons.btnSend.dataset.csrf,
        }),
        "put"
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
