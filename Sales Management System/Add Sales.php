<?php
include 'Database Connection.php';

if(isset($_POST['submit'])){
    $product = $conn->real_escape_string($_POST['product']);
    $quantity = (int)$_POST['quantity'];
    $price = (float)$_POST['price'];
    $date = $_POST['date'];

    $sql = "INSERT INTO sales(product_name,quantity,price,sale_date)
            VALUES('$product','$quantity','$price','$date')";

    if($conn->query($sql)){
        $generated_id = $conn->insert_id;
        echo "<p style='color:green; font-weight:bold;'>✓ Sale Added Successfully with Sales ID: " . $generated_id . "</p>";
    } else {
        echo "<p style='color:red;'>Error adding sale: " . $conn->error . "</p>";
    }
}
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
form { background: white; padding: 20px; border-radius: 5px; max-width: 400px; }
input { display: block; margin: 10px 0; padding: 8px; width: 100%; box-sizing: border-box; }
button { background-color: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 3px; cursor: pointer; }
button:hover { background-color: #0056b3; }
</style>

<form method="post">
<h2>Add New Sale</h2>
Product: <input name="product" required><br>
Quantity: <input name="quantity" type="number" required><br>
Price: <input name="price" type="number" step="0.01" required><br>
Date: <input type="date" name="date" required><br>
<button name="submit">Add Sale (Auto-Generate Sales ID)</button>
</form>