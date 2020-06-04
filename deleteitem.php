<!DOCTYPE html>
<html lang="en">    
    <head>
        <script type="text/javascript">
            function delete (inquiry_id) {
                var values = document.querySelector('.case:checked').value;
                var id = document.getElementById('i_id' + values).value;
                var my_object = {"i_list_id": id, "inquiry_id": inquiry_id};
                $.ajax({
                    url: 'Delete.php',
                    dataType: "html",
                    data: my_object,
                    cache: false,
                    success: function (Data) {
                        $('.case:checkbox:checked').parents("tr").remove();
                        var rowcount = <?php echo (isset($_GET['type']) && isset($_GET['id']) ? $countrow[0][0] : '0') ?>;
                        document.getElementById("row_count").value = rowcount - 1;
                    },
                    error: function (errorThrown) {
                        alert(errorThrown);
                        alert("There is an error with AJAX!");
                    }
                });
            }
            ;
        </script>
    </head>
</html>
