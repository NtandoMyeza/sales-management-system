<?php
include 'Database Connection.php';

if(isset($_POST['add_sale'])){
    $product = $conn->real_escape_string($_POST['product']);
    $quantity = (int)$_POST['quantity'];
    $price = (float)$_POST['price'];
    $date = $_POST['date'];

    $sql = "INSERT INTO sales(product_name,quantity,price,sale_date)
            VALUES('$product','$quantity','$price','$date')";

    if($conn->query($sql)){
        $generated_id = $conn->insert_id;
        echo "<div style='color:green; font-weight:bold; margin:10px;'>Sale Added Successfully with Sales ID: " . $generated_id . "</div>";
    } else {
        echo "<div style='color:red; margin:10px;'>Error adding sale: " . $conn->error . "</div>";
    }
}

if(isset($_GET['delete_id'])){
    $id = (int)$_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM sales WHERE sale_id=?");
    $stmt->bind_param("i", $id);
    if($stmt->execute()){
        echo "<div style='color:green; margin:10px;'>Sales Record (ID: $id) Deleted Successfully</div>";
    } else {
        echo "<div style='color:red; margin:10px;'>Error deleting record</div>";
    }
    $stmt->close();
}


$result = $conn->query("SELECT * FROM sales ORDER BY sale_id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sales Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .section {
            background: white;
            padding: 20px;
            margin: 15px 0;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        h2 {
            color: #444;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        form {
            display: grid;
            gap: 10px;
        }
        input, button {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 3px;
            font-size: 14px;
        }
        button {
            background-color: #007bff;
            color: white;
            cursor: pointer;
            border: none;
        }
        button:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
            padding: 12px;
            text-align: left;
        }
        td {
            padding: 10px;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
        .delete-btn {
            background-color: #dc3545;
            padding: 5px 10px;
            text-decoration: none;
            color: white;
            border-radius: 3px;
            cursor: pointer;
        }
        .delete-btn:hover {
            background-color: #c82333;
        }
        input[type="date"], input[type="text"], input[type="number"] {
            max-width: 300px;
        }
        .alert {
            padding: 10px;
            margin: 10px 0;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1> Sales Management System </h1>

        <div class="section">
            <h2>Add New Sale</h2>
            <form method="post">
                <input type="text" name="product" placeholder="Product Name" required>
                <input type="number" name="quantity" placeholder="Quantity" required>
                <input type="number" step="0.01" name="price" placeholder="Price" required>
                <input type="date" name="date" required>
                <button type="submit" name="add_sale"> Add Sale </button>
            </form>
        </div>

        <div class="section">
            <h2> Sales Records </h2>
            <?php
            if($result && $result->num_rows > 0){
                echo "<table>";
                echo "<tr>
                        <th>Sales ID</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Sale Date</th>
                        <th>Total Amount</th>
                        <th>Action</th>
                      </tr>";
                
                while($row = $result->fetch_assoc()){
                    $total = $row['quantity'] * $row['price'];
                    echo "<tr>
                            <td><strong>" . $row['sale_id'] . "</strong></td>
                            <td>" . htmlspecialchars($row['product_name']) . "</td>
                            <td>" . $row['quantity'] . "</td>
                            <td>R" . number_format($row['price'], 2) . "</td>
                            <td>" . $row['sale_date'] . "</td>
                            <td>R" . number_format($total, 2) . "</td>
                            <td><a class='delete-btn' onclick='return confirm(\"Are you sure?\");' href='?delete_id=" . $row['sale_id'] . "'>Delete</a></td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "<p style='color: #666;'>No sales records found.</p>";
            }
            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>