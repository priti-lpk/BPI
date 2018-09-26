<?php
include './shreeLib/session_info.php';
include_once './shreeLib/dbconn.php';
?>
<html lang="en" class="no-js">    
    <head>        
        <title>View Item Stock</title>    
        <script type="text/javascript">
            function printlayer(layer)
            {
                var generator = window.open(",'name,");
                var layetext = document.getElementById(layer);
                generator.document.write(layetext.innerHTML.replace("print Me"));
                generator.document.close();
                generator.print();
                generator.close();
            }
        </script>
    </head>    
    <body class="form-val topnav-fixed ">        
        <!-- WRAPPER -->        
        <div id="wrapper" class="wrapper">           
            <?php include './topbar.php'; ?>            
            <?php //include './sidebar.php'; ?>           

            <!-- content-wrapper -->            
            <div id="main-content-wrapper" class="content-wrapper ">               

                <div class="main-content" id="div-id-name">                        
                    <div class="row">                                                                    
                        <div class="col-md-12">                                
                            <div class="widget widget-table">                                    

                                <div class="widget-content">                                        
                                    <div class="table-responsive">                                            
                                        <table border="1" width="750px" id="datatable-data-export" class="table table-sorting table-striped table-hover table-bordered datatable">                                                
                                            <thead>                                                
                                            <th>Item ID</th>                                                   
                                            <th>Item Code</th>                                                
                                            <th>Item Name</th>                                                
                                            <th>Unit Name</th>                                                                                                  
                                            <th>Item Opening Stock</th>                                                  
                                            <th>Qty.</th>                                                
                                            </tr>                                                
                                            </thead>                                                
                                            <tbody id="print_list">
                                                <?php
                                                include_once 'shreeLib/DBAdapter.php';
                                                $dba = new DBAdapter();
                                                $field = array("item_list.id,item_list.item_code,item_list.item_name,unit_list.unit_name,item_list.item_opstock,item_stock.qnty");
                                                $data = $dba->getRow("item_list INNER JOIN unit_list ON item_list.item_unit_id=unit_list.id INNER JOIN item_stock ON item_list.id=item_stock.id", $field, "1");
                                                foreach ($data as $subData) {
                                                    echo "<tr>";
                                                    echo "<td>" . $subData[0] . "</td>";
                                                    echo "<td>" . $subData[1] . "</td>";
                                                    echo "<td>" . $subData[2] . "</td>";
                                                    echo "<td>" . $subData[3] . "</td>";
                                                    echo "<td>" . $subData[4] . "</td>";
                                                    echo "<td>" . $subData[5] . "</td>";

                                                    echo '</tr>';
                                                }
                                                ?>   
                                            </tbody>                                            
                                        </table>    

                                    </div>                                    
                                </div>                                
                            </div>                            
                        </div>                        
                    </div>                    
                </div>                    
                <button id="print" onclick="javascript:printlayer('div-id-name')">Print</button>

                <!-- /main-content -->                
            </div>                           
        </div>          
        <!--        </div>      -->
        <?php //include './footer.php';?>          
        <script src="customFile/getPrint.js" ></script>          
        <script>
                                            $(document).ready(function () {
                                                getPrint();
                                            });
        </script>            
    </body>
</html>

