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
   <?php if (in_array('Add Product/Service',$userroles) || ($admin['role_id']==0))
                         { ?>  
                        <a href="product.php"><button class="btn btn-primary" type="submit" title="Add Product/Service"> Add Product/Service</button></a>
                        <?php } ?>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered second" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>SR No</th>
                                          <th>Type</th>
                                        <th>Name</th>
                                         <th>Total Stock</th>
                                        <th>Price</th>
                               
                                     
                                        <?php if (in_array('Delete Product/Service', $userroles) || ($admin['role_id'] == 0) || in_array('Edit Product/Service', $userroles)|| in_array('Add Product Stock', $userroles)|| in_array('View Barcode', $userroles)) { ?> 
                                        <th>Action</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>


                                    <?php
                                    
                                     
                              
                                    $sql = "SELECT * FROM tbl_product where delete_status='0' order by id desc";
                               

                                    $statement = $conn->prepare($sql);
                                    $statement->execute();
$row14 = $statement->fetchAll();

                                 foreach($row14 as $row){

                                        extract($row);
                                        $no += 1;
                                    ?>

                                        <tr>
                                            <td><?= $no; ?></td>
                                      
                                             <td>   <?php if($exp=='0')
                                             {
                                                 
                                                 echo 'Product';
                                                 
                                             }else{
                                                      echo 'Service';
                                                     
                                                 } ?></td>
                                            <td><?= $name; ?></td>
                                              <td>
    <?php 
        if ($exp == '1') {
            echo 'No Stock';
        } else {
            echo $openning_stock;
        }
    ?>
</td>
                                           <td><?php echo $record_website['currency_symbol'] . number_format1($unit_price, 2); ?></td>




                                    <?php if (in_array('Delete Product/Service', $userroles) || ($admin['role_id'] == 0) || in_array('Edit Product/Service', $userroles)|| in_array('Add Product Stock', $userroles)|| in_array('View Barcode', $userroles)) { ?> 
                                            <td class="d-flex">

   <?php if (in_array('Delete Product/Service',$userroles) || ($admin['role_id']==0))
                         { ?>  
                                                <a href="#" class="m-1"><button type="button" class="btn btn-danger cancel-button" title="Delete Product/Service" onclick="return confirm('Do you really want to Delete ?') && delForm(event, <?php echo $id; ?>, 'operation/product.php');" id="<?= $id; ?>"><i class="fas fa-trash"></i></button></a>
                                              <?php } ?>


   <?php if (in_array('Edit Product/Service',$userroles) || ($admin['role_id']==0))
                         { ?>  
                                                <a href="#"  onclick="editForm(event, <?php echo $id; ?>, 'update_product.php')" title="Edit Product/Service" class="btn btn-info m-1" title="Edit Event"><i class="fas fa-edit"></i></a>
                                                <?php } ?>

<?php if($exp=='0')

{ ?>                                                 <?php if (in_array('Add Product Stock',$userroles) || ($admin['role_id']==0))
                         { ?>  
                                                    <button class="btn btn-warning m-1" data-toggle="modal" type="submit" title="Add Product Stock" data-target="#exampleModalabcd<?php echo $row['id']; ?>a"><i class="fas fa-plus"></i> </a></button>
                                                <?php
                                                } } ?>
                                                
                                                       <?php if (in_array('View Barcode',$userroles) || ($admin['role_id']==0))
                         { ?>  
                                                    <a href="#"  onclick="editForm(event, <?php echo $id; ?>, 'barcode.php')" title="View Barcode" class="btn btn-secondary m-1" title="Edit Event"><i class="fas fa-eye"></i></a>
                                                <?php
                                                } ?>
                                                
                                                
                                                
                                                

             <!-- plus modal start -->
<div class="modal fade" id="exampleModalabcd<?php echo $row['id']; ?>a" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Stock</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="operation/product.php" method="POST">
            <input type="hidden" class="form-control" name="id" required value="<?php echo $row['id']; ?>">
            <!-- Employee Name -->
            <div class="col-md-12 mb-2 mt-2">
               <input type="text" class="form-control" name="old_stock" value="<?php echo $row['openning_stock']; ?>" readonly="">
            </div>
             <div class="col-md-12 mb-2">
               <input type="text" class="form-control" name="openning_stock" placeholder="Enter a stock"required>
            </div>
            <div class="modal-footer">
               <button type="submit" name="add_stock" class="btn btn-primary">Add</button>
            </div>
         </form>
      </div>
   </div>
</div>
<!-- plus modal end -->

                                            </td>
<?php  } ?>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                       <th>SR No</th>
                                          <th>Type</th>
                                        <th>Name</th>
                                         <th>Total Stock</th>
                                        <th>Price</th>
                               
                                     
                                        <?php if (in_array('Delete Product/Service', $userroles) || ($admin['role_id'] == 0) || in_array('Edit Product/Service', $userroles)|| in_array('Add Product Stock', $userroles)|| in_array('View Barcode', $userroles)) { ?> 
                                        <th>Action</th>
                                        <?php } ?>
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


</body>

<script>
    function editForm(event, id, file) {
        event.preventDefault(); // Prevent the default link behavior

        // Create a form dynamically
        var form = document.createElement('form');
        form.action = file;
        form.method = 'post';

        // Create a hidden input field for the ID
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'id';
        input.value = id;

        // Append the input field to the form
        form.appendChild(input);

        // Append the form to the body and submit it
        document.body.appendChild(form);
        form.submit();
    }
</script>


<script>
    function delForm(event, id, file) {
        event.preventDefault(); // Prevent the default link behavior

        // Create a form dynamically
        var form = document.createElement('form');
        form.action = file;
        form.method = 'post';

        // Create a hidden input field for the ID
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'del_id';
        input.value = id;

        // Append the input field to the form
        form.appendChild(input);

        // Append the form to the body and submit it
        document.body.appendChild(form);
        form.submit();
    }
</script>