function checkpass() {
   // alert("21");
    $.ajax({
        type: "POST",
        url: "customFile/check_pass.php",
        enctype: 'multipart/form-data',
        data: {
            pass: $("#pwd").val(),
            action: "check"
        },
        dataType: "json",
        success: function (data) {
        // alert(data);
            $('#passopen').modal('toggle');
            if (data.status) {
                //swal("Success!", data.msg, "success");
                window.location.href = 'chang_pass.php';
                
            } else {
                swal("Alert!", data.msg, "error");
                //window.location.href = 'Dashboard.php';
            }
           
        },
        fail: function () {
            //$('#addalbum').modal('toggle');
            swal("Error!", "Error while performing operation!", "error");
        },
        error: function (data, status, jq) {
          //  $('#addalbum').modal('toggle');
            swal("Error!", data.responseText, "error");
        }
    });
}


