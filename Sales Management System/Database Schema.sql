CREATE DATABASE sales_reporting;

USE sales_reporting;

CREATE TABLE sales (
    sale_id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(100),
    quantity INT,
    price DECIMAL(10,2),
    sale_date DATE
);

INSERT INTO sales (product_name, quantity, price, sale_date)
VALUES ('Laptop', 2, 15000, '2026-02-10');

SELECT * FROM sales;

SELECT SUM(quantity * price) AS total_sales FROM sales;

SELECT product_name, SUM(quantity) AS total_quantity
FROM sales
GROUP BY product_name
ORDER BY total_quantity DESC
LIMIT 1;

SELECT MONTH(sale_date) AS month, SUM(quantity * price) AS monthly_total
FROM sales
GROUP BY MONTH(sale_date);