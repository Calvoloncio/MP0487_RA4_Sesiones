<?php
session_start();

// Inicializar variables si no están definidas
$name = isset($_POST['name']) ? $_POST['name'] : '';
$quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 0;
$price = isset($_POST['price']) ? $_POST['price'] : 0;
$index = isset($_POST['index']) ? $_POST['index'] : -1;
$error = '';
$message = '';
$totalValue = 0;

// Inicializar la lista de la sesión si no está definida
if (!isset($_SESSION['list'])) {
    $_SESSION['list'] = [];
}

// Función para calcular el total
function calculateTotal($list)
{
    $total = 0;
    foreach ($list as $item) {
        $total += $item['quantity'] * $item['price'];
    }
    return $total;
}

// Manejar acciones del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        if ($name && $quantity > 0 && $price > 0) {
            $_SESSION['list'][] = [
                'name' => $name,
                'quantity' => $quantity,
                'price' => $price
            ];
            $message = 'Item added successfully!';
        } else {
            $error = 'Please fill in all fields correctly.';
        }
    }

    if (isset($_POST['edit'])) {
        $name = $_POST['name'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $index = $_POST['index'];
    }

    if (isset($_POST['update']) && $index >= 0 && isset($_SESSION['list'][$index])) {
        $_SESSION['list'][$index] = [
            'name' => $name,
            'quantity' => $quantity,
            'price' => $price
        ];
        $message = 'Item updated successfully!';
    }

    if (isset($_POST['delete']) && $index >= 0 && isset($_SESSION['list'][$index])) {
        unset($_SESSION['list'][$index]);
        $_SESSION['list'] = array_values($_SESSION['list']); // Reindexar array
        $message = 'Item deleted successfully!';
    }

    if (isset($_POST['reset'])) {
        $_SESSION['list'] = [];
        $message = 'List reset successfully!';
    }

    if (isset($_POST['total'])) {
        $totalValue = calculateTotal($_SESSION['list']);
    }
}

// Calcular el total si la lista no está vacía
if (!empty($_SESSION['list'])) {
    $totalValue = calculateTotal($_SESSION['list']);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Shopping list</title>
    <style>
        table,th,td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th,td {
            padding: 5px;
        }

        input[type=submit] {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <h1>Shopping list</h1>
    <form method="post">
        <label for="name">name:</label>
        <input type="text" name="name" id="name" value="<?php echo ($name); ?>">
        <br>
        <label for="quantity">quantity:</label>
        <input type="number" name="quantity" id="quantity" value="<?php echo ($quantity); ?>">
        <br>
        <label for="price">price:</label>
        <input type="number" name="price" id="price" value="<?php echo ($price); ?>">
        <br>
        <input type="hidden" name="index" value="<?php echo ($index); ?>">
        <input type="submit" name="add" value="Add">
        <input type="submit" name="update" value="Update">
        <input type="submit" name="reset" value="Reset">
    </form>
    <p style="color:red;"><?php echo ($error); ?></p>
    <p style="color:green;"><?php echo ($message); ?></p>
    <table>
        <thead>
            <tr>
                <th>name</th>
                <th>quantity</th>
                <th>price</th>
                <th>cost</th>
                <th>actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_SESSION['list'] as $index => $item) { ?>
                <tr>
                    <td><?php echo ($item['name']); ?></td>
                    <td><?php echo ($item['quantity']); ?></td>
                    <td><?php echo ($item['price']); ?></td>
                    <td><?php echo ($item['quantity'] * $item['price']); ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="name" value="<?php echo ($item['name']); ?>">
                            <input type="hidden" name="quantity" value="<?php echo ($item['quantity']); ?>">
                            <input type="hidden" name="price" value="<?php echo ($item['price']); ?>">
                            <input type="hidden" name="index" value="<?php echo ($index); ?>">
                            <input type="submit" name="edit" value="Edit">
                            <input type="submit" name="delete" value="Delete">
                        </form>
                    </td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="3" align="right"><strong>Total:</strong></td>
                <td><?php echo ($totalValue); ?></td>
                <td>
                    <form method="post">
                        <input type="submit" name="total" value="Calculate total">
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
