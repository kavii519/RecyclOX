<?php
require_once('../config/db_connection.php');

// Get search and filter parameters
$search = isset($_GET['search']) ? $_GET['search'] : '';
$role = isset($_GET['role']) ? $_GET['role'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';

// Build the SQL query
$query = "
    SELECT 
        user_id,
        first_name,
        last_name,
        email,
        address,
        phone_number,
        role,
        status,
        created_at
    FROM users
    WHERE 1=1
";

// Add search filter
if (!empty($search)) {
    $query .= " AND (
        first_name LIKE '%$search%' OR
        last_name LIKE '%$search%' OR
        email LIKE '%$search%' OR
        address LIKE '%$search%' OR
        phone_number LIKE '%$search%'
    )";
}

// Add role filter
if (!empty($role)) {
    $query .= " AND role = '$role'";
}

// Add status filter
if (!empty($status)) {
    $query .= " AND status = '$status'";
}

// Execute the query
$result = $con->query($query);
$users = $result->fetch_all(MYSQLI_ASSOC);

// Generate table rows
if (!empty($users)) {
    foreach ($users as $user) {
        echo "
        <tr>
            <td>" . htmlspecialchars($user['user_id']) . "</td>
            <td>" . htmlspecialchars($user['first_name']) . "</td>
            <td>" . htmlspecialchars($user['last_name']) . "</td>
            <td>" . htmlspecialchars($user['email']) . "</td>
            <td>" . htmlspecialchars($user['address']) . "</td>
            <td>" . htmlspecialchars($user['phone_number']) . "</td>
            <td>" . htmlspecialchars($user['role']) . "</td>
            <td>" . htmlspecialchars($user['status']) . "</td>
            <td>" . htmlspecialchars($user['created_at']) . "</td>
            <td>
                <a href='./controller/suspend_user.php?id=" . $user['user_id'] . "'>Suspend</a> |
                <a href='./controller/active_user.php?id=" . $user['user_id'] . "'>Active</a> |
                <a href='./controller/delete_user.php?id=" . $user['user_id'] . "' onclick='return confirm(\"Are you sure you want to delete this user?\");'>Delete</a>
            </td>
        </tr>
        ";
    }
} else {
    echo "<tr><td colspan='10'>No users found.</td></tr>";
}
?>