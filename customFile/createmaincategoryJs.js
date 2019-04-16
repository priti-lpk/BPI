function addmainCategory() {
    //alert("dsf");
    $.ajax({
        type: "POST",
        url: "customFile/createmaincategoryPro.php",
        enctype: 'multipart/form-data',
        data: {
            name: $("#name").val(),
            action: "add"
        },
        dataType: "json",
        success: function (data) {
            //alert(data);
             getmainCategory();
            $('#addmaincategory').modal('toggle');
            if (data.status) {
                swal("Success!", data.msg, "success");
            } else {
                swal("Error!", data.msg, "error");
            }
             $('#addmaincategory').find('input:text').val('');

        },
        fail: function () {
            //$('#addmaincategory').modal('toggle');
            swal("Error!", "Error while performing operation!", "error");
        },
        error: function (data, status, jq) {
           // $('#addmaincategory').modal('toggle');
            swal("Error!", data.responseText, "error");
        }
    });
}


