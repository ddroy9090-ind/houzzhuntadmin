<?php
include 'includes/auth.php';
include 'config.php';

$message = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

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
            $stmt = $conn->prepare(
                'UPDATE leads SET name=?,email=?,phone=?,property_id=NULLIF(?,0),message=?,avatar=?,status=? WHERE id=?'
            );
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
            $stmt = $conn->prepare(
                'UPDATE leads SET name=?,email=?,phone=?,property_id=NULLIF(?,0),message=?,status=? WHERE id=?'
            );
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

    $_SESSION['message'] = $message;
    header('Location: leads.php');
    exit;
}

$properties = $conn->query("SELECT id, project_name FROM properties ORDER BY project_name");

// Pagination setup
$perPage = 6;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;

$totalResult = $conn->query("SELECT COUNT(*) AS cnt FROM leads");
$totalLeads = $totalResult ? (int)$totalResult->fetch_assoc()['cnt'] : 0;
$totalPages = (int)ceil($totalLeads / $perPage);
$offset = ($page - 1) * $perPage;

$leads = $conn->query(
    "SELECT leads.*, properties.project_name FROM leads LEFT JOIN properties ON leads.property_id = properties.id ORDER BY leads.created_at DESC LIMIT $perPage OFFSET $offset"
);
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
                            <div class="row g-4">
                                <?php if ($leads && $leads->num_rows > 0): while ($l = $leads->fetch_assoc()): ?>
                                        <div class="col-md-6 col-xl-4">
                                            <div class="lead-card">
                                                <div class="lead-card__body">
                                                    <div class="lead-card__header">
                                                        <div class="lead-card__avatar">
                                                            <?php if (isset($l['avatar']) && !empty($l['avatar'])): ?>
                                                                <img src="<?php echo htmlspecialchars($l['avatar']); ?>" alt="Avatar">
                                                            <?php else: ?>
                                                                <img src="assets/images/users/default-avatar.jpg" alt="Avatar">
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="lead-card__identity">
                                                            <h5 class="lead-card__name"><?php echo htmlspecialchars($l['name']); ?></h5>
                                                            <p class="lead-card__email"><?php echo htmlspecialchars($l['email']); ?></p>
                                                        </div>
                                                    </div>

                                                    <?php
                                                    // Make status classes without Bootstrap
                                                    $statusText = isset($l['status']) ? trim(strtolower($l['status'])) : 'interested';
                                                    $statusClass = 'status--info';
                                                    switch ($statusText) {
                                                        case 'interested':
                                                            $statusClass = 'status--success';
                                                            break;
                                                        case 'not interested':
                                                            $statusClass = 'status--danger';
                                                            break;
                                                        case 'cold':
                                                            $statusClass = 'status--cold';
                                                            break;
                                                        case 'hot':
                                                            $statusClass = 'status--hot';
                                                            break;
                                                    }
                                                    ?>

                                                    <div class="lead-card__kv">
                                                        <div class="lead-card__label">Property</div>
                                                        <div class="lead-card__value"><?php echo htmlspecialchars($l['project_name'] ?? ''); ?></div>

                                                        <div class="lead-card__label">Status</div>
                                                        <div class="lead-card__value">
                                                            <span class="lead-card__status <?php echo $statusClass; ?>">
                                                                <?php echo htmlspecialchars($l['status'] ?? 'Interested'); ?>
                                                            </span>
                                                        </div>

                                                        <div class="lead-card__label">Date</div>
                                                        <div class="lead-card__value">
                                                            <?php echo date('d/m/Y', strtotime($l['created_at'])); ?>
                                                        </div>
                                                    </div>

                                                    <div class="lead-card__actions">
                                                        <button type="button" class="btn btn--edit edit-lead-btn"
                                                            data-id="<?php echo $l['id']; ?>"
                                                            data-name="<?php echo htmlspecialchars($l['name']); ?>"
                                                            data-email="<?php echo htmlspecialchars($l['email']); ?>"
                                                            data-phone="<?php echo htmlspecialchars($l['phone']); ?>"
                                                            data-property="<?php echo htmlspecialchars($l['property_id']); ?>"
                                                            data-status="<?php echo htmlspecialchars($l['status']); ?>"
                                                            data-message="<?php echo htmlspecialchars($l['message']); ?>">
                                                            Edit
                                                        </button>

                                                        <a href="leads.php?delete=<?php echo $l['id']; ?>" class="btn btn--delete"
                                                            onclick="return confirm('Are you sure you want to delete this lead?');">
                                                            Delete
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    <?php endwhile;
                                else: ?>
                                    <div class="col-12">
                                        <p class="text-center mb-0">No leads found</p>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <?php if ($totalPages > 1): ?>
                                <nav aria-label="Lead pagination">
                                    <ul class="pagination justify-content-center mt-4">
                                        <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="leads.php?page=<?php echo max(1, $page - 1); ?>" aria-label="Previous">
                                                <i class="ri-arrow-left-s-line"></i>
                                            </a>
                                        </li>
                                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                                <a class="page-link" href="leads.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                            </li>
                                        <?php endfor; ?>
                                        <li class="page-item <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="leads.php?page=<?php echo min($totalPages, $page + 1); ?>" aria-label="Next">
                                                <i class="ri-arrow-right-s-line"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="leadModal" tabindex="-1" aria-labelledby="leadModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="leads.php" method="POST" enctype="multipart/form-data" id="lead-form">
                            <div class="modal-header">
                                <h5 class="modal-title" id="leadModalLabel">Add Lead</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id" id="lead-id" />
                                <div class="row g-3">
                                    <div class="col-lg-12">
                                        <label for="lead-name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="lead-name" name="name" required>
                                    </div>
                                    <div class="col-lg-12">
                                        <label for="lead-email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="lead-email" name="email" required>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="lead-phone" class="form-label">Phone</label>
                                        <input type="text" class="form-control" id="lead-phone" name="phone">
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="lead-property" class="form-label">Property</label>
                                        <select class="form-select" id="lead-property" name="property_id">
                                            <option value="0">Select Property</option>
                                            <?php if ($properties && $properties->num_rows > 0): while ($p = $properties->fetch_assoc()): ?>
                                                    <option value="<?php echo $p['id']; ?>"><?php echo htmlspecialchars($p['project_name']); ?></option>
                                            <?php endwhile;
                                            endif; ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="lead-status" class="form-label">Status</label>
                                        <select class="form-select" id="lead-status" name="status">
                                            <option value="Interested">Interested</option>
                                            <option value="Not Interested">Not Interested</option>
                                            <option value="Cold">Cold</option>
                                            <option value="Hot">Hot</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="lead-avatar" class="form-label">Profile Image</label>
                                        <input type="file" class="form-control" id="lead-avatar" name="avatar" accept="image/*">
                                    </div>
                                    <!-- <div class="col-lg-12">
                                        <label for="lead-message" class="form-label">Message</label>
                                        <textarea class="form-control" id="lead-message" name="message" rows="3"></textarea>
                                    </div> -->
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
        btn.addEventListener('click', function() {
            const modalEl = document.getElementById('leadModal');
            document.getElementById('leadModalLabel').innerText = 'Edit Lead';
            document.getElementById('lead-id').value = this.dataset.id;
            document.getElementById('lead-name').value = this.dataset.name;
            document.getElementById('lead-email').value = this.dataset.email;
            document.getElementById('lead-phone').value = this.dataset.phone;
            document.getElementById('lead-property').value = this.dataset.property;
            document.getElementById('lead-status').value = this.dataset.status;
            const messageEl = document.getElementById('lead-message');
            if (messageEl) {
                messageEl.value = this.dataset.message;
            }
            new bootstrap.Modal(modalEl).show();
        });
    });

    document.getElementById('addLeadBtn').addEventListener('click', () => {
        document.getElementById('leadModalLabel').innerText = 'Add Lead';
        document.getElementById('lead-form').reset();
        document.getElementById('lead-id').value = '';
    });

    const alertEl = document.querySelector('.alert');
    if (alertEl) {
        setTimeout(() => {
            bootstrap.Alert.getOrCreateInstance(alertEl).close();
        }, 5000);
    }
</script>
<?php include 'includes/common-footer.php'; ?>
