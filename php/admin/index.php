<?php
session_start();
if (!isset($_SESSION['user']) && $_SESSION["user"]["is_admin"]!=1) {
    ?>
    <h1>403: Forbidden</h1>
    <?php
    header("Location: ../../index.php");
    die();
} else {
    
}
?>
<?php
include_once './layout/header.php';
?>

<h1>Welcome <?= $_SESSION["user"]["name"] ?></h1>
<form action="../logout.php" method="post">
    <input type="hidden" value="true" name="adminLogout">
    <button type="submit">Logout</button>
</form>

<?php
include_once './layout/footer.php';
?>
