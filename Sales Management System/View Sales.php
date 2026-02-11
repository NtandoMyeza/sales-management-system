<?php
include 'Database Connection.php';

$result = $conn->query("SELECT * FROM sales ORDER BY sale_id DESC");
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; background-color: #f5f5f5; }
table { width: 100%; border-collapse: collapse; background: white; }
table, th, td { border: 1px solid #ddd; }
th { background-color: #007bff; color: white; padding: 12px; text-align: left; }
td { padding: 10px; }
tr:hover { background-color: #f9f9f9; }
h1 { color: #333; }
</style>

<h1>📋 All Sales Records</h1>

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
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p style='color: #666;'>No sales records found.</p>";
}
$conn->close();
?>