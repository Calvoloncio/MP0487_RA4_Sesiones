<?php
session_start(); // Iniciar sesión

// Guardar el nombre del trabajador
if (isset($_POST['worker_name'])) {
    $_SESSION['worker_name'] = $_POST['worker_name'];
}

// Inicializar productos si no existen
if (!isset($_SESSION['milk'])) $_SESSION['milk'] = 3;
if (!isset($_SESSION['soft_drink'])) $_SESSION['soft_drink'] = 0;

// Manejo del inventario
if (isset($_POST['product']) && isset($_POST['quantity'])) {
    $product = $_POST['product']; 
    $quantity = (int) $_POST['quantity']; 

    if (isset($_POST['add'])) { 
        $_SESSION[$product] += $quantity; 
    } elseif (isset($_POST['remove']) && $_SESSION[$product] >= $quantity) { 
        $_SESSION[$product] -= $quantity;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Supermarket Management</title>
</head>
<body>

<h1>Supermarket Management</h1>

<form method="post">
    <label>Worker name:</label>
    <input type="text" name="worker_name" value="<?php echo $_SESSION['worker_name'] ?? ''; ?>" required>
    <br><br>

    <label> <h1>Choose product:</h1></label>
    <select name="product">
        <option value="milk">Milk</option>
        <option value="soft_drink">Soft Drink</option>
    </select>
    <br><br>

    <label><h1>Product quantity:</h1></label>
    <input type="number" name="quantity" min="1" required>
    <br><br>

    <button type="submit" name="add">Add</button>
    <button type="submit" name="remove">Remove</button>
</form>

<h2>Inventory:</h2>
<p>Worker: <?php echo $_SESSION['worker_name'] ?? 'Not set'; ?></p>
<p>Milk: <?php echo $_SESSION['milk']; ?></p>
<p>Soft Drink: <?php echo $_SESSION['soft_drink']; ?></p>

</body>
</html>