<link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+39+Extended+Text&display=swap" rel="stylesheet">
<?php
error_reporting(0);
require_once('../assets/constants/config.php');
require_once('../assets/constants/check-login.php');
require_once('../assets/constants/fetch-my-info.php');

?>




<?php include('include/head.php');?>
            <?php include('include/header.php');?>


                                   <?php include('include/sidebar.php');?>
  <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
<style>
 .barcode39 {
  font-family: 'Libre Barcode 39 Extended Text', cursive;
  font-size: 40px;
}
</style>
        <div class="dashboard-wrapper">
            <div class="container-fluid  dashboard-content">
               
                 <div class="row">
                    
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="table table-striped table-bordered second" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>SR No</th>
                                                <th>Product Name</th>
                                                <th>Product Image</th>
                                                <th>Barcode</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
<?php 
  $sql = "SELECT * FROM tbl_product where delete_status='0' order by id desc";
 
                
 $statement = $conn->prepare($sql);
 $statement->execute();
                                                             
                                                                
     while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
 
        extract($row);
                                                                 
 //print_r($row);exit;
        $no +=1;
                                                            ?>
                                            <tr>
                                                <td>1</td>
                                                <td><?php echo $row['name'];?></td>
                                                <td><img src="../assets/uploadImage/Candidate/<?php echo $row['image']?>" width="80px"></td>
                                                <!-- <td><img src="https://img.freepik.com/premium-photo/dslr-camera-white_144962-4376.jpg" width="80px"></td>
                                                <td><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e9/UPC-A-036000291452.svg/1200px-UPC-A-036000291452.svg.png" width="100px"></td> -->
                                                <?php 
$stmt4 = $conn->prepare("SELECT barcode FROM tbl_barcode WHERE barcode = :product_id ");
$stmt4->bindParam(':product_id', $row['pid']);
$stmt4->execute();
$barcodes = $stmt4->fetchAll(PDO::FETCH_ASSOC);
?>
                                    <td>
    <?php foreach ($barcodes as $barcode): ?>
        <span class="barcode39">
            <?php echo $barcode['barcode']; ?>
        </span>
    <?php endforeach; ?>
</td>
                                            
                                      <?php ?>
                                            

                                          <td>                              
<a href="operation/product.php?id=<?= $row['id']; ?>">
    <button type="button" class="btn btn-danger cancel-button" id="<?= $row['id']; ?>">
        <i class="fas fa-trash"></i>
    </button>
</a>
<a href="update_product.php?id=<?= $row['id']; ?>" class="btn btn-info" title="Edit Event">
    <i class="fas fa-edit"></i>
</a>
   
                                                                        </td>
                                                
                                            </tr>
                                     <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                               <th>SR No</th>
                                                <th>Product Name</th>
                                                <th>Purchase Cost</th>
                                                <th>Barcode</th>
                                                <th>Action</th>
                                           </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                 </div>
            
                       <?php include('include/footer.php');?>

        </div>
    </div>
    
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
 
