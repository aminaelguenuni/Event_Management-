<?php include 'project_header.txt'; ?>
<?php
include_once 'db.php';
$errors = [];
$success = '';

// Load events for dropdown
$events = $conn->query("SELECT EventID, Title FROM Event ORDER BY Title")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentID = trim($_POST['studentID']);
    $firstName = trim($_POST['firstName']);
    $lastName  = trim($_POST['lastName']);
    $email     = trim($_POST['email']);
    $gradYear  = trim($_POST['gradYear']);
    $eventID   = trim($_POST['eventID']);

    if (empty($studentID) || empty($firstName) || empty($lastName) || empty($email) || empty($gradYear) || empty($eventID)) {
        $errors[] = "All fields are required.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email address is not valid.";
    }
    if (empty($errors)) {
        try {
            // Insert new student
            $sql = "INSERT INTO Student (StudentID, FirstName, LastName, Email, GradYear)
                    VALUES (:sid, :fn, :ln, :email, :gy)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':sid'   => $studentID,
                ':fn'    => $firstName,
                ':ln'    => $lastName,
                ':email' => $email,
                ':gy'    => $gradYear
            ]);

            // Register student for event
            $sql2 = "INSERT INTO Registers (StudentID, EventID) VALUES (:sid, :eid)";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->execute([':sid' => $studentID, ':eid' => $eventID]);

            $success = "Student $firstName $lastName registered successfully!";
        } catch (PDOException $e) {
            $errors[] = "Insert failed: " . $e->getMessage();
        }
    }
}
?>

<h2>Register a New Student for an Event</h2>

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

<form action="register_student.php" method="post">

  <label>Student ID*:</label>
  <input type="text" name="studentID" placeholder="e.g. S009"
         value="<?= htmlspecialchars($_POST['studentID'] ?? '') ?>" required /><br>

  <label>First Name*:</label>
  <input type="text" name="firstName"
         value="<?= htmlspecialchars($_POST['firstName'] ?? '') ?>" required /><br>

  <label>Last Name*:</label>
  <input type="text" name="lastName"
         value="<?= htmlspecialchars($_POST['lastName'] ?? '') ?>" required /><br>

  <label>Email*:</label>
  <input type="email" name="email"
         value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required /><br>

  <label>Graduation Year*:</label>
  <input type="number" name="gradYear" placeholder="e.g. 2027"
         value="<?= htmlspecialchars($_POST['gradYear'] ?? '') ?>" required /><br>

  <label>Event:</label>
  <select name="eventID">
    <?php foreach ($events as $e): ?>
      <option value="<?= htmlspecialchars($e['EventID']) ?>">
        <?= htmlspecialchars($e['Title']) ?>
      </option>
    <?php endforeach; ?>
  </select><br>

  <input type="submit" value="Register" />
  <input type="reset" />
</form>

<?php include 'project_footer.txt'; ?>
