function addrow() {
    var i = $('.item_table tr ').length;
    var my_object = "item_code=" + i;
    $.ajax({
        url: 'getItemCode.php',
        dataType: "html",
        data: my_object,
        success: function (data1) {
            //  count = $('.item_table tr ').length;
            var data = "<tr id='row" + i + "' data='no'><td><input type = 'checkbox' class = 'case' id='check" + i + "' name='check[]' value='" + i + "'></td><td><input type='text' id = 'snum" + i + "' value='" + i + "' class='snum' /></td>";
            data += "<td>" + data1 + "</td><td><input type='text' id='item_name" + i + "' class='itemname' name='item_name[]' required/></td> <td><input type='text' id='unit" + i + "' class='unit1' name='item_unit[]' required/></td><td><input type='text' id='qnty" + i + "' class='qnty1' name='item_quantity[]' onchange='changeQnty(this);' required/></td><td><input style='width:420px;' type='text' id='remark" + i + "' class='remark1' name='remark[]' required/></td></tr>";
            $('#item_table').append(data);
            i++;
        },
        error: function (errorThrown) {
            alert(errorThrown);
            alert("There is an error with AJAX!");
        }
    });
}
;

function getValue(rowid) {
    var i = rowid.parentNode.parentNode.rowIndex;
     //alert(i);
    var value = $("#item_code" + i).find(":selected").val();
    var dataString = 'id=' + value;

    $.ajax({
        url: 'suggestvalue.php',
        dataType: "html",
        data: dataString,
        cache: false,
        success: function (Data) {
            $('#qnty' + i).val('');

            var data = Data.split(",");
            $('#item_name' + i).val(data[0]);
            $('#unit' + i).val(data[1]);

        },
        error: function (errorThrown) {
            alert(errorThrown);
            alert("There is an error with AJAX!");
        }
    });
}
;
function rowgetValue(rowid) {
    var i = rowid;
    var value = $("#item_code" + i).find(":selected").val();

    var dataString = 'id=' + value;

    $.ajax({
        url: 'suggestvalue.php',
        dataType: "html",
        data: dataString,
        cache: false,
        success: function (Data) {
            $('#qnty' + i).val('');

            var data = Data.split(",");
            $('#item_name' + i).val(data[0]);
            $('#unit' + i).val(data[1]);
            $('#rate' + i).val(data[2]);
            $('#gst' + i).val(data[3]);
            $('#itemstock' + i).text(data[4]);
            $('#dbstock' + i).val(data[4]);
        },
        error: function (errorThrown) {
            alert(errorThrown);
            alert("There is an error with AJAX!");
        }
    });
}
;

function changeQnty(qntyid) {
    //alert(qntyid);
    var i = qntyid.parentNode.parentNode.rowIndex;
    //alert(i);
    var qnty = document.getElementById("qnty" + i).value;
    var rate = document.getElementById("rate" + i).value;
    var total = qnty * rate;
    document.getElementById('sub_total' + i).value = parseFloat(total).toFixed(2);
    var gst = document.getElementById("gst" + i).value;
    sumvalue(i);
    if (gst >= 0) {
        changegst(qntyid);
    }
}
;
function changerate(rateid) {
    var i = rateid.parentNode.parentNode.rowIndex;
    var qnty = document.getElementById("qnty" + i).value;
    var rate = document.getElementById("rate" + i).value;
    var total = qnty * rate;
    document.getElementById('sub_total' + i).value = parseFloat(total).toFixed(2);
    var gst = document.getElementById("gst" + i).value;
    if (gst >= 0) {
        changegst(rateid);
    }
}
;
function changegst(gstid) {
    var j = gstid.parentNode.parentNode.rowIndex;
    // alert(j);
    var gst = parseFloat(document.getElementById('gst' + j).value);
    var rate = parseFloat(document.getElementById('sub_total' + j).value);
    var amount = rate + (rate * gst / 100);
    document.getElementById('total' + j).value = parseFloat(amount).toFixed(2);
    count = $('.item_table tr ').length;
    var totalamount = 0;
    for (i = 1; i < count; ++i) {
        var amnt = document.getElementById('total' + i).value;
        if (amnt === "") {
        } else {
            var amt = parseFloat(document.getElementById('total' + i).value);
            totalamount = totalamount + amt;
        }
    }
    document.getElementById("txt_total").value = parseFloat(totalamount).toFixed(2);
}
;
