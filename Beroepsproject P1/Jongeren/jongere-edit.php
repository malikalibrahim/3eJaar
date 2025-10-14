<?php
// jongeren/jongere-edit.php
include '../db.php';
include '../header.php';

$id = $_GET['id'] ?? null;
if (!$id) { header("Location: jongere-view.php"); exit; }

$stmt = $myDb->execute("SELECT * FROM jongeren WHERE id = ?", [$id]);
$jongere = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $naam = $_POST['naam'] ?? '';
    $geboortedatum = $_POST['geboortedatum'] ?? null;
    $adres = $_POST['adres'] ?? '';
    $telefoon = $_POST['telefoon'] ?? '';
    $email = $_POST['email'] ?? '';
    $status = $_POST['status'] ?? 'ingeschreven';

    $myDb->execute("UPDATE jongeren SET naam=?, geboortedatum=?, adres=?, telefoon=?, email=?, status=? WHERE id=?",
        [$naam, $geboortedatum, $adres, $telefoon, $email, $status, $id]);

    header("Location: jongere-view.php");
    exit;
}
?>

<h2>Jongere wijzigen</h2>
<form method="post">
    <label>Naam:</label><br><input type="text" name="naam" value="<?= htmlspecialchars($jongere['naam']) ?>" required><br><br>
    <label>Geboortedatum:</label><input type="date" name="geboortedatum" value="<?= $jongere['geboortedatum'] ?>">
    <label>Adres:</label><input type="text" name="adres" value="<?= htmlspecialchars($jongere['adres']) ?>">
    <label>Telefoon:</label><input type="text" name="telefoon" value="<?= $jongere['telefoon'] ?>">
    <label>Email:</label><input type="email" name="email" value="<?= htmlspecialchars($jongere['email']) ?>">
    <label>Status:</label>
    <select name="status">
        <option value="ingeschreven" <?= $jongere['status']=='ingeschreven'?'selected':'' ?>>Ingeschreven</option>
        <option value="uitgeplaatst" <?= $jongere['status']=='uitgeplaatst'?'selected':'' ?>>Uitgeplaatst</option>
    </select>
    <input type="submit" value="Opslaan">
</form>

<?php include '../footer.php'; ?>
