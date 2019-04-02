function fillFields(el) {
    $("input[name='name']").val(el.innerHTML);
}

function submitAddCustomer() {
    $("form[action='/customer']").submit();
}

function filterCompaniesTable() {
    let tableRows = $("tr");
    for (let i = 0; i < tableRows.length; i++) {
        let td = tableRows[i].getElementsByTagName("td")[0];
        if (td) {
            if (td.innerHTML.toUpperCase().indexOf($("#filter-table").val().toUpperCase()) > -1) {
                tableRows[i].style.display = "";
            } else {
                tableRows[i].style.display = "none";
            }
        }
    }
}

function deleteCustomerClick(id, company_id) {
    $.ajax({
        url: '/customer/' + id,
        type: 'POST',
        data: {
            company_id: company_id,
            _token: $('meta[name="csrf-token"]').attr('content'),
            _method: 'DELETE'
        },
        success: function (data) {
            console.log(data);
            $('tr#' + id).fadeOut('slow');
            notify("Company Deleted");
        },
        error: function (data) {
            console.log(data);

            notify("Error Occurred While Deleting A Company");
        }
    });
}

function onSendToSystem(wholeJsonArray) {
    $.ajax({
        url: URL,
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            excel: final_object
        },
        success: function (data) {
            console.log(data);
            if (data === 'success') {
                notify("Successfully Sent To System! :)");
                setTimeout(function () {
                    window.location.reload(true);
                }, 1200);
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
}