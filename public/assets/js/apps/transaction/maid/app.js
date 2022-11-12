const fnTransactionMaid = {
    init: {
        buttons: {
            btnAccept: document.querySelector("#btn-accept"),
            btnReject: document.querySelector("#btn-reject"),
        },
        inputs: {
            message: document.querySelector("#message"),
            id: document.querySelector("#maidID"),
        },
        modals: {
            modalApprove: new bootstrap.Modal(
                document.querySelector("#approved")
            ),
            modalActivities: new bootstrap.Modal(
                document.querySelector("#activities")
            ),
        },
        section: {
            activities: document.querySelector("#sectionActivities"),
        },
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

    onApproved: async(id) => {
        await fetch(`${baseUrl}/transaction/maids/${id}`)
            .then((response) => {
                if (!response.ok) {
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
                await fnTransactionMaid.init.modals.modalApprove.show();

                fnTransactionMaid.init.inputs.id.value = response.code_maid;
            });
    },

    onActivities: async(id) => {
        await fetch(`${baseUrl}/transaction/maids/${id}/edit`)
            .then((response) => {
                if (!response.ok) {
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
                await fnTransactionMaid.init.modals.modalApprove.show();

                fnTransactionMaid.init.inputs.id.value = response.code_maid;
            });
    },
};

fnTransactionMaid.init.buttons.btnAccept.addEventListener("click", async() => {
    const results = await fnTransactionMaid.onSave(
        `${baseUrl}/transaction/maids/${fnTransactionMaid.init.inputs.id.value}`,
        JSON.stringify({
            message: fnTransactionMaid.init.inputs.message.value,
            type: "accept",
            _token: fnTransactionMaid.init.buttons.btnAccept.dataset.csrf,
        }),
        "put"
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

        location.reload();
    } else {
        Toastify({
            text: results.data.message,
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: "#198754",
        }).showToast();
    }
});

fnTransactionMaid.init.buttons.btnReject.addEventListener("click", async() => {
    const results = await fnTransactionMaid.onSave(
        `${baseUrl}/transaction/maids/${fnTransactionMaid.init.inputs.id.value}`,
        JSON.stringify({
            message: fnTransactionMaid.init.inputs.message.value,
            type: "reject",
            _token: fnTransactionMaid.init.buttons.btnReject.dataset.csrf,
        }),
        "put"
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

        location.reload();
    } else {
        Toastify({
            text: results.data.message,
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: "#198754",
        }).showToast();
    }
});