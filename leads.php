<?php
include 'includes/auth.php';
include 'config.php';

$message = '';

// Handle deletion
if (isset($_GET['delete'])) {
    $delId = (int)$_GET['delete'];
    $stmt = $conn->prepare('DELETE FROM leads WHERE id=?');
    if ($stmt) {
        $stmt->bind_param('i', $delId);
        $stmt->execute();
        $stmt->close();
    }
    header('Location: leads.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id   = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $name  = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $property_id = isset($_POST['property_id']) ? (int)$_POST['property_id'] : 0;
    $note  = trim($_POST['message']);
    $status = isset($_POST['status']) ? trim($_POST['status']) : 'Interested';

    // Handle avatar upload
    $avatarPath = null;
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/leads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $fileName = time() . '_' . basename($_FILES['avatar']['name']);
        $targetPath = $uploadDir . $fileName;
        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $targetPath)) {
            $avatarPath = $targetPath;
        }
    }

    if ($id > 0) {
        if ($avatarPath) {
            $stmt = $conn->prepare('UPDATE leads SET name=?,email=?,phone=?,property_id=NULLIF(?,0),message=?,avatar=?,status=? WHERE id=?');
            if ($stmt) {
                $stmt->bind_param('sssisssi', $name, $email, $phone, $property_id, $note, $avatarPath, $status, $id);
                if ($stmt->execute()) {
                    $message = 'Lead updated successfully!';
                } else {
                    $message = 'Error updating lead: ' . $stmt->error;
                }
                $stmt->close();
            } else {
                $message = 'Error preparing statement: ' . $conn->error;
            }
        } else {
            $stmt = $conn->prepare('UPDATE leads SET name=?,email=?,phone=?,property_id=NULLIF(?,0),message=?,status=? WHERE id=?');
            if ($stmt) {
                $stmt->bind_param('sssissi', $name, $email, $phone, $property_id, $note, $status, $id);
                if ($stmt->execute()) {
                    $message = 'Lead updated successfully!';
                } else {
                    $message = 'Error updating lead: ' . $stmt->error;
                }
                $stmt->close();
            } else {
                $message = 'Error preparing statement: ' . $conn->error;
            }
        }
    } else {
        $stmt = $conn->prepare('INSERT INTO leads (name,email,phone,property_id,message,avatar,status) VALUES (?,?,?,NULLIF(?,0),?,?,?)');
        if ($stmt) {
            $stmt->bind_param('sssisss', $name, $email, $phone, $property_id, $note, $avatarPath, $status);
            if ($stmt->execute()) {
                $message = 'Lead added successfully!';
            } else {
                $message = 'Error adding lead: ' . $stmt->error;
            }
            $stmt->close();
        } else {
            $message = 'Error preparing statement: ' . $conn->error;
        }
    }
}

