function addParty() {
//alert("js fiole");
    $.ajax({
        type: "POST",
        url: "customFile/createpartyPro.php",
        enctype: 'multipart/form-data',
        data: {
            party_name: $("#party_name").val(),
            party_contact: $("#party_contact").val(),
            party_email: $("#party_email").val(),
            party_address: $("#party_address").val(),
            country_id: $("#countries").val(),
            city_id: $("#cities").val(),
            action: "add"
        }
        ,
        dataType: "json",
        success: function (data) {
            //console.log(data);
            getparty();
            $('#addparty').modal('toggle');
            if (data.status) {
                swal("Success!", data.msg, "success");
            } else {
                swal("Error!", data.msg, "error");
            }
            $('#addparty').find('input:text').val('');
            $('input:checkbox').removeAttr('checked');
        },
        fail: function () {
            $('#addparty').modal('toggle');
            swal("Error!", "Error while performing operation!", "error");
        },

        error: function (data, status, jq) {
            console.log(data);
            console.log(data.status);

            $('#addparty').modal('toggle');
            swal("Error!", data.responseText, "error");
        }
    });

}

