<?php
error_reporting(0);
require_once('../assets/constants/config.php');
require_once('../assets/constants/check-login.php');
require_once('../assets/constants/fetch-my-info.php');

?>




<?php include('include/head.php'); ?>
<?php include('include/header.php'); ?>


<?php include('include/sidebar.php'); ?>

<!-- ============================================================== -->
<!-- end left sidebar -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- wrapper  -->
<!-- ============================================================== -->
<div class="dashboard-wrapper">
    <div class="container-fluid  dashboard-content">
        <!-- ============================================================== -->
        <!-- pageheader -->
        <!-- ============================================================== -->
        <!--  <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <h2 class="pageheader-title">Data Tables</h2>
                            <p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit amet vestibulum mi. Morbi lobortis pulvinar quam.</p>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Tables</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Data Tables</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                --> <!-- ============================================================== -->
        <!-- end pageheader -->
        <!-- ============================================================== -->
        <div class="row">
            <!-- ============================================================== -->
            <!-- data table  -->
            <!-- ============================================================== -->
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Profit Per Product/Service </h4>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="form-row">
                                
                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mb-2">
                                    <label for="validationCustom03">Product/Service</label>

                                    <select name="product_id" class="form-control select2" id="product_id">
                                        <option value="">--Select--</option>
                                        <?php
                                        if($_SESSION['id']==1){
                                        $sql = "SELECT * FROM tbl_product where delete_status='0'  order by id desc";

                                        }else{
                                             $sql = "SELECT * FROM tbl_product where delete_status='0' and user_id='".$_SESSION['id']."' order by id desc";
                                        }
                                        $statement = $conn->prepare($sql);
                                        $statement->execute();


                                        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                            <option value="<?php echo $row['id']; ?>" <?php echo (isset($_POST['product_id']) && $_POST['product_id'] == $row['id']) ? 'selected' : '';  ?>><?php echo $row['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="invalid-feedback">
                                    </div>
                                </div>
                            

                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                                        <label for="validationCustomUsername"></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                            </div>

                                            <button class="btn btn-primary" type="submit" name="search">Search</button>
                                        </div>
                                    </div>
                                

                            </div>


                            <!-- <br>
                                        <center>
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                                <button class="btn btn-primary" type="submit" name="btn_save">Submit</button>
                                            </div>
                                          </center>
                                   -->
                        </form>
                        <br />
                        <br />

                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered second" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>SR No</th>
                                           <th>Invoice<br>Number</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Purchase Price</th>
                                        <th>Selling Price</th>
                                        <th>No Of Unit Sold</th>
                                        <th>Total Revenue</th>
                                        <th>Profit</th>


                                    </tr>
                                </thead>
                                <tbody>

                                    <?php

                                    ?>
                                    <?php
                                    if (isset($_POST['search'])) {
                                         $ftot=0;
                                    $fprof=0;
                                        //\ print_r($_POST);
                                        $product_id = $_POST['product_id'];
                                        $p_group_name = $_POST['p_group_name'];

                                        $where = "WHERE delete_status= 0";
                                        
                                        if ($_POST['product_id'] != '') {
                                            $where .= " AND product_id ='" . $product_id . "'";
                                        }
                                     
                                     
                                        $sql = "SELECT product_id,inv_id, SUM(rate) as total_sale_price,SUM(quantity) as total_qty FROM tbl_quot_inv_items " . $where . " group  by product_id";
                                        // print_r($sql);
                                    } else {
                                       
                                        $sql = "SELECT product_id,inv_id,SUM(rate) as total_sale_price,SUM(quantity) as total_qty  FROM tbl_quot_inv_items where delete_status=0 group  by product_id";
                                    }

                                    $statement = $conn->prepare($sql);
                                    // print_r($statement);
                                    $statement->execute();
// $item = $statement->fetchAll();
// print_r($item);

                                    while ($item = $statement->fetch(PDO::FETCH_ASSOC)) {

                                        $sql1 = "SELECT * FROM tbl_product where id='" . $item['product_id'] . "   '";


                                        $statement1 = $conn->prepare($sql1);
                                        $statement1->execute();
                                        $row1 = $statement1->fetch(PDO::FETCH_ASSOC);
                                        
                                        
                                        
                                        
                                        $sql7 = "SELECT * FROM tbl_product_grp where id='" . $row1['group_id'] . "'";


                                        $statement7 = $conn->prepare($sql7);
                                        $statement7->execute();
                                        $row7 = $statement7->fetch(PDO::FETCH_ASSOC);



                                        $no += 1;
                                    ?>

                                        <tr>
                                            <td><?= $no; ?></td>
                                              <td><?= $item['inv_id']; ?></td>
                                            <td><?= $row1['name']; ?></td>
                                            <td><?= $row7['name']; ?></td>
                                            <td><?php echo $record_website['currency_symbol'] . number_format1($row1['purchase_gst'], 2, '.', ','); ?>-/</td>
                                         <td><?php echo $record_website['currency_symbol'] . number_format1($row1['selling_gst'], 2, '.', ','); ?>-/</td>
                                            <td><?= $item['total_qty']; ?></td>
                                            <td><?php echo $record_website['currency_symbol'];?><?= number_format1(($tot=$row1['selling_gst'] * $item['total_qty']),2); ?>-/</td>
                                            
                                      <?php
    $purchase_gst = (float)$row1['purchase_gst'];
    $total_qty = (int)$item['total_qty'];
    $prop = $purchase_gst * $total_qty;
    $selling_gst = (float)$row1['selling_gst'] ;
    $sell =$selling_gst*$total_qty;
    $total_pro= $sell-$prop ;
    // print_r($total_pro);
    // echo "Purchase GST: $purchase_gst<br>";
    // echo "Total Qty: $total_qty<br>";
    // echo "Total Purchase Cost: $prop<br>";
?>
                                            <td><?php echo $record_website['currency_symbol'];?><?= number_format($total_pro,2); ?>-/</td>
                                        </tr>
                                    <?php 
                                    
                                    $ftot+=$tot;
                                    $fprof+=$prof;
                                    
                                    } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                         <th></th>
                                        <th>Total</th>
                                      <th><?php echo $record_website['currency_symbol'] . number_format1($ftot, 2, '.', ','); ?>-/</th>
<th><?php echo $record_website['currency_symbol'] . number_format1($fprof, 2, '.', ','); ?>-/</th>



                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end data table  -->
            <!-- ============================================================== -->
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- footer -->
    <!-- ============================================================== -->
    <?php include('include/footer.php'); ?>
    <!-- ============================================================== -->
    <!-- end footer -->
    <!-- ============================================================== -->
</div>
</div>
<!-- ============================================================== -->
<!-- end main wrapper -->
<!-- ============================================================== -->
<!-- Optional JavaScript -->

<script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
<script src="assets/vendor/slimscroll/jquery.slimscroll.js"></script>
<script src="assets/vendor/multi-select/js/jquery.multi-select.js"></script>
<script src="assets/libs/js/main-js.js"></script>
<script src="assets/libs/js/jquery.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="assets/vendor/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="assets/vendor/datatables/js/buttons.bootstrap4.min.js"></script>
<script src="assets/vendor/datatables/js/data-table.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/rowgroup/1.0.4/js/dataTables.rowGroup.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>

<script>
    $('form').on("change", 'select[name^="p_group_name"]', function(event) {
        var group_id = $(this).val();
        $('#product_id').html('<option value="" >Select one </option>');
        $.ajax({
            type: "POST",
            dataType: "json",
            url: 'search_product.php',
            data: {
                group_id: group_id
            },
            success: function(data) {
                for (var i = 0; i < data['products'].length; i++) {
                    var p_id = data['products'][i][0];
                    var p_name = data['products'][i][2];
                    $('#product_id').append('<option value="' + p_id + '" > ' + p_name + '</option>');
                }
            }
        });
    });
</script>

</body>

</html>