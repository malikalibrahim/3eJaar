<?php
include_once __DIR__ . '/../db.php';
include_once __DIR__ . '/../header.php';
if (!isset($_SESSION['boom_user']) || (($_SESSION['boom_user']['rol'] ?? null) !== 'admin')) { header('Location: ../User/login.php'); exit; }

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'create') {
        $naam = trim($_POST['naam'] ?? '');
        $docent_id = $_POST['docent_id'] ?? '';
        if ($naam === '') { $errors[] = 'Vaknaam is verplicht.'; }
        if ($docent_id === '') { $errors[] = 'Docent is verplicht.'; }
        if (!$errors) {
            try {
                $myDb->execute("INSERT INTO vakken (naam, docent_id) VALUES (?, ?)", [$naam, (int)$docent_id]);
                header('Location: vakken.php');
                exit;
            } catch (Throwable $e) {
                $errors[] = 'Kon vak niet opslaan (mogelijk bestaat dit vak al voor deze docent).';
            }
        }
    } elseif ($action === 'delete') {
        $id = $_POST['id'] ?? '';
        if ($id !== '') {
            try {
                $myDb->execute("DELETE FROM vakken WHERE id = ?", [(int)$id]);
                header('Location: vakken.php');
                exit;
            } catch (Throwable $e) {
                $errors[] = 'Kon vak niet verwijderen (mogelijk is het in gebruik in een rooster).';
            }
        }
    }
}

$docenten = $myDb->execute("SELECT id, naam FROM users WHERE rol='docent' ORDER BY naam")->fetchAll(PDO::FETCH_ASSOC);
$vakken = $myDb->execute("SELECT v.id, v.naam AS vak, u.naam AS docent FROM vakken v LEFT JOIN users u ON u.id = v.docent_id ORDER BY v.naam, u.naam")->fetchAll(PDO::FETCH_ASSOC);
?>
<h2>Vakken beheren</h2>
<?php if ($errors): ?><div class="error"><?php foreach ($errors as $e) { echo '<p>' . htmlspecialchars($e) . '</p>'; } ?></div><?php endif; ?>

<form method="post" class="stack" style="margin-bottom:16px">
  <input type="hidden" name="action" value="create">
  <label>Vaknaam</label>
  <input type="text" name="naam" required>
  <label>Docent</label>
  <select name="docent_id" required>
    <option value="">-- kies docent --</option>
    <?php foreach ($docenten as $d): ?>
      <option value="<?= $d['id'] ?>"><?= htmlspecialchars($d['naam']) ?></option>
    <?php endforeach; ?>
  </select>
  <input type="submit" value="Vak toevoegen">
  <p class="muted">Tip: voeg per docent de vakken toe die hij/zij geeft.</p>
  <p><a class="button button--ghost" href="../Rooster/rooster-insert.php">Terug naar les toevoegen</a></p>
  </form>

<table class="table">
  <thead><tr><th>Vak</th><th>Docent</th><th>Acties</th></tr></thead>
  <tbody>
  <?php foreach ($vakken as $v): ?>
    <tr>
      <td><?= htmlspecialchars($v['vak']) ?></td>
      <td><?= htmlspecialchars($v['docent'] ?? '-') ?></td>
      <td>
        <form method="post" onsubmit="return confirm('Verwijderen?');" style="display:inline">
          <input type="hidden" name="action" value="delete">
          <input type="hidden" name="id" value="<?= $v['id'] ?>">
          <button class="button button--danger">Verwijderen</button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
<?php include_once __DIR__ . '/../footer.php'; ?>


