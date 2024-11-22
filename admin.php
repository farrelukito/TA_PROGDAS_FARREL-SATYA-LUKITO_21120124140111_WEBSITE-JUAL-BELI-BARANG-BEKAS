<?php
require 'db.php';
require 'classes/Admin.php';

$admin = new Admin("Admin");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    
   
    $price = str_replace('.', '', $_POST['price']);
    
    
    $imagePath = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $imagePath = $uploadDir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    }

    
    $admin->addProduct($conn, $name, $price, $imagePath);
    header("Location: admin.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Tambah Produk</title>
    <style>
        
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        
        nav {
            background-color: #343a40;
            color: white;
            padding: 15px 0;
            text-align: center;
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            margin: 0 15px;
            display: inline-block;
        }

        nav a:hover {
            background-color: #555;
            border-radius: 4px;
        }

        
        .card-container {
            width: 100%;
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .card-body {
            text-align: center;
        }

        h1 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 20px;
        }

        
        .form-label {
            text-align: left;
            font-size: 1rem;
            margin-bottom: 5px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 1rem;
        }

        .form-control:focus {
            border-color: #007bff;
            outline: none;
        }

        
        .btn {
            padding: 12px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        
        @media (max-width: 768px) {
            .card-container {
                width: 90%;
                padding: 15px;
            }

            .btn {
                width: 100%;
                padding: 15px;
            }
        }
    </style>
</head>
<body>


<nav>
    <a href="index.php">Beranda</a>
    <a href="cart.php">Keranjang</a>
    <a href="admin.php">Admin</a>
</nav>


<div class="card-container">
    <div class="card-body">
        <h1>Tambah Produk</h1>
        <form method="POST" enctype="multipart/form-data">
            <div>
                <label for="name" class="form-label">Nama Produk</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div>
    <label for="price" class="form-label">Harga Produk</label>
    <input type="text" name="price" id="price" class="form-control" required oninput="formatHarga(this)">
</div>

            <div>
                <label for="image" class="form-label" required>Unggah Gambar Produk</label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*">
            </div>
            <div>
                <button type="submit" class="btn">Tambah</button>
            </div>
        </form>
        <div style="margin-top: 20px;">
            <a href="index.php" class="btn btn-secondary">Kembali ke Produk</a>
        </div>
    </div>
</div>
<script>
    
    function formatHarga(input) {
        let value = input.value.replace(/\D/g, ''); 
        let formattedValue = value.replace(/(\d)(\d{3})$/, '$1.$2'); 
        formattedValue = formattedValue.replace(/(?=(\d{3})\.)/g, '.'); 
        
        input.value = formattedValue;
    }
</script>


</body>
</html>
