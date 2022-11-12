let url, data, method;

const fnHistoryMaid = {
    init: {
        tables: {
            tbMaid: $("#tb-maid").DataTable({
                ajax: `${baseUrl}/history/maids/get-all-data`,
                serverSide: true,
                processing: true,
            }),
        },
    },

    onLoadTable: () => {
        fnHistoryMaid.init.tables.tbMaid.ajax
            .url(`${baseUrl}/history/maids/get-all-data`)
            .draw();
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
                            text: "Something error while sending data",
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

    reactivateData: async(code, csrf) => {
        const results = await fnHistoryMaid.onSave(
            `${baseUrl}/history/maids/${code}`,
            JSON.stringify({
                _token: csrf,
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

            fnHistoryMaid.onLoadTable();
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
    },

    deleteData: async(code, csrf) => {
        url = `${baseUrl}/history/maids/${code}`;

        await Swal.fire({
            icon: "info",
            title: "Delete Data",
            text: "Are you sure to permanently delete this data?",
            showCancelButton: true,
            confirmButtonColor: "#435ebe",
            confirmButtonText: "Yes, I'm sure",
            cancelButtonColor: "#dc3545",
            cancelButtonText: "No",
        }).then(async(result) => {
            if (result.value) {
                blockUI();

                data = JSON.stringify({
                    _token: csrf,
                });

                const results = await fnHistoryMaid.onSave(url, data, "delete");

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

                    fnHistoryMaid.onLoadTable();
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