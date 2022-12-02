const codeMaidInput = document.querySelector("#codeMaid");
const countryInput = document.querySelector("#country");
const agencyInput = document.querySelector("#agency");
const btnSave = document.querySelector("#btn-save");

const fnMailing = {
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
        // await fnMailing.onCreateDropdown(
        //     `${baseUrl}/dropdown/get-agency-mail?maid=${codeMaidInput.value}&country=${countryInput.value}`,
        //     agencyChoices,
        //     "Agency",
        //     null
        // );
        agencyInput.value = "";
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
};

fnMailing.onInit();

// btnSave.addEventListener("click", async() => {
//     blockUI();
//     const results = await fnMailing.onSave(
//         `${baseUrl}/mail/broadcasting`,
//         JSON.stringify({
//             agency: agencyInput.value,
//             maids: codeMaidInput.value,
//             country: countryInput.value,
//             _token: btnSave.dataset.csrf,
//         }),
//         "post"
//     );
//     unBlockUI();

//     if (results.data.status) {
//         Toastify({
//             text: results.data.message,
//             duration: 3000,
//             close: true,
//             gravity: "top",
//             position: "right",
//             backgroundColor: "#198754",
//         }).showToast();
//     } else {
//         Toastify({
//             text: results.data.message,
//             duration: 3000,
//             close: true,
//             gravity: "top",
//             position: "right",
//             backgroundColor: "#dc3545",
//         }).showToast();
//     }

//     window.close();
// });