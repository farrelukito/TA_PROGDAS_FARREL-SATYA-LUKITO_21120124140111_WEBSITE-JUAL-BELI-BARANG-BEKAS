<?php
require 'db.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_id'])) {
        
        $delete_id = $_POST['delete_id'];
        $stmt = $conn->prepare("DELETE FROM cart WHERE id = ?");
        $stmt->execute([$delete_id]);
    } elseif (isset($_POST['product_id'])) {
       
        $product_id = $_POST['product_id'];
        $stmt = $conn->prepare("INSERT INTO cart (product_id) VALUES (?)");
        $stmt->execute([$product_id]);
    }
}


$stmt = $conn->prepare("
    SELECT p.name, p.price, c.id AS cart_id, COUNT(c.id) AS quantity 
    FROM cart c 
    JOIN products p ON c.product_id = p.id 
    GROUP BY p.id
");
$stmt->execute();
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = 0;
foreach ($cartItems as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
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

       
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 30px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        
        h1, h2 {
            font-size: 1.8rem;
            text-align: center;
            color: #333;
        }

        
        .table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .table th, .table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table tr:hover {
            background-color: #f1f1f1;
        }

        
        .btn {
            padding: 10px 20px;
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

        .btn-danger {
            background-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .btn-secondary {
            background-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        
        @media (max-width: 768px) {
            .table, .container {
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


<div class="container">
    <h1>Keranjang Belanja</h1>

    
    <table class="table">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cartItems as $item): ?>
                <tr>
                    <td><?php echo $item['name']; ?></td>
                    <td>Rp<?php echo number_format($item['price'], 0, ',', '.'); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>
                       
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="delete_id" value="<?php echo $item['cart_id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    
    <h2>Total: Rp<?php echo number_format($total, 0, ',', '.'); ?></h2>

    
    <a href="index.php" class="btn btn-secondary">Kembali ke Produk</a>
</div>

</body>
</html>
