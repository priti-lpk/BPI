function addSupplier() {
//alert("js fiole");
    $.ajax({
        type: "POST",
        url: "customFile/createsupplierPro.php",
        enctype: 'multipart/form-data',
        data: {
            sup_name: $("#sup_name").val(),
            sup_add: $("#sup_add").val(),
            sup_contact: $("#sup_contact").val(),
            sup_email: $("#sup_email").val(),
            sup_gstno: $("#sup_gstno").val(),
            country_id: $("#countries").val(),
            city_id: $("#cities").val(),
            action: "add"
        }
        ,
        dataType: "json",
        success: function (data) {
            //console.log(data);
            getsupplier();
            $('#addsupplier').modal('toggle');
            if (data.status) {
                swal("Success!", data.msg, "success");
            } else {
                swal("Error!", data.msg, "error");
            }
            $('#addsupplier').find('input:text').val('');
            $('input:checkbox').removeAttr('checked');
        },
        fail: function () {
            $('#addsupplier').modal('toggle');
            swal("Error!", "Error while performing operation!", "error");
        },

        error: function (data, status, jq) {
            console.log(data);
            console.log(data.status);

            $('#addsupplier').modal('toggle');
            swal("Error!", data.responseText, "error");
        }
    });

}

