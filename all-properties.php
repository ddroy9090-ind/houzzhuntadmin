<?php
include 'includes/auth.php';
include 'includes/common-header.php';
include 'config.php'; // Database connection

// Fetch distinct project names for filter dropdown
$projectQuery = "SELECT DISTINCT project_name FROM properties WHERE project_name IS NOT NULL AND project_name <> '' ORDER BY project_name";
$projectResult = $conn->query($projectQuery);

// Fetch min and max price to use as slider bounds
$priceQuery = "SELECT MIN(starting_price) AS min_price, MAX(starting_price) AS max_price FROM properties";
$priceBounds = $conn->query($priceQuery)->fetch_assoc();
$minPriceBound = $priceBounds['min_price'] ?? 0;
$maxPriceBound = $priceBounds['max_price'] ?? 0;
$selectedMin = $_GET['min_price'] ?? $minPriceBound;
$selectedMax = $_GET['max_price'] ?? $maxPriceBound;

// Build search query
$where = [];
$types = '';
$params = [];

if (!empty($_GET['project_name'])) {
    $projectName = $_GET['project_name'];
    $where[] = "project_name = ?";
    $types .= 's';
    $params[] = &$projectName;
}
if (!empty($_GET['offplan_name'])) {
    $offplanName = '%' . $_GET['offplan_name'] . '%';
    $where[] = "project_heading LIKE ?";
    $types .= 's';
    $params[] = &$offplanName;
}
if (!empty($_GET['area'])) {
    $area = '%' . $_GET['area'] . '%';
    $where[] = "starting_area LIKE ?";
    $types .= 's';
    $params[] = &$area;
}
if (!empty($_GET['min_price'])) {
    $minPrice = $_GET['min_price'];
    $where[] = "starting_price >= ?";
    $types .= 'd';
    $params[] = &$minPrice;
}
if (!empty($_GET['max_price'])) {
    $maxPrice = $_GET['max_price'];
    $where[] = "starting_price <= ?";
    $types .= 'd';
    $params[] = &$maxPrice;
}

$query = "SELECT * FROM properties";
if ($where) {
    $query .= " WHERE " . implode(" AND ", $where);
}
$query .= " ORDER BY id DESC";

$stmt = $conn->prepare($query);
if ($params) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!-- Select2 & noUiSlider styles -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.7.0/nouislider.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

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

                    <div class="col-12">
                        <form method="GET" class="row g-4 mb-4">
                            <div class="col-md-3">
                                <select name="project_name" class="form-select project-select">
                                    <option value="">Project Name</option>
                                    <?php if ($projectResult && $projectResult->num_rows > 0): ?>
                                        <?php while ($project = $projectResult->fetch_assoc()): ?>
                                            <option value="<?= htmlspecialchars($project['project_name']); ?>"
                                                <?= ((isset($_GET['project_name']) && $_GET['project_name'] === $project['project_name']) ? 'selected' : '') ?>>
                                                <?= htmlspecialchars($project['project_name']); ?>
                                            </option>
                                        <?php endwhile; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="offplan_name" class="form-control" placeholder="Offplan Name"
                                    value="<?= htmlspecialchars($_GET['offplan_name'] ?? '') ?>">
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="area" class="form-control" placeholder="Area"
                                    value="<?= htmlspecialchars($_GET['area'] ?? '') ?>">
                            </div>
                            <div class="col-md-3">
                                <div class="position-relative" style="bottom: 28px;">
                                    <label class="form-label">Price Range</label>
                                    <div id="price-slider" data-min="<?= $minPriceBound ?>"
                                        data-max="<?= $maxPriceBound ?>"></div>
                                    <div class="d-flex justify-content-between">
                                        <span id="price-slider-value"><?= htmlspecialchars($selectedMin) ?> -
                                            <?= htmlspecialchars($selectedMax) ?></span>
                                    </div>
                                    <input type="hidden" name="min_price" id="min-price"
                                        value="<?= htmlspecialchars($selectedMin) ?>">
                                    <input type="hidden" name="max_price" id="max-price"
                                        value="<?= htmlspecialchars($selectedMax) ?>">
                                </div>
                            </div>

                            <div class="col-md-2 d-flex gap-2">
                                <button style="height: 40px;" type="submit" class="btn btn-primary"><i
                                        class="ri-search-line me-1"></i></button>
                                <a style="height: 40px;" href="all-properties.php" class="btn btn-danger"><i
                                        class="ri-refresh-line me-1"></i></a>
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
                                                <img src="uploads/<?= $property['main_picture']; ?>" alt="Main Picture"
                                                    class="img-fluid w-100">
                                            <?php else: ?>
                                                <img src="assets/images/offplan/default.png" alt="No Image" class="img-fluid w-100">
                                            <?php endif; ?>
                                            <div class="p-3">
                                                <div
                                                    class="d-flex align-items-center justify-content-between property-top-details">
                                                    <h5 class="property-title mb-0"><?= $property['status'] ?? 'For Sale'; ?>
                                                    </h5>
                                                    <h5 class="property-title1 mb-0">
                                                        <span class="currency-symbol"></span>
                                                        <span class="price"
                                                            data-base-amount="<?= $property['starting_price'] ?? 0; ?>">
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
                                                        <span><img src="assets/icons/area.png"
                                                                alt=""><?= $property['starting_area'] ?? '-'; ?></span>
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
<!-- jQuery, Select2, and noUiSlider scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.7.0/nouislider.min.js"></script>
<script>
    $(document).ready(function () {
        $('.project-select').select2({
            placeholder: 'Project Name',
            allowClear: true
        });

        var priceSlider = document.getElementById('price-slider');
        if (priceSlider) {
            var min = parseInt(priceSlider.getAttribute('data-min'), 10);
            var max = parseInt(priceSlider.getAttribute('data-max'), 10);
            var startMin = parseInt(document.getElementById('min-price').value || min, 10);
            var startMax = parseInt(document.getElementById('max-price').value || max, 10);
            noUiSlider.create(priceSlider, {
                start: [startMin, startMax],
                connect: true,
                range: {
                    'min': min,
                    'max': max
                }
            });
            var minInput = document.getElementById('min-price');
            var maxInput = document.getElementById('max-price');
            var valueElement = document.getElementById('price-slider-value');
            priceSlider.noUiSlider.on('update', function (values) {
                var minVal = Math.round(values[0]);
                var maxVal = Math.round(values[1]);
                minInput.value = minVal;
                maxInput.value = maxVal;
                valueElement.textContent = minVal + ' - ' + maxVal;
            });
        }
    });
</script>

<?php include 'includes/common-footer.php'; ?>