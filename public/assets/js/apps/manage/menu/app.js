const roleInput = document.querySelector("#role");
const btnSimpan = document.querySelector("#simpan-jstree");

const roleChoices = new Choices(roleInput, {
    shouldSort: false,
});

let url, data;

const manageMenu = {
    createDropdown: async(url, choices, placeholder, selected) => {
        choices.clearChoices();
        choices.setChoices([{
            label: placeholder,
            value: selected == "" ? selected : "",
            disabled: true,
        }, ]);

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

        choices.setChoiceByValue(selected);
    },

    onInit: async() => {
        if (!btnSimpan.classList.contains("d-none")) {
            btnSimpan.classList.add("d-none");
        }

        roleChoices.clearStore();
        await manageMenu.createDropdown(
            `${baseUrl}/dropdown/get-role`,
            roleChoices,
            "Choose Role",
            ""
        );
    },

    setUser: async(role) => {
        await manageMenu.loadMenu(role);
        btnSimpan.classList.remove("d-none");
    },

    loadMenu: async(role) => {
        url = `${baseUrl}/master/menus/get-menu-tree?role=${role}`;

        await fetch(url)
            .then((response) => {
                if (!response.ok) {
                    throw new Error(
                        Toastify({
                            text: "Terjadi kesalahan saat pengambilan data",
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "#EF5950",
                        }).showToast()
                    );
                }

                return response.json();
            })
            .then((response) => {
                $("#jstree-menu").jstree("destroy");
                $("#jstree-menu").jstree({
                    plugins: ["wholerow", "checkbox", "types"],
                    core: {
                        themes: {
                            responsive: !1,
                        },
                        data: response,
                    },
                    types: {
                        default: {
                            icon: "fas fa-tag icon-state-warning",
                        },
                    },
                });
            });
    },

    postData: async(url, data, method, csrf) => {
        return await fetch(url, {
                method: method,
                body: data,
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrf,
                },
            })
            .then((response) => {
                if (!response.ok) {
                    throw new Error(
                        Toastify({
                            text: "Terjadi kesalahan saat pengiriman data",
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "#EF5950",
                        }).showToast()
                    );
                }

                return response.json();
            })
            .then((response) => response);
    },
};

manageMenu.onInit();

roleInput.addEventListener("change", async() => {
    blockUI();

    await manageMenu.loadMenu(roleChoices.getValue(true));
    btnSimpan.classList.remove("d-none");

    unBlockUI();
});

btnSimpan.addEventListener("click", async() => {
    let arr = $("#jstree-menu").jstree("get_checked");
    $("#jstree-menu")
        .find(".jstree-undetermined")
        .each(function(i, element) {
            arr.push($(element).closest(".jstree-node").attr("id"));
        });
    let csrf = btnSimpan.dataset.csrf;

    url = `${baseUrl}/manage/menus`;

    data = {
        menu: arr,
        role: roleChoices.getValue(true),
        _token: csrf,
    };

    blockUI();

    const results = await manageMenu.postData(
        url,
        JSON.stringify(data),
        "post",
        csrf
    );

    unBlockUI();

    if (results.data.status) {
        Toastify({
            text: results.data.message,
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: "#769769",
        }).showToast();

        $("#jstree-menu").jstree("destroy");
        manageMenu.onInit();
    } else {
        Toastify({
            text: results.data.message,
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: "#EF5950",
        }).showToast();
    }
});
