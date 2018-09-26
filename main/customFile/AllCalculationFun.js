function addrow() {
    var i = $('.item_table tr ').length;
    var my_object = "item_code=" + i;
    $.ajax({
        url: 'getItemCode.php',
        dataType: "html",
        data: my_object,
        success: function (data1) {
            count = $('.item_table tr ').length;
            var data = "<tr><td><input type='checkbox' class='case'/></td><td><span id='snum" + i + "'>" + count + ".</span></td>";
            data += "<td>" + data1 + "</td><td><input type='text' id='item_name" + i + "' class='itemname' name='item_name[]' required/></td> <td><input type='text' id='unit" + i + "' class='unit1' name='unit[]' required/></td><td><input type='text' id='qnty" + i + "' class='qnty1' name='item_qnty[]' onchange='changeQnty(this);' required/></td><td><input type='text' id='rate" + i + "' class='rate1' name='item_rate[]' onkeyup='changerate(" + i + ");' required/></td><td><input type='text' id='sub_total" + i + "' class='subtotal' name='sub_total[]' required/></td><td><input type='text' id='gst" + i + "' class='gst1' name='gst[]' value='0.0' onkeyup='changegst(" + i + ");' required/></td><td><input type='text' id='total" + i + "' class='total1' name='total[]' required/></td></tr>";
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
    var value = $("#item_code" + rowid).find(":selected").val();

    var dataString = 'id=' + value;

    $.ajax({
        url: 'suggestvalue.php',
        dataType: "html",
        data: dataString,
        cache: false,
        success: function (Data) {
            // alert(Data);
            var data = Data.split(",");
            $('#item_name' + rowid).val(data[0]);
            $('#unit' + rowid).val(data[1]);
            $('#rate' + rowid).val(data[2]);
        },
        error: function (errorThrown) {
            alert(errorThrown);
            alert("There is an error with AJAX!");
        }
    });
}
;
function changeQnty(qntyid) {
    var qnty = document.getElementById("qnty" + qntyid).value;
    var rate = document.getElementById("rate" + qntyid).value;
    var total = qnty * rate;
    document.getElementById('sub_total' + qntyid).value = parseFloat(total).toFixed(2);
    var gst = document.getElementById("gst" + qntyid).value;
    if (gst >= 0) {
        changegst(qntyid);
    }
}
;
function changerate(rateid) {
    var qnty = document.getElementById("qnty" + rateid).value;
    var rate = document.getElementById("rate" + rateid).value;
    var total = qnty * rate;
    document.getElementById('sub_total' + rateid).value = parseFloat(total).toFixed(2);
    var gst = document.getElementById("gst" + rateid).value;
    if (gst >= 0) {
        changegst(rateid);
    }
}
;
function changegst(gstid) {

    var gst = parseFloat(document.getElementById('gst' + gstid).value);
    var rate = parseFloat(document.getElementById('sub_total' + gstid).value);
    var amount = rate + (rate * gst / 100);
    document.getElementById('total' + gstid).value = parseFloat(amount).toFixed(2);
    count = $('.item_table tr ').length;
    var totalamount = 0;
    for (i = 1; i < count; ++i) {
        var amnt = document.getElementById('total' + i).value;
        if (amnt == "") {
        } else {
            var amt = parseFloat(document.getElementById('total' + i).value);
            totalamount = totalamount + amt;
        }
    }
    document.getElementById("txt_total").value = parseFloat(totalamount).toFixed(2);
}
;
