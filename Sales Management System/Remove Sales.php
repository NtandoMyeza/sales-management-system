<?php
include 'Database Connection.php';

?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; background-color: #f5f5f5; }
.container { max-width: 600px; margin: 0 auto; }
.form-section { background: white; padding: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
input { display: block; margin: 10px 0; padding: 8px; width: 100%; box-sizing: border-box; }
button { background-color: #dc3545; color: white; padding: 10px 20px; border: none; border-radius: 3px; cursor: pointer; }
button:hover { background-color: #c82333; }
.alert { padding: 15px; border-radius: 3px; margin: 10px 0; }
.success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
.error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
h1 { color: #333; }
</style>

<div class="container">
<h1>🗑️ Remove Sales Record</h1>
<div class="form-section">
<?php

if (isset($_POST['delete_sales'])) {
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = (int)$_POST['id'];
        $stmt = $conn->prepare("DELETE FROM sales WHERE sale_id=?");
        $stmt->bind_param("i", $id);
        
        if($stmt->execute()){
            echo "<div class='alert success'>✓ Sales Record (ID: $id) Deleted Successfully</div>";
        } else {
            echo "<div class='alert error'>✗ Error deleting record: " . $stmt->error . "</div>";
        }
        $stmt->close();
    } else {
        echo "<div class='alert error'>✗ Please enter a valid Sales ID</div>";
    }
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $conn->prepare("DELETE FROM sales WHERE sale_id=?");
    $stmt->bind_param("i", $id);
    
    if($stmt->execute()){
        echo "<div class='alert success'>✓ Sales Record (ID: $id) Deleted Successfully</div>";
    } else {
        echo "<div class='alert error'>✗ Error deleting record</div>";
    }
    $stmt->close();
}
?>
</div>
</div>