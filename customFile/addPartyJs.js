function AddEditParty() {
    $('#form_data').on('submit', (function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        if ($('#party_id').val()) {
            formData['party_id'] = $('#party_id').val();
        }
        $.ajax({
            type: 'POST',
            url: "customFile/addPartyPro.php",
            data: formData,
            cache: false,
            dataType: "json",
            contentType: false,
            processData: false,
            enctype: 'multipart/form-data',
            success: function (data) {
                console.log(data);
                if (data.status) {
                    swal("Success!", data.msg, "success");
                    // window.location.replace("../admin/AddPosts");

                } else {
                    swal("Error!", data.msg, "error");
                }
                return;
            },
            fail: function () {
                swal("Error!", "Error while performing operation!", "error");
            },
            error: function (data, status, jq) {
                swal("Error!", data.responseText, "error");
            }
        });
    }));
}
function addParty() {

    $.ajax({
        type: "POST",
        url: "customFile/addPartyPro.php",
        enctype: 'multipart/form-data',
        data: {
            party_name: $("#party_name").val(),
            party_contact: $("#party_contact").val(),
            party_address: $("#party_address").val(),
            party_gstno: $("#party_gstno").val(),
            action: "add"
        },
        dataType: "json",
        success: function (data) {
            $('#addModal').modal('toggle');
            if (data.status) {
                swal("Success!", data.msg, "success");
            } else {
                swal("Error!", data.msg, "error");
            }
        },
        fail: function () {
            $('#addModal').modal('toggle');
            swal("Error!", "Error while performing operation!", "error");
        },
        error: function (data, status, jq) {
            $('#addModal').modal('toggle');
            swal("Error!", data.responseText, "error");
        }
    });

}

function editParty() {

    $.ajax({
        type: "POST",
        url: "customFile/addPartyPro.php",
        data: {
            party_name: $("#party_name").val(),
            party_contact: $("#party_contact").val(),
            party_address: $("#party_address").val(),
            party_gstno: $("#party_gstno").val(),
            // party_amount: $("#party_amount").val(),
            party_id: $("#party_id").val(),
            action: "edit"
        },
        dataType: "json",
        success: function (data) {
            if (data.status) {
                swal("Success!", data.msg, "success");
            } else {
                swal("Error!", data.msg, "error");
            }
        },
        fail: function () {
            swal("Error!", "Error while performing operation!", "error");
        },
        error: function (data, status, jq) {
            $('#addModal').modal('toggle');
            swal("Error!", data.responseText, "error");
        }
    });

}

function getParty() {
    $.ajax({
        type: "POST",
        url: "customFile/getPartyPro.php",
        data: {
            isFilter: true
        },
        dataType: "json",
        befor: function () {
            alert("Test");
        },
        success: function (jsonData) {
            if (jsonData.status) {
                var i = 1;
                var htmlData = "";
                $.each(jsonData.data, function (key, value) {
                    htmlData += "<tr><td>" + i + "</td>";
                    htmlData += "<td>" + value[1] + "</td>";
                    htmlData += "<td>" + value[2] + "</td>";
                    htmlData += "<td>" + value[3] + "</td>";
                    //htmlData += "<td>" + value[4] + "</td>";
                    htmlData += "<td><a href='AddParty.php?id=" + value[0] + "' type='button' id='" + value[0] + "' class='btn btn-primary'><i class='fa fa-edit'></i> Edit</a><a href='delete-operation.php?post_id=" + value[0] + "' type='button' id='" + value[0] + "' class='btn btn-primary'><i class='fa fa-remove'></i>Delete</a></td>";

                    i++;
                });
                $("#party_list").html(htmlData);
                if ($('#featured-datatable').length > 0) {
                    exportTable = $('#featured-datatable').DataTable({
                        sDom: "T<'clearfix'>" +
                                "<'row'<'col-sm-6'l><'col-sm-6'f>r>" +
                                "t" +
                                "<'row'<'col-sm-6'i><'col-sm-6'p>>",
                        "tableTools": {
                            "sSwfPath": "assets/js/plugins/datatable/exts/swf/copy_csv_xls_pdf.swf"
                        }
                    });
                }
            }
        },
        fail: function () {
            swal("Error!", "Error while performing operation!", "error");
        },
        error: function (data, textStatus, jqXHR) {
            swal("Error!", data.responseText, "error");
        }
    });
}





