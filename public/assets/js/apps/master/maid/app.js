document.querySelector("#sidebar").classList.remove("active");

const fnMaid = {
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

    onDelete: async(id, code, csrf) => {
        await Swal.fire({
            icon: "info",
            title: "Delete Data",
            text: "Are you sure to delete this data ?",
            showCancelButton: true,
            confirmButtonColor: "#435ebe",
            confirmButtonText: "Yes, i'm sure",
            cancelButtonColor: "#dc3545",
            cancelButtonText: "no",
        }).then(async(result) => {
            if (result.value) {
                blockUI();

                data = JSON.stringify({
                    _token: csrf,
                });

                const results = await fnMaid.onSave(
                    `${baseUrl}/master/maids/${code}`,
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
    onDownload: async(codeMaid, country) => {
        window.open(
            `${baseUrl}/master/maids/download-data?maid=${codeMaid}&country=${country}`
        );

        document.querySelector("#sidebar").classList.remove("active");
    },
};