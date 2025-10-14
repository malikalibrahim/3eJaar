<?php
// instituten/instituut-edit.php
include '../db.php';
include '../header.php';

$id = $_GET['id'] ?? null;
if (!$id) { header("Location: instituut-view.php"); exit; }

$stmt = $myDb->execute("SELECT * FROM instituten WHERE id = ?", [$id]);
$ins = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $naam = $_POST['naam'] ?? '';
    $adres = $_POST['adres'] ?? '';
    $contactpersoon = $_POST['contactpersoon'] ?? '';
    $telefoon = $_POST['telefoon'] ?? '';
    $email = $_POST['email'] ?? '';

    $myDb->execute("UPDATE instituten SET naam=?, adres=?, contactpersoon=?, telefoon=?, email=? WHERE id=?",
        [$naam, $adres, $contactpersoon, $telefoon, $email, $id]);

    header("Location: instituut-view.php");
    exit;
}
?>

<h2>Instituut wijzigen</h2>
<form method="post">
    <label>Naam:</label><br><input type="text" name="naam" value="<?= htmlspecialchars($ins['naam']) ?>" required><br><br>
    <label>Adres:</label><input type="text" name="adres" value="<?= htmlspecialchars($ins['adres']) ?>">
    <label>Contactpersoon:</label><input type="text" name="contactpersoon" value="<?= htmlspecialchars($ins['contactpersoon']) ?>">
    <label>Telefoon:</label><input type="text" name="telefoon" value="<?= htmlspecialchars($ins['telefoon']) ?>">
    <label>Email:</label><input type="email" name="email" value="<?= htmlspecialchars($ins['email']) ?>">
    <input type="submit" value="Opslaan">
</form>

<?php include '../footer.php'; ?>
