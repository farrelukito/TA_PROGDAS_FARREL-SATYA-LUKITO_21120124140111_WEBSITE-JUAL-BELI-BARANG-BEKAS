<?php
require 'db.php';
require 'classes/Product.php';


if (isset($_POST['delete_product_id'])) {
    $productId = $_POST['delete_product_id'];
    
    
    $stmt = $conn->prepare("DELETE FROM products WHERE id = :id");
    $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
    $stmt->execute();
    
    
    header('Location: index.php');
    exit();
}


$products = Product::getAllProducts($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Jual Beli Barang Bekas</title>
    <style>
        
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7f6;
        }

       
        nav {
            background-color: #343a40;
            color: white;
            padding: 10px 20px;
            text-align: center;
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            margin: 0 10px;
            display: inline-block;
        }

        nav a:hover {
            background-color: #555;
            border-radius: 4px;
        }

        
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 15px;
        }

        h1 {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 30px;
            color: #333;
        }

        
        .product-card {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .card-body {
            padding: 20px;
            text-align: center;
        }

        .card-title {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 10px;
        }

        .card-text {
            font-size: 1.25rem;
            color: #007bff;
            margin-bottom: 15px;
        }

        .btn {
            padding: 10px;
            border-radius: 4px;
            font-size: 1rem;
            text-decoration: none;
            display: inline-block;
            width: 45%;
            margin-top: 10px;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        
        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
        }

        .col-md-4 {
            flex: 1 1 calc(33.333% - 20px);
            box-sizing: border-box;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .col-md-4 {
                flex: 1 1 calc(50% - 20px);
            }
        }

        @media (max-width: 480px) {
            .col-md-4 {
                flex: 1 1 100%;
            }

            .btn {
                width: 100%;
            }
        }

        
        .product-image-table {
            width: 100%;
            border: 1px solid #ddd;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .product-image-table th, .product-image-table td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .product-image-table img {
            max-width: 100px;
            height: auto;
            display: block;
            margin: 0 auto;
        }
    </style>
</head>
<body>


<nav>
    <a href="index.php">Beranda</a>
    <a href="cart.php">Keranjang</a>
    <a href="admin.php">Admin</a>
</nav>


<div class="container">
    <h1>Daftar Produk</h1>

   
    <div class="row">
        <?php foreach ($products as $product): ?>
            <div class="col-md-4">
                <div class="product-card">
                   
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $product['name']; ?></h5>
                        <p class="card-text">Rp<?php echo number_format($product['price'], 0, ',', '.'); ?></p>

                        
                        <table class="product-image-table">
                            <thead>
                                <tr>
                                    <th>Gambar Produk</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <?php if (!empty($product['image_path']) && file_exists('uploads/' . $product['image_path'])): ?>
                                            <img src="uploads/<?php echo $product['image_path']; ?>" alt="Gambar Produk">
                                        <?php else: ?>
                                            <img src="uploads/pexels-ruben-christen-176523298-15879412.jpg" alt="Gambar Produk">
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div>
                            
                            <form action="cart.php" method="POST" style="display: inline-block; width: 45%;">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <button type="submit" class="btn btn-primary">Tambah ke Keranjang</button>
                            </form>

                            
                            <form action="index.php" method="POST" style="display: inline-block; width: 45%; margin-left: 10px;">
                                <input type="hidden" name="delete_product_id" value="<?php echo $product['id']; ?>">
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>
