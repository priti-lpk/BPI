function AddEditPosts() {
    $('#form_data').on('submit', (function (e) {
        e.preventDefault();
        var formData = new FormData(this);
      
        if ($('#sales_order_id').val()) {
            formData['sales_order_id'] = $('#sales_order_id').val();
        }
        $.ajax({
            type: 'POST',
            url: "customFile/AddSalesOrderPro.php",
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
function addPost() {
 
    $.ajax({
        type: "POST",
        url: "customFile/AddSalesOrderPro.php",
        enctype: 'multipart/form-data',
        data: {
            party_id: $("#party_id").val(),
            date: $("#date").val(),
            total: $("#total").val(),
            note: $("#note").val(),
           
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

function editPost() {
  
    $.ajax({
        type: "POST",
        url: "customFile/AddSalesOrderPro.php",
        data: {
            party_id: $("#party_id").val(),
            date: $("#date").val(),
            total: $("#total").val(),
            note: $("#note").val(),
            sales_order_id: $("#sales_order_id").val(),
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
      befor: function() {
         alert("Test");
      },
      success: function(jsonData) {
         if (jsonData.status) {
             var i=1;
            var htmlData = "";
            $.each(jsonData.data, function(key, value) {
               htmlData += "<tr><td>" + i + "</td>";
               htmlData += "<td>" + value[1] + "</td>";
               htmlData += "<td>" + value[2] + "</td>";
               htmlData += "<td>" + value[3] + "</td>";
               htmlData += "<td>" + value[4] + "</td>";
               htmlData += "<td><a href='AddPosts.php?id=" + value[0] + "' type='button' id='" + value[0] + "' class='btn btn-primary'><i class='fa fa-edit'></i> Edit</a><a href='delete-operation.php?post_id=" + value[0] + "' type='button' id='" + value[0] + "' class='btn btn-primary'><i class='fa fa-remove'></i>Delete</a></td>";
               
           i++; });
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
      fail: function() {
         swal("Error!", "Error while performing operation!", "error");
      },
      error: function(data, textStatus, jqXHR) {
         swal("Error!", data.responseText, "error");
      }
   });
}




