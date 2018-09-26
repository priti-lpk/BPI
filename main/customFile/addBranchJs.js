function AddEditBranch() {
    $('#form_data').on('submit', (function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        
        if ($('#branch_id').val()) {
            formData['branch_id'] = $('#branch_id').val();
        }
        $.ajax({
            type: 'POST',
            url: "customFile/addBranchPro.php",
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
function addBranch() {
    
    $.ajax({
        type: "POST",
        url: "customFile/addBranchPro.php",
        enctype: 'multipart/form-data',
        data: {
            branch_name: $("#branch_name").val(),
            branch_address: $("#branch_address").val(),
            branch_contact: $("#branch_contact").val(),
            branch_email: $("#branch_email").val(),
            branch_login_username: $("#branch_login_username").val(),
            branch_login_password: $("#branch_login_password").val(),
            branch_status: $("#branch_status").prop('checked'),
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

function editBranch() {
   
    $.ajax({
        type: "POST",
        url: "customFile/addBranchPro.php",
        data: {
            branch_name: $("#branch_name").val(),
            branch_address: $("#branch_address").val(),
            branch_contact: $("#branch_contact").val(),
            branch_email: $("#branch_email").val(),
            branch_login_username: $("#branch_login_username").val(),
            branch_login_password: $("#branch_login_password").val(),
            branch_status: $("#branch_status").prop('checked'),
            branch_id: $("#branch_id").val(),
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
function changeBranchStatus(bid) {
    $.ajax({
        url: "customFile/addBranchPro.php",
        type: "POST",
        data: {
            bid: bid,
            bstatus: $("#" + bid).data('status'),
            //bstatus: "on",
            action: "changeStatus"
        },
        dataType: "json",
        success: function (data) {
            if (data.status) {
                if ($("#" + bid).data('status') == 'true') {
                    $("#li" + bid).removeClass("fa-eye");
                    $("#li" + bid).addClass("fa-eye-slash");

                    $("#s" + bid).removeClass("fa-eye-slash");
                    $("#s" + bid).addClass("fa-eye");

                    $("#" + bid).data('status', 'false');
                } else {
                    $("#li" + bid).removeClass("fa-eye-slash");
                    $("#li" + bid).addClass("fa-eye");

                    $("#s" + bid).removeClass("fa-eye");
                    $("#s" + bid).addClass("fa-eye-slash");

                    $("#" + bid).data('status', 'true');
                }
                swal("Success!", data.msg, "success");
            } else {
                swal("Error!", data.status, "error");
            }
        },
        fail: function () {
            swal("Error!", "Error while performing operation!", "error");
        },
        error: function (data, status, jg) {
            console.log(data);
            swal("Error!", data.responseText, "error");
        }
    });
}
function getBranch() {
   $.ajax({
      type: "POST",
      url: "customFile/getBranchPro.php",
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
               htmlData += "<td><a href='AddBranch.php?id=" + value[0] + "' type='button' id='" + value[0] + "' class='btn btn-primary'><i class='fa fa-edit'></i> Edit</a><a href='delete-operation.php?item_id=" + value[0] + "' type='button' id='" + value[0] + "' class='btn btn-primary'><i class='fa fa-remove'></i>Delete</a></td>";
               
           i++; });
            $("#branch_list").html(htmlData);
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





