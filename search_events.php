<?php include 'project_header.txt'; ?>
<?php include_once 'db.php'; ?>

<h2>Search Events by Category</h2>
<p>Select a category below to find upcoming campus events.</p>

<form method="post" style="margin-bottom: 20px;">
    <strong>Select Category:</strong> 
    <select name="category_id">
        <option value="" disabled selected>-- Choose a category --</option>
        <option value="CAT1">Academic</option>
        <option value="CAT2">Social</option>
        <option value="CAT3">Sports</option>
        <option value="CAT4">Career</option>
        <option value="CAT5">Cultural</option>
        <option value="CAT6">Community Service</option>
    </select>
    <input type="submit" value="Search" />
    
    <!-- The modified Reset button that also hides the results div -->
    <input type="reset" value="Clear" onclick="document.getElementById('search-results').innerHTML = '';" />
</form>

<!-- This wrapper div allows JavaScript to clear the results -->
<div id="search-results">
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $catID = $_POST['category_id'] ?? '';
    
    if (!empty($catID)) {
        try {
            $sql  = "SELECT e.Title, c.CategoryName, o.OrgName, e.StartTime, e.MaxCapacity
                     FROM Event e
                     JOIN Category c       ON e.CategoryID  = c.CategoryID
                     JOIN OrganizerClub o ON e.OrganizerID = o.OrganizerID
                     WHERE e.CategoryID = :cid
                     ORDER BY e.StartTime";
                     
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':cid', $catID); 
            $stmt->execute();
            $count = $stmt->rowCount();

            if ($count > 0) {
                echo "<h3>Results Found: $count</h3>";
                echo "<table border='1' style='width:100%; border-collapse: collapse;'>
                        <tr style='background-color: #f2f2f2;'>
                            <th style='padding: 8px;'>Event Title</th>
                            <th style='padding: 8px;'>Category</th>
                            <th style='padding: 8px;'>Organizer</th>
                            <th style='padding: 8px;'>Start Time</th>
                            <th style='padding: 8px;'>Capacity</th>
                        </tr>";

                foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                    printf(
                        "<tr>
                            <td style='padding: 8px;'>%s</td>
                            <td style='padding: 8px;'>%s</td>
                            <td style='padding: 8px;'>%s</td>
                            <td style='padding: 8px;'>%s</td>
                            <td style='padding: 8px;'>%s</td>
                        </tr>",
                        htmlspecialchars($row['Title']),
                        htmlspecialchars($row['CategoryName']),
                        htmlspecialchars($row['OrgName']),
                        htmlspecialchars($row['StartTime']),
                        htmlspecialchars($row['MaxCapacity'])
                    );
                }
                echo "</table>";
            } else {
                echo "<p style='color: orange; font-weight: bold;'>No events are currently scheduled for the selected category.</p>";
            }
        } catch (PDOException $e) {
            echo "<p>Error: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p style='color: red;'>Please select a valid category from the list.</p>";
    }
}
?>
</div> <!-- End of search-results div -->

<?php include 'project_footer.txt'; ?>
