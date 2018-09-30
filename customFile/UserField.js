function AddEditUser() {
    $('#form_data').on('submit', (function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        if ($('#module_id').val()) {
            formData['module_id'] = $('#module_id').val();
        }
        $.ajax({
            type: 'POST',
            url: "customFile/UserFieldPro.php",
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
function addUser() {

    $.ajax({
        type: "POST",
        url: "customFile/UserFieldPro.php",
        enctype: 'multipart/form-data',
        data: {
            user_name: $("#user_fullname").val(),
            user_pass: $("#user_contact").val(),
            user_name: $("#user_email").val(),
            user_pass: $("#user_login_username").val(),
            user_mobile: $("#user_login_password").val(),
            user_address: $("#user_log").val(),
            user_name: $("#user_createdby").val(),
            user_status: $("#user_status").prop('checked'),

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
function changeUserStatus(uid) {
    $.ajax({
        url: "customFile/UserFieldPro.php",
        type: "POST",
        data: {
            uid: uid,
            ustatus: $("#" + uid).data('status'),
            action: "changeStatus"
        },
        dataType: "json",
        success: function (data) {
            if (data.status) {
                if ($("#" + uid).data('status') == 'true') {
                    $("#li" + uid).removeClass("fa-eye");
                    $("#li" + uid).addClass("fa-eye-slash");

                    $("#s" + uid).removeClass("fa-eye-slash");
                    $("#s" + uid).addClass("fa-eye");

                    $("#" + uid).data('status', 'false');
                } else {
                    $("#li" + uid).removeClass("fa-eye-slash");
                    $("#li" + uid).addClass("fa-eye");

                    $("#s" + uid).removeClass("fa-eye");
                    $("#s" + uid).addClass("fa-eye-slash");

                    $("#" + uid).data('status', 'true');
                }
                swal("Success!", data.msg, "success");
            } else {
                swal("Error!", data.status, "error");
            }
        },
        fail: function () {
            swal("Error!", "Error while performing operation!", "error");
        },
        error: function (data, status, jg) {
            swal("Error!", data.responseText, "error");
        }
    });
}
function editPost() {

    $.ajax({
        type: "POST",
        url: "customFile/UserFieldPro.php",
        enctype: 'multipart/form-data',
        data: {
            user_name: $("#user_fullname").val(),
            user_pass: $("#user_contact").val(),
            user_name: $("#user_email").val(),
            user_pass: $("#user_login_username").val(),
            user_mobile: $("#user_login_password").val(),
            user_address: $("#user_log").val(),
            user_name: $("#user_createdby").val(),
            user_status: $("#user_status").prop('checked'),
            user_id: $("#user_id").val(),
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

function getPost() {
    $.ajax({
        type: "POST",
        url: "customFile/getPostPro.php",
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
                    htmlData += "<td>" + value[4] + "</td>";
                    htmlData += "<td>" + value[5] + "</td>";
                    htmlData += "<td>" + value[6] + "</td>";
                    htmlData += "<td>" + value[7] + "</td>";
                    
                    htmlData += "<td><a href='AddPosts.php?id=" + value[0] + "' type='button' id='" + value[0] + "' class='btn btn-primary'><i class='fa fa-edit'></i> Edit</a><a href='delete-operation.php?post_id=" + value[0] + "' type='button' id='" + value[0] + "' class='btn btn-primary'><i class='fa fa-remove'></i>Delete</a></td>";

                    i++;
                });
                $("#post_list").html(htmlData);
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







