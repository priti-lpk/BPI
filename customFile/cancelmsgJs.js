function setrateID(id) {
    $("#inquiry_id").val(id);
}
function addMsg() {
    var newid = $("#inquiry_id").val();

    $.ajax({
        url: "customFile/cancelmsgPro.php",
        type: "POST",
        data: {
            id: $("#inquiry_id").val(),
            message: $("#message").val(),
            action: "msg"
        },
        dataType: "json",
        success: function (data) {

            $('#addmsg').modal('toggle');
            if (data.status) {
                $("#inquiry_id").val().html($("#message").val());
                window.location.reload();
//                $("#sp" + $("#quotation_id").val()).removeAttr('disabled');
//                ($("#inquiry_id").val()).css({'pointer-events': 'default', 'opacity': '100'});
                // swal("Success!", data.msg, "success");
            } else {
                // swal("Error!", data.status, "error");
                window.location.reload();

            }
        },
        fail: function () {
            // swal("Error!", "Error while performing operation!", "error");                                
            window.location.reload();
        },
        error: function (data, status, jg) {
            //  swal("Error!", data.responseText, "error");
            window.location.reload();

        }
    });
}

