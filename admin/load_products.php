<?php
require_once('../assets/constants/config.php');

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$groupId = $_POST['groupId'];

// Fetch products based on the selected product group
$stmt = $conn->prepare("SELECT * FROM tbl_product WHERE delete_status='0' AND group_id = :groupId");
$stmt->bindParam(':groupId', $groupId, PDO::PARAM_INT);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
    <div class="box a col-md-3 text-center">
        <div class="card mb-1">
            <div class="card-body p-1">
                <img src="../assets/uploadImage/Candidate/<?php echo $row['image']; ?>" width="100%">
            </div>
        </div>
        <p><?php echo $row['name']; ?></p>
    </div>
    <?php
}
?>
