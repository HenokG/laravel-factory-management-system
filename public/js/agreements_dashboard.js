function populateModal(customer_id, performa_no) {
    $("input[name='performa_no']").val(performa_no);
    $("input[name='customer_id']").val(customer_id);
}

function submitAddAgreementForm() {
    $("#addAgreementButton").click();
}

function filterCompaniesTable() {
    let tableRows = $("tr");
    for (let i = 0; i < tableRows.length; i++) {
        let td = tableRows[i].getElementsByTagName("td")[1];
        if (td) {
            if (td.innerHTML.toUpperCase().indexOf($("#filter-table").val().toUpperCase()) > -1) {
                tableRows[i].style.display = "";
            } else {
                tableRows[i].style.display = "none";
            }
        }
    }
}

function deleteAgreement(id) {
    $.ajax({
        url: '/agreement/'+id,
        type: 'POST',
        data: {
            _method: 'DELETE',
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            notify(data.notification_message);
            console.log(data);
            $("tr#" + id).remove();
        },
        error: function (data) {
            notify("Error Occurred While Deleting Agreement!");
            console.log(data);
        }
    });
}