$properties = $conn->query("SELECT id, project_name FROM properties ORDER BY project_name");
$leads = $conn->query("SELECT leads.*, properties.project_name FROM leads LEFT JOIN properties ON leads.property_id = properties.id ORDER BY leads.created_at DESC");
?>
<?php include 'includes/common-header.php'; ?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">Leads</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                <li class="breadcrumb-item active">Leads</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <?php if ($message): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4 class="card-title mb-0">Lead Management</h4>
                            <button type="button" class="btn btn-success" id="addLeadBtn" data-bs-toggle="modal" data-bs-target="#leadModal"><i class="ri-add-line align-bottom me-1"></i> Add Lead</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-card">
                                <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                    <thead class="text-muted table-light">
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Property</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Date</th>
                                           <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($leads && $leads->num_rows > 0): while ($l = $leads->fetch_assoc()): ?>
                                            <tr>
                                                <td>#<?php echo htmlspecialchars($l['id']); ?></td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 me-2">
                                                            <?php if (isset($l['avatar']) && !empty($l['avatar'])): ?>
                                                                <img src="<?php echo htmlspecialchars($l['avatar']); ?>" alt="" class="avatar-xs rounded-circle material-shadow" />
                                                            <?php else: ?>
                                                                <img src="assets/images/users/default-avatar.jpg" alt="" class="avatar-xs rounded-circle material-shadow" />
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="flex-grow-1"><?php echo htmlspecialchars($l['name']); ?></div>
                                                    </div>
                                                </td>
                                                <td><?php echo htmlspecialchars($l['email']); ?></td>
                                                <td><?php echo htmlspecialchars($l['project_name'] ?? ''); ?></td>
                                                <td>
                                                    <?php
                                                    $statusClass = '';
                                                    $statusText = isset($l['status']) ? $l['status'] : 'Interested';

                                                    switch (strtolower($statusText)) {
                                                        case 'interested':
                                                            $statusClass = 'bg-success-subtle text-success';
                                                            break;
                                                        case 'not interested':
                                                            $statusClass = 'bg-danger-subtle text-danger';
                                                            break;
                                                        case 'cold':
                                                            $statusClass = 'bg-info-subtle text-info';
                                                            break;
                                                        case 'hot':
                                                            $statusClass = 'bg-warning-subtle text-warning';
                                                            break;
                                                        default:
                                                            $statusClass = 'bg-info-subtle text-info';
                                                    }
                                                    ?>
                                                    <span class="badge <?php echo $statusClass; ?>"><?php echo htmlspecialchars($statusText); ?></span>
                                                </td>
                                                <td><?php echo date('d/m/Y', strtotime($l['created_at'])); ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-primary edit-lead-btn"
                                                        data-id="<?php echo $l['id']; ?>"
                                                        data-name="<?php echo htmlspecialchars($l['name']); ?>"
                                                        data-email="<?php echo htmlspecialchars($l['email']); ?>"
                                                    data-phone="<?php echo htmlspecialchars($l['phone']); ?>"
                                                        data-property="<?php echo htmlspecialchars($l['property_id']); ?>"
                                                        data-status="<?php echo htmlspecialchars($l['status']); ?>"
                                                        data-message="<?php echo htmlspecialchars($l['message']); ?>">Edit</button>
                                                    <a href="leads.php?delete=<?php echo $l['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this lead?');">Delete</a>
                                                </td>
                                            </tr>
                                        <?php endwhile; else: ?>
                                            <tr><td colspan="7" class="text-center">No leads found</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="leadModal" tabindex="-1" aria-labelledby="leadModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="leads.php" method="POST" enctype="multipart/form-data" id="lead-form">
                            <div class="modal-header">
                                <h5 class="modal-title" id="leadModalLabel">Add Lead</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id" id="lead-id" />
                                <div class="mb-3">
                                    <label for="lead-name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="lead-name" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="lead-email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="lead-email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="lead-phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control" id="lead-phone" name="phone">
                                </div>
                                <div class="mb-3">
                                    <label for="lead-property" class="form-label">Property</label>
                                    <select class="form-select" id="lead-property" name="property_id">
                                        <option value="0">Select Property</option>
                                        <?php if ($properties && $properties->num_rows > 0): while ($p = $properties->fetch_assoc()): ?>
                                            <option value="<?php echo $p['id']; ?>"><?php echo htmlspecialchars($p['project_name']); ?></option>
                                        <?php endwhile; endif; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="lead-status" class="form-label">Status</label>
                                    <select class="form-select" id="lead-status" name="status">
                                        <option value="Interested">Interested</option>
                                        <option value="Not Interested">Not Interested</option>
                                        <option value="Cold">Cold</option>
                                        <option value="Hot">Hot</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="lead-avatar" class="form-label">Profile Image</label>
                                    <input type="file" class="form-control" id="lead-avatar" name="avatar" accept="image/*">
                                </div>
                                <div class="mb-3">
                                    <label for="lead-message" class="form-label">Message</label>
                                    <textarea class="form-control" id="lead-message" name="message" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Save Lead</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>
</div>
<script>
document.querySelectorAll('.edit-lead-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        const modalEl = document.getElementById('leadModal');
        document.getElementById('leadModalLabel').innerText = 'Edit Lead';
        document.getElementById('lead-id').value = this.dataset.id;
        document.getElementById('lead-name').value = this.dataset.name;
        document.getElementById('lead-email').value = this.dataset.email;
        document.getElementById('lead-phone').value = this.dataset.phone;
        document.getElementById('lead-property').value = this.dataset.property;
        document.getElementById('lead-status').value = this.dataset.status;
        document.getElementById('lead-message').value = this.dataset.message;
        new bootstrap.Modal(modalEl).show();
    });
});

document.getElementById('addLeadBtn').addEventListener('click', () => {
    document.getElementById('leadModalLabel').innerText = 'Add Lead';
    document.getElementById('lead-form').reset();
    document.getElementById('lead-id').value = '';
});
</script>
<?php include 'includes/common-footer.php'; ?>

