const fnDocument = {
    init: {
        buttons: {
            btnAddDocument: document.querySelector("#btn-add-document"),
            btnSaveDocument: document.querySelector("#btn-save-document"),
        },
        modals: {
            modalDocument: new bootstrap.Modal(
                document.querySelector("#modal-document")
            ),
        },
        tables: {
            tbDocument: $("#tb-document").DataTable({
                ajax: `${baseUrl}/master/maids/documents/get-all-data`,
                paging: false,
            }),
        },
    },
};

fnDocument.init.buttons.btnAddDocument.addEventListener("click", async() => {
    await fnDocument.init.modals.modalDocument.show();
});