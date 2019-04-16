function mainCategory() {

    $.ajax({
        type: "POST",
        url: "customFile/createmaincategoryPro.php",
        enctype: 'multipart/form-data',
        data: {
            main_cat_name: $("#main_cat_name").val(),
            main_image: $("#main_image1").val(),
            action: "add"
        },
        dataType: "json",
        success: function (data) {
            getCategory();
            $('#maincategory').modal('toggle');
            if (data.status) {
                swal("Success!", data.msg, "success");
            } else {
                swal("Error!", data.msg, "error");
            }
            $('#maincategory').find('input:text').val('');
//            $("#additem").modal("show");
//            $("#category_list").val($("#category_name").val());
        },
        fail: function () {
            $('#maincategory').modal('toggle');
            swal("Error!", "Error while performing operation!", "error");
        },
        error: function (data, status, jq) {
            $('#maincategory').modal('toggle');
            swal("Error!", data.responseText, "error");
        }
    });
}


