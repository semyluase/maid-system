const fnBookedWorker = {
    init: {
        forms: {
            formBooking: document.querySelector("#form-booking"),
        },
        buttons: {
            btnSubmit: document.querySelector("#btn-save"),
        },
    },

    onSave: async(url, data, method) => {
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
};

// fnBookedWorker.init.buttons.btnSubmit.addEventListener("click", async(e) => {
//     e.preventDefault();

//     blockUI
// });