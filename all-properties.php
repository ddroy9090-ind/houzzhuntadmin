<?php
include 'includes/auth.php';
include 'includes/common-header.php';
include 'config.php'; // Database connection

// Retrieve search filters
$search_project_name = $_GET['project_name'] ?? '';
$search_location = $_GET['location'] ?? '';
$min_price = $_GET['min_price'] ?? '';
$max_price = $_GET['max_price'] ?? '';
$min_area = $_GET['min_area'] ?? '';
$max_area = $_GET['max_area'] ?? '';

// Build query with filters
$query = "SELECT * FROM properties";
$conditions = [];
$params = [];
$types = '';

if ($search_project_name !== '') {
    $conditions[] = "project_name LIKE ?";
    $params[] = '%' . $search_project_name . '%';
    $types .= 's';
}

if ($search_location !== '') {
    $conditions[] = "location LIKE ?";
    $params[] = '%' . $search_location . '%';
    $types .= 's';
}

if ($min_price !== '' && is_numeric($min_price)) {
    $conditions[] = "starting_price >= ?";
    $params[] = $min_price;
    $types .= 'd';
}

if ($max_price !== '' && is_numeric($max_price)) {
    $conditions[] = "starting_price <= ?";
    $params[] = $max_price;
    $types .= 'd';
}

if ($min_area !== '' && is_numeric($min_area)) {
    $conditions[] = "CAST(starting_area AS UNSIGNED) >= ?";
    $params[] = $min_area;
    $types .= 'i';
}

if ($max_area !== '' && is_numeric($max_area)) {
    $conditions[] = "CAST(starting_area AS UNSIGNED) <= ?";
    $params[] = $max_area;
    $types .= 'i';
}

if ($conditions) {
    $query .= ' WHERE ' . implode(' AND ', $conditions);
}
$query .= ' ORDER BY id DESC';

$stmt = $conn->prepare($query);
if ($params) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="main-content">
    <div class="page-content">
        <div class="propertiesSection">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="offplan-heading">
                            <h2 class="heading-title mb-2"><span>All Properties Listed here!</span></h2>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <form method="GET" class="row g-2 mb-4">
                            <div class="col-md-3">
                                <input type="text" name="project_name" class="form-control" placeholder="Project Name" value="<?= htmlspecialchars($search_project_name); ?>">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="location" class="form-control" placeholder="Location" value="<?= htmlspecialchars($search_location); ?>">
                            </div>
                            <div class="col-md-2">
                                <input type="number" step="0.01" name="min_price" class="form-control" placeholder="Min Price" value="<?= htmlspecialchars($min_price); ?>">
                            </div>
                            <div class="col-md-2">
                                <input type="number" step="0.01" name="max_price" class="form-control" placeholder="Max Price" value="<?= htmlspecialchars($max_price); ?>">
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="min_area" class="form-control" placeholder="Min Area" value="<?= htmlspecialchars($min_area); ?>">
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="max_area" class="form-control" placeholder="Max Area" value="<?= htmlspecialchars($max_area); ?>">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">Search</button>
                            </div>
                            <div class="col-md-2">
                                <a href="all-properties.php" class="btn btn-secondary w-100">Reset</a>
                            </div>
                        </form>
                    </div>

                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($property = $result->fetch_assoc()): ?>
                            <div class="col-lg-4">
                                <div class="propertiesList">
                                    <div class="property-card">
                                        <a href="property-details.php?id=<?= $property['id']; ?>" class="">
                                            <?php if (!empty($property['main_picture'])): ?>
                                                <img src="uploads/<?= $property['main_picture']; ?>" alt="Main Picture" class="img-fluid w-100">
                                            <?php else: ?>
                                                <img src="assets/images/offplan/default.png" alt="No Image" class="img-fluid w-100">
                                            <?php endif; ?>
                                            <div class="p-3">
                                                <div class="d-flex align-items-center justify-content-between property-top-details">
                                                    <h5 class="property-title mb-0"><?= $property['status'] ?? 'For Sale'; ?></h5>
                                                    <h5 class="property-title1 mb-0">
                                                        <span class="currency-symbol">AED</span>
                                                        <span class="currency-symbol"></span>
                                                        <span class="price" data-base-amount="<?= $property['starting_price'] ?? 0; ?>">
                                                            <?= $property['starting_price'] ?? '-'; ?>
                                                        </span>
                                                    </h5>
                                                </div>
                                                <h5 class="property-name"><?= $property['project_name'] ?? '-'; ?></h5>
                                                <div class="property-info">
                                                    <div class="location">
                                                        <img src="assets/icons/location.png" alt="" width="15">
                                                        <span><?= $property['location'] ?? '-'; ?></span>
                                                    </div>
                                                    <div class="room-details">
                                                        <span><img src="assets/icons/area.png" alt=""><?= $property['starting_area'] ?? '-'; ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <p>No properties found.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</div>

<?php include 'includes/common-footer.php'; ?>
