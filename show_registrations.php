<?php include 'project_header.txt'; ?>
<?php include_once 'db.php'; ?>
<h2>Students Registered for Events</h2>
<table>
<tr>
  <th>Student Name</th><th>Email</th><th>Event Title</th>
  <th>Start Time</th><th>Category</th>
</tr>
<?php
try {
    $stmt = $conn->query("
        SELECT s.FirstName, s.LastName, s.Email,
               e.Title, e.StartTime, c.CategoryName
        FROM Student s
        JOIN Registers r ON s.StudentID = r.StudentID
        JOIN Event e     ON r.EventID   = e.EventID
        JOIN Category c  ON e.CategoryID = c.CategoryID
        ORDER BY s.LastName
    ");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        printf(
            "<tr><td>%s %s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>\n",
            htmlspecialchars($row['FirstName']),
            htmlspecialchars($row['LastName']),
            htmlspecialchars($row['Email']),
            htmlspecialchars($row['Title']),
            htmlspecialchars($row['StartTime']),
            htmlspecialchars($row['CategoryName'])
        );
    }
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
$conn = null;
?>
</table>
<?php include 'project_footer.txt'; ?>
