<?php
include "config.php";
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $img = !empty($row['profile_image']) ? $row['profile_image'] : 'assets/images/users/avatar-1.jpg';
        echo "<tr>

                <td class='id'>#{$row['id']}</td>
                <td class='name'><div class='d-flex align-items-center'><img src='{$img}' alt='' class='rounded-circle avatar-xs me-2'> {$row['name']}</div></td>
                <td class='username'>{$row['username']}</td>
                <td class='email'>{$row['email']}</td>
                <td class='role'><span class='badge bg-success-subtle text-success text-uppercase'>{$row['role']}</span></td>
                <td>
                    <div class='d-flex gap-2'>
                        <div class='edit'>
                            <button class='btn btn-sm btn-success edit-item-btn'
                                    data-id='{$row['id']}'
                                    data-bs-toggle='modal'
                                    data-bs-target='#showModal'>Edit</button>
                        </div>
                        <div class='remove'>
                            <button class='btn btn-sm btn-danger remove-item-btn'
                                    data-id='{$row['id']}'
                                    data-bs-toggle='modal'
                                    data-bs-target='#deleteRecordModal'>Remove</button>
                        </div>
                    </div>
                </td>
            </tr>";
    }
} else {
    echo "<tr><td colspan='8' class='text-center'>No users found</td></tr>";
}
?>
