function addBranch() {
    //alert("sd");
    $.ajax({
        type: "POST",
        url: "customFile/createbranchPro.php",
        enctype: 'multipart/form-data',
        data: {
            branch_name: $("#branch_name").val(),
            branch_address: $("#branch_address").val(),
            branch_contact: $("#branch_contact").val(),
            branch_email: $("#branch_email").val(),
            branch_status: $("#branch_status").prop('checked'),
            action: "add"
        },
        dataType: "json",
        success: function (data) {
           // alert(data);
            getbranch();
            $('#addbranch').modal('toggle');
            if (data.status) {
                swal("Success!", data.msg, "success");
            } else {
                swal("Error!", data.msg, "error");
            }
            $('#addbranch').find('input:text').val('');

        },
        fail: function () {
            $('#addbranch').modal('toggle');
            swal("Error!", "Error while performing operation!", "error");
        },
        error: function (data, status, jq) {

            $('#addbranch').modal('toggle');
            swal("Error!", data.responseText, "error");
        }
    });

}