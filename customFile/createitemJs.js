function addItem() {

    $.ajax({
        type: "POST",
        url: "customFile/createitemPro.php",
        enctype: 'multipart/form-data',
        data: {
            sub_cat_id: $("#sub_category").val(),
            item_name: $("#item_name").val(),
            item_unit_id: $("#unit_list").val(),
            remark: $("#remark").val(),
            action: "add"
        },
        dataType: "json",
        success: function (data) {
            var blankrow = $("#item_name1").val();
            if (blankrow == "") {
                $('#row1').remove();
            }
            var i = $('.item_table tr ').length;
            var code = $("#item_name").val();

            var my_object = {"item_code": i, "codename": code};
            
            $.ajax({
                url: 'getItemCode.php',
                dataType: "html",
                data: my_object,
                success: function (data1) {
                    var data = "<tr id='row" + i + "' data='no'><td><input type = 'checkbox' class = 'case' id='check" + i + "' name='check[]' value='" + i + "'></td><td><input type='text' id = 'snum" + i + "' value='" + i + "' class='snum' /></td>";
                    data += "<td>" + data1 + "</td><td><input type='text' id='item_name" + i + "' class='itemname' name='item_name[]' required/></td> <td><input type='text' id='unit" + i + "' class='unit1' name='item_unit[]' required/></td><td><input type='text' id='qnty" + i + "' class='qnty1' name='item_quantity[]' onchange='changeQnty(this);' required/></td><td><input style='width:420px;' type='text' id='remark" + i + "' class='remark1' name='remark[]' required/></td></tr>";
                    $('#item_table').append(data);

                    rowgetValue(i);

                    i++;
                },
                error: function (errorThrown) {
                    alert(errorThrown);
                    alert("There is an error with AJAX!");
                }
            });
            $('#additem').modal('toggle');
            if (data.status) {
                swal("Success!", data.msg, "success");
            } else {
                swal("Error!", data.msg, "error");
            }
            $('#additem').find('input:text').val('');
            $('input:checkbox').removeAttr('checked');
        },
        fail: function () {
            $('#additem').modal('toggle');
            swal("Error!", "Error while performing operation!", "error");
        }
        ,
        error: function (data, status, jq) {
            $('#additem').modal('toggle');
            swal("Error!", data.responseText, "error");
        }


    });

}


