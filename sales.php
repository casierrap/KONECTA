<?php
    include("InventoryController.php");

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $inventory = new Inventory();
        
        $productId = $_POST["producto"];
        $quantity = $_POST["cantidad"];

        if ($productId === "" || $quantity === "") {
            echo '<script type="text/javascript">';
            echo 'alert("Debe completar todos los campos");';
            echo '</script>';
        } else {
            $splitProduct = explode("-", $productId);

            if ($splitProduct[1] <= 0) {
                echo '<script type="text/javascript">';
                echo 'alert("No se puede hacer la venta porque no hay stock disponible");';
                echo '</script>';
            } else {
                if ($inventory->createSale($splitProduct[0], $splitProduct[1], $quantity)) {
                    header("Location: sales.php");
                    exit;
                } else {
                    echo '<script type="text/javascript">';
                    echo 'alert("No se puede crear la venta");';
                    echo '</script>';
                    header("Location: sales.php");
                    exit;
                }
            }
        }
    }
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="estilos.css">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <title>Ventas</title>
    </head>
    <body>
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link" href="index.php"><strong>Crear producto</strong></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="sales.php"><strong>Ventas</strong></a>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="container-title">
                <h1>Venta producto</h1>
            </div>
            <div class="formkonecta">
                <form method="POST">
                    <div class="formkonecta-input">
                        <label for="producto">Producto</label>
                        <select class="control" name="producto" id="producto">
                            <?php
                                $data = new Inventory;
                                $result = $data->getProducts();

                                if($result) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        ?>
                                            <option value="<?php echo $row["id"]."-".$row["stock"] ?>"><?php echo $row["nombreProducto"] ?></option>
                                        <?php
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="formkonecta-input">
                        <label for="cantidad">Cantidad</label>
                        <input  class="control" type="text" id="cantidad" name="cantidad" />
                    </div>
                    <div class="formkonecta-button">
                        <button type="submit" class="btn btn-success">Crear Venta</button> 
                    </div>
                </form>
            </div>
            <div class="formkonecta-table">
                <table class="table table-responsive table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Producto</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Precio Unitario</th>
                            <th scope="col">Precio Total</th>
                        </tr> 
                    </thead>
                    <tbody>
                        <?php
                            $dataSales = new Inventory;
                            $resultSales = $dataSales->getSales();

                            if($resultSales) {

                                while ($rowSale = mysqli_fetch_assoc($resultSales)) {
                                    
                                    ?>
                                        <tr>
                                            <td><?php echo $rowSale["nombreProducto"] ?></td>
                                            <td><?php echo $rowSale["quantity"] ?></td>
                                            <td><?php echo $rowSale["precio"] ?></td>
                                            <td><?php echo ($rowSale["precio"] * $rowSale["quantity"]) ?></td>
                                        </tr>
                                    <?php
                                }

                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>