const agencyInput = document.querySelector("#user-assign");
const agencyChoices = new Choices(agencyInput);
const maidsInput = document.querySelector("#maids");
const daysInput = document.querySelector("#days");
const maidsChoices = new Choices(maidsInput, {
    removeItemButton: true,
});
const btnSave = document.querySelector("#btn-save");

const fnBooking = {
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
        await fnBooking.onCreateDropdown(
            `${baseUrl}/dropdown/get-agency`,
            agencyChoices,
            "Agency",
            ""
        );

        await fnBooking.onCreateDropdown(
            `${baseUrl}/dropdown/get-maids?agency=`,
            maidsChoices,
            "Worker",
            null
        );
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
};

fnBooking.onInit();

agencyInput.addEventListener("change", async() => {
    await fnBooking.onCreateDropdown(
        `${baseUrl}/dropdown/get-maids?agency=${agencyChoices.getValue(true)}`,
        maidsChoices,
        "Worker",
        null
    );
});

btnSave.addEventListener("click", async() => {
    const results = await fnBooking.onSave(
        `${baseUrl}/booked/maids`,
        JSON.stringify({
            agency: agencyChoices.getValue(true),
            maids: maidsChoices.getValue(true),
            days: daysInput.value,
            _token: btnSave.dataset.csrf,
        }),
        "post"
    );

    if (results.data.status) {
        Toastify({
            text: results.data.message,
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: "#198754",
        }).showToast();

        location.href = `${baseUrl}/booked/maids`;
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
});
