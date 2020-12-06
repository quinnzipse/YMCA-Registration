<?php require_once 'authorize.php'; ?>
<html lang="en">
<head>
    <title>Staff Home</title>
</head>
<main>
<?php include '../menu.php'; ?>
<div class="d-flex bg-light" style="height: calc(100vh - 56px)">
    <div class="row w-100 my-auto pb-5">
        <div class="col-4 col-xl-2 offset-xl-3">
            <div class="card h-100 shadow-sm p-3 clickable mx-2" onclick="window.location = 'programs/';">
                <div class="d-flex h-100">
                    <img src="../img/programs.png" class="card-img-top my-auto" alt="programs">
                </div>
                <h4 class="card-title text-center mt-4">Programs</h4>
            </div>
        </div>
        <div class="col-4 col-xl-2">
            <div class="card h-100 shadow-sm p-3 clickable mx-2" onclick="window.location = 'members/';">
                <div class="d-flex h-100">
                    <img src="../img/members.png" class="card-img-top my-auto" alt="members">
                </div>
                <h4 class="card-title text-center mt-4">Members</h4>
            </div>
        </div>
        <div class="col-4 col-xl-2">
            <div class="card h-100 shadow-sm p-3 clickable mx-2" onclick="window.location = 'staff/';">
                <div class="d-flex h-100">
                    <img src="../img/staff.png" class="card-img-top my-auto" alt="staff">
                </div>
                <h4 class="card-title text-center mt-4">Staff</h4>
            </div>
        </div>
    </div>
</div>
</main>
<style>
    .clickable:hover {
        box-shadow: 0 1rem 3rem rgba(0,0,0,.1) !important;
        transition: box-shadow 180ms ease-in-out;
        cursor: pointer;
    }
</style>
</html>