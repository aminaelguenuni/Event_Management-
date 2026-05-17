<?php include 'project_header.txt'; ?>
<?php
include_once 'db.php';
$errors = [];
$success = '';

// Load categories for dropdown
$categories = $conn->query("SELECT CategoryID, CategoryName FROM Category")->fetchAll(PDO::FETCH_ASSOC);
// Load organizers for dropdown
$organizers = $conn->query("SELECT OrganizerID, OrgName FROM OrganizerClub")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventID  = trim($_POST['eventID']);
    $title    = trim($_POST['title']);
    $desc     = trim($_POST['description']);
    $start    = $_POST['start'];
    $end      = $_POST['end'];
    $cap      = $_POST['capacity'];
    $catID    = $_POST['categoryID'];
    $orgID    = $_POST['organizerID'];

    if (empty($eventID) || empty($title) || empty($start) || empty($end)) {
        $errors[] = "Event ID, Title, Start and End times are required.";
    }
    if (empty($errors)) {
        try {
            $sql = "INSERT INTO Event (EventID,Title,Description,StartTime,EndTime,MaxCapacity,CategoryID,OrganizerID)
                    VALUES (:eid,:title,:desc,:start,:end,:cap,:cat,:org)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':eid'=>$eventID, ':title'=>$title, ':desc'=>$desc,
                ':start'=>$start, ':end'=>$end, ':cap'=>$cap,
                ':cat'=>$catID,   ':org'=>$orgID
            ]);
            $success = "Event '$title' added successfully!";
        } catch (PDOException $e) {
            $errors[] = "Insert failed: " . $e->getMessage();
        }
    }
}
?>

<h2>Add New Event</h2>

<?php if ($success): ?>
  <p style="color:green"><?= htmlspecialchars($success) ?></p>
<?php endif; ?>
<?php if (!empty($errors)): ?>
  <div class="error"><ul>
  <?php foreach ($errors as $err): ?>
    <li><?= htmlspecialchars($err) ?></li>
  <?php endforeach; ?>
  </ul></div>
<?php endif; ?>

<form action="add_event.php" method="post">

  <label>Event ID*:</label>
  <input type="text" name="eventID" placeholder="e.g. E009"
         value="<?= htmlspecialchars($_POST['eventID'] ?? '') ?>" required /><br>

  <label>Title*:</label>
  <input type="text" name="title"
         value="<?= htmlspecialchars($_POST['title'] ?? '') ?>" required /><br>

  <label>Description:</label>
  <input type="text" name="description"
         value="<?= htmlspecialchars($_POST['description'] ?? '') ?>" /><br>

  <label>Start Time*:</label>
  <input type="datetime-local" name="start" required /><br>

  <label>End Time*:</label>
  <input type="datetime-local" name="end" required /><br>

  <label>Max Capacity:</label>
  <input type="number" name="capacity" value="50" /><br>

  <label>Category:</label>
  <select name="categoryID">
    <?php foreach ($categories as $cat): ?>
      <option value="<?= htmlspecialchars($cat['CategoryID']) ?>">
        <?= htmlspecialchars($cat['CategoryName']) ?>
      </option>
    <?php endforeach; ?>
  </select><br>

  <label>Organizer:</label>
  <select name="organizerID">
    <?php foreach ($organizers as $org): ?>
      <option value="<?= htmlspecialchars($org['OrganizerID']) ?>">
        <?= htmlspecialchars($org['OrgName']) ?>
      </option>
    <?php endforeach; ?>
  </select><br>

  <input type="submit" value="Add Event" />
  <input type="reset" />
</form>

<?php include 'project_footer.txt'; ?>
