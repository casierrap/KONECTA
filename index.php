<?php
    include("InventoryController.php");

    $nameProduct = "";
    $referenceProduct = "";
    $priceProduct = "";
    $weigthProduct = "";
    $categoryProduct = "";
    $stockProduct = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST" && !isset($_GET['productId'])) {

        $inventory = new Inventory();
        
        $name = $_POST["producto"];
        $reference = $_POST["referencia"];
        $price = $_POST["precio"];
        $weigth = $_POST["peso"];
        $category = $_POST["categoria"];
        $stock = $_POST["stock"];


        if ($name === "" || $reference === "" || $price === "" || $weigth === "" || $category === "" || $stock === "") {
            echo '<script type="text/javascript">';
            echo 'alert("Debe completar todos los campos");';
            echo '</script>';
        } else {
            if ($inventory->createProduct($name, $reference, $price, $weigth, $category, $stock)) {
                header("Location: index.php");
                exit;
            } else {
                echo '<script type="text/javascript">';
                echo 'alert("No se puede crear el producto");';
                echo '</script>';
                header("Location: index.php");
                exit;
            }
        }
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_GET['productId'])) {

        $inventory = new Inventory();
        
        $productId = $_GET['productId'];
        $name = $_POST["producto"];
        $reference = $_POST["referencia"];
        $price = $_POST["precio"];
        $weigth = $_POST["peso"];
        $category = $_POST["categoria"];
        $stock = $_POST["stock"];


        if ($name === "" || $reference === "" || $price === "" || $weigth === "" || $category === "" || $stock === "") {
            echo '<script type="text/javascript">';
            echo 'alert("Debe completar todos los campos");';
            echo '</script>';
        } else {
            if ($inventory->editProduct($name, $reference, $price, $weigth, $category, $stock, $productId)) {
                header("Location: index.php");
                exit;
            } else {
                echo '<script type="text/javascript">';
                echo 'alert("No se puede editar el producto");';
                echo '</script>';
                header("Location: index.php");
                exit;
            }
        }
    }


    if(isset($_GET['productId'])) {

        $inventory = new Inventory();

        $productId = $_GET['productId'];

        $productData = $inventory->getProductById($productId);

        if($productData) {

            while ($row = mysqli_fetch_assoc($productData)) {

                $nameProduct = $row["nombreProducto"];
                $referenceProduct = $row["referencia"];
                $priceProduct = $row["precio"];
                $weigthProduct = $row["peso"];
                $categoryProduct = $row["categoria"];
                $stockProduct = $row["stock"];
            }
        }
    }

    if (isset($_GET['action']) && $_GET['action'] === 'delete') {
        if (isset($_GET['productId'])) {
            $productId = $_GET['productId'];
            
            if ($inventory->deleteProduct($productId)) {
                header("Location: index.php");
                exit;
            } else {
                echo '<script type="text/javascript">';
                echo 'alert("No se puede eliminar el producto");';
                echo '</script>';
                header("Location: index.php");
                exit;
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
    <title>Konecta</title>
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="#"><strong>Crear producto</strong></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="sales.php"><strong>Ventas</strong></a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container-title">
            <h1>Inventario</h1>
        </div>
        <div class="formkonecta">
            <form method="POST">
                <div class="formkonecta-input">
                    <label for="producto">Nombre del producto</label>
                    <input class="control" type="text" id="producto" name="producto" value="<?php echo $nameProduct ?>" /> 
                </div>
                <div class="formkonecta-input">
                    <label for="referencia">Referencia</label>
                    <input class="control" type="text" id="referencia" name="referencia" value="<?php echo $referenceProduct ?>" /> 
                </div>
                <div class="formkonecta-input">
                    <label for="precio">Precio</label>
                    <input  class="control" type="text" id="precio" name="precio" value="<?php echo $priceProduct ?>" />
                </div>
                <div class="formkonecta-input">
                    <label for="peso">Peso</label>
                    <input class="control" type="text" id="peso" name="peso" value="<?php echo $weigthProduct ?>" />
                </div>
                <div class="formkonecta-input">
                    <label for="categoria">Categoria</label>
                    <input class="control" type="text" id="categoria" name="categoria" value="<?php echo $categoryProduct ?>" />
                </div>
                <div class="formkonecta-input">
                    <label for="stock">Stock</label>
                    <input class="control" type="text" id="stock" name="stock" value="<?php echo $stockProduct ?>" />
                </div>
                <div class="formkonecta-button">
                    <?php
                        if(isset($_GET['productId'])) {
                    ?> 
                            <button type="submit" class="btn btn-warning">Editar producto</button> 
                    <?php
                        } else {
                    ?>
                            <button type="submit" class="btn btn-success">Crear producto</button>
                    <?php
                        }
                    ?>
                </div>
            </form>
        </div>
        <div class="formkonecta-table">
            <table class="table table-responsive table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Nombre del Producto</th>
                        <th scope="col">Referencia</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Peso</th>
                        <th>Categoria</th>
                        <th>Stock</th>
                        <th>Acciones</th>
                    </tr> 
                </thead>
                <tbody>
                    <?php
                        $data = new Inventory;
                        $result = $data->getProducts();

                        if($result) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                
                                ?>
                                    <tr>
                                        <td><?php echo $row["nombreProducto"] ?></td>
                                        <td><?php echo $row["referencia"] ?></td>
                                        <td><?php echo $row["precio"] ?></td>
                                        <td><?php echo $row["peso"] ?></td>
                                        <td><?php echo $row["categoria"] ?></td>
                                        <td><?php echo $row["stock"] ?></td>
                                        <td>
                                            <a href="index.php?productId=<?php echo $row["id"] ?>"><button class="btn btn-warning">Editar</button></a>
                                            <a href="index.php?productId=<?php echo $row["id"] ?>&action=delete" onclick="return confirm('¿Está seguro que desea eliminar este producto?')">
                                                <button class="btn btn-danger">Eliminar</button>
                                            </a>

                                        </td>
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