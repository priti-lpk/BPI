function setrateID(id) {
    $("#quotation_id").val(id);
}
function addRate() {
    var newid = $("#quotation_id").val();

    $.ajax({
        url: "customFile/newratePro.php",
        type: "POST",
        data: {
            qid: $("#quotation_id").val(),
            new_rate: $("#new_rate").val(),
            action: "new_rate"
        },
        dataType: "json",
        success: function (data) {

            $('#addrate').modal('toggle');
            if (data.status) {
                $("#nr" + $("#quotation_id").val()).html($("#new_rate").val());
//                $("#sp" + $("#quotation_id").val()).removeAttr('disabled');
                $("#sp" + $("#quotation_id").val()).css({'pointer-events': 'default', 'opacity': '100'});
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

