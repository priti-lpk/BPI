function AddEditPayment() {
    $('#form_data').on('submit', (function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        
        if ($('#payment_id').val()) {
            formData['payment_id'] = $('#payment_id').val();
        }
        $.ajax({
            type: 'POST',
            url: "customFile/addPaymentPro.php",
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
function addPayment() {
    
    $.ajax({
        type: "POST",
        url: "customFile/addPaymentPro.php",
        enctype: 'multipart/form-data',
        data: {
            party_id: $("#party_id").val(),
            party_due: $("#party_due").val(),
            party_crdb:$("#party_crdb").val(),
            pay_crdb: $("#pay_crdb").val(),
            pay_amount: $("#pay_amount").val(),
            pay_discount: $("#pay_discount").val(),
            remain_amount: $("#remain_amount").val(),
            pay_type: $("#pay_type").val(),
            bank_name: $("#bank_name").val(),
            cheque_no: $("#cheque_no").val(),
            pay_date: $("#pay_date").val(),
            pay_note: $("#pay_note").val(),
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

function editItem() {
   
    $.ajax({
        type: "POST",
        url: "customFile/addItemPro.php",
        data: {
            party_id: $("#party_id").val(),
            party_due: $("#party_due").val(),
            party_crdb:$("#party_crdb").val(),
            pay_crdb: $("#pay_crdb").val(),
            pay_amount: $("#pay_amount").val(),
            pay_discount: $("#pay_discount").val(),
            remain_amount: $("#remain_amount").val(),
            pay_type: $("#pay_type").val(),
            bank_name: $("#bank_name").val(),
            cheque_no: $("#cheque_no").val(),
            pay_date: $("#pay_date").val(),
            pay_note: $("#pay_note").val(),
            payment_id: $("#payment_id").val(),
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

function getItem() {
   $.ajax({
      type: "POST",
      url: "customFile/getItemPro.php",
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
               htmlData += "<td>" + value[5] + "</td>";
               htmlData += "<td>" + value[6] + "</td>";
                htmlData += "<td>" + value[7] + "</td>";
               htmlData += "<td>" + value[8] + "</td>";
               
               htmlData += "<td><a href='AddItems.php?id=" + value[0] + "' type='button' id='" + value[0] + "' class='btn btn-primary'><i class='fa fa-edit'></i> Edit</a><a href='delete-operation.php?item_id=" + value[0] + "' type='button' id='" + value[0] + "' class='btn btn-primary'><i class='fa fa-remove'></i>Delete</a></td>";
               
           i++; });
            $("#item_list").html(htmlData);
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





