//function setrateID(id) {
//    $("#quotation_id").val(id);
//}
function addNote() {

    $.ajax({
        url: "../customFile/newNotePro.php",
        type: "POST",
        data: {
            sid: $("#send_party_id").val(),
            status: $("#status").val(),
            note: $("#note").val(),
            action: "note"
        },
        dataType: "json",
        success: function (data) {
           // alert(data);
            $('#notebox').modal('toggle');
            if (data.status) {
//                $("#rp"+ $("#comments_id").val()).html($("#comments_reply").val());
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

