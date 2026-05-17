<?php include 'project_header.txt'; ?>
<?php include_once 'db.php'; ?>
<h2>Events with Organizer and Category</h2>
<table>
<tr>
  <th>Event Title</th><th>Category</th><th>Organizer</th>
  <th>Type</th><th>Start Time</th><th>Capacity</th>
</tr>
<?php
try {
    $stmt = $conn->query("
        SELECT e.Title, c.CategoryName, o.OrgName,
               o.Type, e.StartTime, e.MaxCapacity
        FROM Event e
        JOIN Category c      ON e.CategoryID  = c.CategoryID
        JOIN OrganizerClub o ON e.OrganizerID = o.OrganizerID
        ORDER BY e.StartTime
    ");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        printf(
            "<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>\n",
            htmlspecialchars($row['Title']),
            htmlspecialchars($row['CategoryName']),
            htmlspecialchars($row['OrgName']),
            htmlspecialchars($row['Type']),
            htmlspecialchars($row['StartTime']),
            htmlspecialchars($row['MaxCapacity'])
        );
    }
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
$conn = null;
?>
</table>
<?php include 'project_footer.txt'; ?>
