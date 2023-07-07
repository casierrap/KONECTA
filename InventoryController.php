<?php
    include("connection.php");

    class Inventory {
        
        function getProducts() {
            global $conn;

            $sql = "SELECT * FROM products";
    
            $result = mysqli_query($conn, $sql);
    
            return $result;
            
        }


        function createProduct($name, $reference, $price, $weigth, $category, $stock) {
            global $conn;
            
            $creationDate = date("Y-m-d");
        
            $sql = "INSERT INTO products (id, nombreProducto, referencia, precio, peso, categoria, stock, fechaCreacion) VALUES (null, '$name', '$reference', '$price', '$weigth', '$category', '$stock', '$creationDate')";
            
            if (mysqli_query($conn, $sql)) {
                mysqli_close($conn);
                return true;
            } else {
                mysqli_close($conn);
                return false;
            }
        }


        function getProductById($productId){
            global $conn;

            $sql = "SELECT * FROM products WHERE id = '$productId'";
    
            $result = mysqli_query($conn, $sql);
    
            return $result;
        }


        function editProduct($name, $reference, $price, $weigth, $category, $stock, $productId) {
            global $conn;
            
            $creationDate = date("Y-m-d");
        
            $sql = "UPDATE products SET nombreProducto = '$name', referencia = '$reference', precio = '$price', peso = '$weigth', categoria = '$category', stock = '$stock', fechaCreacion = '$creationDate' WHERE id = '$productId'";
            
            if (mysqli_query($conn, $sql)) {
                mysqli_close($conn);
                return true;
            } else {
                mysqli_close($conn);
                return false;
            }
        }

        function deleteProduct($productId) {
            global $conn;
        
            $sql = "DELETE FROM products WHERE id = '$productId'";
            
            if (mysqli_query($conn, $sql)) {
                mysqli_close($conn);
                return true;
            } else {
                mysqli_close($conn);
                return false;
            }
        }

        function createSale($productId, $stock, $quantity) {
            global $conn;
        
            $sql = "INSERT INTO sales (id, productId, quantity) VALUES (null, '$productId', '$quantity')";
            
            if (mysqli_query($conn, $sql)) {

                $discountStock = ($stock - $quantity);

                $sqlStock = "UPDATE products SET stock = $discountStock WHERE id = $productId";

                if (mysqli_query($conn, $sqlStock)) {
                    mysqli_close($conn);
                    return true;
                } else {
                    mysqli_close($conn);
                    return false;
                }
            } else {
                mysqli_close($conn);
                return false;
            }
        }

        function getSales() {
            global $conn;

            $sql = "SELECT products.nombreProducto, sales.quantity, products.precio FROM sales INNER JOIN products ON products.id = sales.productId";
    
            $result = mysqli_query($conn, $sql);

            mysqli_close($conn);
    
            return $result;
            
        }
    }
?>