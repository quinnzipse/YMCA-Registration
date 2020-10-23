<?php require_once 'authorize.php'; ?>
<html lang="en">
<head>
    <title>Add a Program</title>
</head>
<body>
<?php include '../menu.php'; ?>
<main class="h-100">
    <form action="../service/addProgram.php">
        <div class="input-group">
            <label for="name">Program Name</label>
            <input class="form-control" name="name">
        </div>
    </form>
</main>
</body>
</html>