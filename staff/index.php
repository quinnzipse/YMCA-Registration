<?php
include_once "authorize.php";
?>
    <html lang="en">
    <head>
        <title>Staff Home</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    </head>
    <?php include '../menu.php'; ?>
    <a href="addProgram.php" class="btn btn-outline-secondary m-5">Add a program!</a>
    <table class="container-fluid table">
        <thead></thead>
        <tbody>
        <tr>
            <td>Program 1</td>
        </tr>
        <tr>
            <td>Program 1</td>
        </tr>
        <tr>
            <td>Program 1</td>
        </tr>
        <tr>
            <td>Program 1</td>
        </tr>
        </tbody>
    </table>
    </html>
<?php
if ($_REQUEST['programCreated'] ?? 0 == 1)
    echo "<script>
    const Toast = Swal.mixin({ //when firing the toast, the first window closes automatically
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        icon: 'success',
        title: 'Program Created Successfully!',
        timer: 2000,
        timerProgressBar: true
    });

    Toast.fire();
</script>";
?>