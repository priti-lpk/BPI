function deleterow(inquiry_id)
{
    var values = document.querySelector('.case:checked').value;
    var rowattri = document.getElementById('row' + values).getAttribute('data');
    var n = 1;
    var count = $('#view_data1 tr ').length;

    for (var i = 1; i <= count; ++i) {

        var snumber = document.getElementById('snum' + i);
        var cb = document.getElementById('check' + i);
        var iqnty = document.getElementById('qnty' + i);
        var icode = document.getElementById('item_code' + i);
        var iunit = document.getElementById('unit' + i);
        var rowid = document.getElementById('row' + i);

        if (cb.checked) {
            if (rowattri === 'no') {
                $('.case:checkbox:checked').parents("tr").remove();
            } else {
                delete(inquiry_id);
            }
        } else {
            snumber.id = 'snum' + n;
            snumber.value = n;
            cb.id = 'check' + n;
            cb.value = n;
            icode.id = 'item_code' + n;
            iqnty.id = 'qnty' + n;
            iunit.id = 'unit' + n;
            rowid.id = 'row' + n;
            n++;
        }
    }
}
;