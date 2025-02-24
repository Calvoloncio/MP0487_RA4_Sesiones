<?php
session_start();
if (!isset($_SESSION['array'])) $_SESSION['array'] = [10, 20, 30];

if (isset($_POST['modify'])) {
    $pos = (int)$_POST['position'];
    $newValue = (int)$_POST['new_value'];
    if ($pos >= 0 && $pos < count($_SESSION['array'])) $_SESSION['array'][$pos] = $newValue;
}

if (isset($_POST['average'])) $average = array_sum($_SESSION['array']) / count($_SESSION['array']);

if (isset($_POST['reset'])) $_SESSION['array'] = [10, 20, 30];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Array</title>
</head>
<body>
    <h2>Modify array saved in session</h2>
    <form method="post">
        <input type="number" name="position" min="0" max="2"placeholder="Position">
        <br><br>    
        <input type="number" name="new_value"placeholder="New value">
        <br><br>
        <button type="submit" name="modify">Modify</button>
        <button type="submit" name="average">Average</button>
        <button type="submit" name="reset">Reset</button>
    </form>
    <p><strong>Current array:</strong> <?php echo implode(", ", $_SESSION['array']); ?></p>
    <?php if (isset($average)) echo "<p><strong>Average:</strong> " . number_format($average, 2) . "</p>"; ?>
</body>
</html>
