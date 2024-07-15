<?php
require_once 'utils/header.php';
require_once 'utils/styles.php';

$usn = $_POST['usn'];

include_once 'classes/db1.php';

// Fetch registered events
$registeredQuery = "
    SELECT e.event_title, st.st_name, s.name, ef.Date, ef.time, ef.location 
    FROM registered r
    JOIN events e ON r.event_id = e.event_id
    JOIN student_coordinator st ON e.event_id = st.event_id
    JOIN staff_coordinator s ON e.event_id = s.event_id
    JOIN event_info ef ON e.event_id = ef.event_id
    WHERE r.usn = '$usn'
";
$registeredResult = mysqli_query($conn, $registeredQuery);

// Fetch not registered events
$notRegisteredQuery = "
    SELECT e.event_title, st.st_name, s.name, ef.Date, ef.time, ef.location 
    FROM events e
    JOIN student_coordinator st ON e.event_id = st.event_id
    JOIN staff_coordinator s ON e.event_id = s.event_id
    JOIN event_info ef ON e.event_id = ef.event_id
    WHERE e.event_id NOT IN (SELECT event_id FROM registered WHERE usn = '$usn')
";
$notRegisteredResult = mysqli_query($conn, $notRegisteredQuery);
?>

<div class="content">
    <div class="container">
        <h1>Registered Events</h1>
        <?php if (mysqli_num_rows($registeredResult) > 0) { ?> 
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Student Co-ordinator</th>
                        <th>Staff Co-ordinator</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Location</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_array($registeredResult)) { ?>
                        <tr>
                            <td><?php echo $row['event_title']; ?></td>
                            <td><?php echo $row['st_name']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['Date']; ?></td>
                            <td><?php echo $row['time']; ?></td>
                            <td><?php echo $row['location']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>Not Yet Registered for any events</p>
        <?php } ?>
    </div>
</div>

<div class="content">
    <div class="container">
        <h1>Not Registered Events</h1>
        <?php if (mysqli_num_rows($notRegisteredResult) > 0) { ?> 
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Student Co-ordinator</th>
                        <th>Staff Co-ordinator</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Location</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_array($notRegisteredResult)) { ?>
                        <tr>
                            <td><?php echo $row['event_title']; ?></td>
                            <td><?php echo $row['st_name']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['Date']; ?></td>
                            <td><?php echo $row['time']; ?></td>
                            <td><?php echo $row['location']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>No available events to register</p>
        <?php } ?>
    </div>
</div>

<?php include 'utils/footer.php'; ?>
