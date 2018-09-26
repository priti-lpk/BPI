function addsubCategory() {
        $.ajax({
        type: "POST",
        url: "customFile/createsubcategoryPro.php",
        enctype: 'multipart/form-data',
        data: {
            main_cat_id: $("#main_category").val(),
            sub_cat_name: $("#sub_cat_name").val(),
            action: "add"
        },
        dataType: "json",
        success: function (data) {
            //alert(data);
            getCategory();
            $('#addsubcategory').modal('toggle');
            if (data.status) {
                swal("Success!", data.msg, "success");
            } else {
                swal("Error!", data.msg, "error");
            }
             $('#addsubcategory').find('input:text').val('');
//            $("#additem").modal("show");
//            $("#category_list").val($("#category_name").val());
        },
        fail: function () {
            $('#addsubcategory').modal('toggle');
            swal("Error!", "Error while performing operation!", "error");
        },
        error: function (data, status, jq) {
           // alert(data);
            $('#addsubcategory').modal('toggle');
            swal("Error!", data.responseText, "error");
        }
    });
}




