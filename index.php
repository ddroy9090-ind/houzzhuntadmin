<?php
include 'includes/auth.php';
include 'config.php';

// Show PHP errors instead of a blank page if something goes wrong
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Helper function to safely fetch a single count value from the database
function fetch_count(mysqli $conn, string $query): int {
    $result = $conn->query($query);
    return $result ? (int)$result->fetch_assoc()['c'] : 0;
}

$totalProperties = fetch_count($conn, "SELECT COUNT(*) AS c FROM properties");
$totalLeads       = fetch_count($conn, "SELECT COUNT(*) AS c FROM leads");
$totalUsers       = fetch_count($conn, "SELECT COUNT(*) AS c FROM users");
$todayLeads       = fetch_count($conn, "SELECT COUNT(*) AS c FROM leads WHERE DATE(created_at)=CURDATE()");

// Run queries for recent items and handle potential failures gracefully
// Fetch latest properties including main image for card display
$recentProperties = $conn->query("SELECT id, project_name, location, starting_price, main_picture FROM properties ORDER BY created_at DESC LIMIT 5");
$recentLeads      = $conn->query("SELECT leads.id, leads.name, leads.email, leads.avatar, leads.status, properties.project_name, leads.created_at FROM leads LEFT JOIN properties ON leads.property_id = properties.id ORDER BY leads.created_at DESC LIMIT 5");

// Fetch all project names and locations for map markers
$projectLocations = $conn->query("SELECT project_name, location FROM properties");
$projectMarkers = [];
if ($projectLocations) {
    while ($row = $projectLocations->fetch_assoc()) {
        $projectMarkers[] = $row;
    }
}
?>

<?php include 'includes/common-header.php'; ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="h-100">

                        <div class="row mb-3 pb-1">
                            <div class="col-12">
                                <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                    <div class="flex-grow-1">
                                        <h4 class="fs-16 mb-1">Good Morning, <?php echo htmlspecialchars($userName); ?>!
                                        </h4>
                                        <p class="text-muted mb-0">Here's what's happening with your Portal
                                            today.</p>
                                    </div>
                                    <div class="mt-3 mt-lg-0">
                                        <form action="javascript:void(0);">
                                            <div class="row g-3 mb-0 align-items-center">
                                                <div class="col-auto">
                                                    <a href="add-property.php" type="button"
                                                        class="btn btn-soft-success material-shadow-none"><i
                                                            class="ri-add-circle-line align-middle me-1"></i>
                                                        Add Property</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row">

                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                    Total Properties</p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <h5 class="text-success fs-14 mb-0">
                                                    <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                                                    +16.24 %
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                        class="counter-value"
                                                        data-target="<?php echo $totalProperties; ?>">0</span>
                                                </h4>
                                                <a href="all-properties.php" class="text-decoration-underline">View
                                                    properties</a>
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-success-subtle rounded fs-3">
                                                    <i class="bx bx-buildings text-success"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                    Total Leads</p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <h5 class="text-danger fs-14 mb-0">
                                                    <i class="ri-arrow-right-down-line fs-13 align-middle"></i>
                                                    -3.57 %
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                        class="counter-value"
                                                        data-target="<?php echo $totalLeads; ?>">0</span></h4>
                                                <a href="leads.php" class="text-decoration-underline">View leads</a>
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-info-subtle rounded fs-3">
                                                    <i class="bx bx-user-voice text-info"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                    Channel Partners</p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <h5 class="text-success fs-14 mb-0">
                                                    <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                                                    +29.08 %
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                        class="counter-value"
                                                        data-target="<?php echo $totalUsers; ?>">0</span>
                                                </h4>
                                                <a href="users.php" class="text-decoration-underline">View users</a>
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-warning-subtle rounded fs-3">
                                                    <i class="bx bx-user-circle text-warning"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Leads
                                                    Today</p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <h5 class="text-muted fs-14 mb-0">
                                                    +0.00 %
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                        class="counter-value"
                                                        data-target="<?php echo $todayLeads; ?>">0</span>
                                                </h4>
                                                <a href="leads.php" class="text-decoration-underline">View leads</a>
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-primary-subtle rounded fs-3">
                                                    <i class="bx bx-trending-up text-primary"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-xl-8">
                                <div class="card">
                                    <div class="card-header border-0 align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Property Details</h4>
                                        <div>
                                            <button type="button"
                                                class="btn btn-soft-secondary material-shadow-none btn-sm">
                                                ALL
                                            </button>
                                            <button type="button"
                                                class="btn btn-soft-secondary material-shadow-none btn-sm">
                                                1M
                                            </button>
                                            <button type="button"
                                                class="btn btn-soft-secondary material-shadow-none btn-sm">
                                                6M
                                            </button>
                                            <button type="button"
                                                class="btn btn-soft-primary material-shadow-none btn-sm">
                                                1Y
                                            </button>
                                        </div>
                                    </div><!-- end card header -->

                                    <div class="card-header p-0 border-0 bg-light-subtle">
                                        <div class="row g-0 text-center">
                                            <div class="col-6 col-sm-3">
                                                <div class="p-3 border border-dashed border-start-0">
                                                    <h5 class="mb-1"><span class="counter-value" data-target="<?php echo $totalProperties; ?>">0</span></h5>
                                                    <p class="text-muted mb-0">Total Properties</p>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-6 col-sm-3">
                                                <div class="p-3 border border-dashed border-start-0">
                                                    <h5 class="mb-1"><span class="counter-value" data-target="<?php echo $totalLeads; ?>">0</span></h5>
                                                    <p class="text-muted mb-0">Total Leads</p>
                                                </div>
                                            </div>
        <!--end col-->
                                            <div class="col-6 col-sm-3">
                                                <div class="p-3 border border-dashed border-start-0">
                                                    <h5 class="mb-1"><span class="counter-value" data-target="<?php echo $totalUsers; ?>">0</span></h5>
                                                    <p class="text-muted mb-0">Channel Partners</p>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-6 col-sm-3">
                                                <div class="p-3 border border-dashed border-start-0 border-end-0">
                                                    <h5 class="mb-1"><span class="counter-value" data-target="<?php echo $todayLeads; ?>">0</span></h5>
                                                    <p class="text-muted mb-0">Leads Today</p>
                                                </div>
                                            </div>
                                            <!--end col-->
                                        </div>
                                    </div><!-- end card header -->

                                    <div class="card-body p-0 pb-2">
                                        <div class="w-100">
                                            <div id="customer_impression_charts"
                                                data-colors='["#0ab39c", "#299cdb", "#f7b84b", "#5b73e8"]'
                                                class="apex-charts" dir="ltr"></div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->

                            <div class="col-xl-4">
                                <!-- card -->
                                <div class="card card-height-100">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Sales by Locations</h4>
                                        <div class="flex-shrink-0">
                                            <button type="button"
                                                class="btn btn-soft-primary material-shadow-none btn-sm">
                                                Export Report
                                            </button>
                                        </div>
                                    </div><!-- end card header -->

                                    <!-- card body -->
                                    <div class="card-body">

                                        <div id="sales-by-locations"
                                            data-colors='["--vz-light", "--vz-success", "--vz-primary"]'
                                            data-colors-interactive='["--vz-light", "--vz-info", "--vz-primary"]'
                                            style="height: 269px" dir="ltr"></div>

                                        <div class="px-2 py-2 mt-1">
                                            <p class="mb-1">Dubai <span class="float-end">75%</span></p>
                                            <div class="progress mt-2" style="height: 6px;">
                                                <div class="progress-bar progress-bar-striped bg-primary"
                                                    role="progressbar" style="width: 75%" aria-valuenow="75"
                                                    aria-valuemin="0" aria-valuemax="75"></div>
                                            </div>

                                            <p class="mt-3 mb-1">Abu Dhabi <span class="float-end">47%</span>
                                            </p>
                                            <div class="progress mt-2" style="height: 6px;">
                                                <div class="progress-bar progress-bar-striped bg-primary"
                                                    role="progressbar" style="width: 47%" aria-valuenow="47"
                                                    aria-valuemin="0" aria-valuemax="47"></div>
                                            </div>

                                            <p class="mt-3 mb-1">Sharjah <span class="float-end">82%</span></p>
                                            <div class="progress mt-2" style="height: 6px;">
                                                <div class="progress-bar progress-bar-striped bg-primary"
                                                    role="progressbar" style="width: 82%" aria-valuenow="82"
                                                    aria-valuemin="0" aria-valuemax="82"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>



                        <div class="row">

                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Latest Properties</h4>
                                        <div class="flex-shrink-0">
                                            <button type="button" class="btn btn-soft-info btn-sm material-shadow-none">
                                                <i class="ri-file-list-3-line align-middle"></i> Generate Report
                                            </button>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row g-4">
                                            <?php if ($recentProperties && $recentProperties->num_rows > 0): ?>
                                                <?php while ($p = $recentProperties->fetch_assoc()): ?>
                                                    <div class="col-sm-6 col-lg-4 col-xl-3">
                                                        <div class="card h-100">
                                                            <img src="<?= !empty($p['main_picture']) ? 'uploads/' . $p['main_picture'] : 'assets/images/offplan/default.png'; ?>" class="card-img-top" alt="<?= htmlspecialchars($p['project_name']); ?>">
                                                            <div class="card-body">
                                                                <h5 class="card-title mb-2">
                                                                    <a href="property-details.php?id=<?= $p['id']; ?>" class="text-reset">#<?= str_pad($p['id'], 1, '0', STR_PAD_LEFT); ?> <?= htmlspecialchars($p['project_name']); ?></a>
                                                                </h5>
                                                                <p class="mb-2">
                                                                    <i class="ri-map-pin-line align-bottom me-1"></i>
                                                                    <?= htmlspecialchars($p['location']); ?>
                                                                </p>
                                                                <h6 class="mb-0">
                                                                    <i class="ri-price-tag-3-line align-bottom me-1"></i>
                                                                    <?= htmlspecialchars($p['starting_price']); ?>
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endwhile; ?>
                                            <?php else: ?>
                                                <div class="col-12">
                                                    <p class="text-center mb-0">No properties found.</p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div> <!-- .card-->
                            </div> <!-- .col-->
                        </div>

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Recent Leads</h4>
                                        <div class="flex-shrink-0">
                                            <button type="button" class="btn btn-soft-info btn-sm material-shadow-none">
                                                <i class="ri-file-list-3-line align-middle"></i> Download All Leads
                                            </button>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="table-responsive table-card">
                                            <table
                                                class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                                <thead class="text-muted table-light">
                                                    <tr>
                                                        <th scope="col">ID</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Email</th>
                                                        <th scope="col">Property</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php if ($recentLeads && $recentLeads->num_rows > 0): ?>
                                                        <?php while ($l = $recentLeads->fetch_assoc()): ?>
                                                            <tr>
                                                                <td>#<?php echo htmlspecialchars($l['id']); ?></td>
                                                                <td>
                                                                   <div class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0 me-2">
                                                                            <?php if (isset($l['avatar']) && !empty($l['avatar'])): ?>
                                                                                <img src="<?php echo htmlspecialchars($l['avatar']); ?>" alt=""
                                                                                    class="avatar-xs rounded-circle material-shadow" />
                                                                            <?php else: ?>
                                                                                <img src="assets/images/users/default-avatar.jpg" alt=""
                                                                                    class="avatar-xs rounded-circle material-shadow" />
                                                                            <?php endif; ?>
                                                                        </div>
                                                                        <div class="flex-grow-1"><?php echo htmlspecialchars($l['name']); ?></div>
                                                                    </div>
                                                                </td>
                                                                <td><?php echo htmlspecialchars($l['email']); ?></td>
                                                                <td><?php echo htmlspecialchars($l['project_name']); ?></td>
                                                                <td>
                                                                    <?php
                                                                    $statusClass = '';
                                                                    $statusText = isset($l['status']) ? $l['status'] : 'Pending';

                                                                    switch (strtolower($statusText)) {
                                                                        case 'completed':
                                                                        case 'active':
                                                                            $statusClass = 'bg-success-subtle text-success';
                                                                            break;
                                                                        case 'pending':
                                                                            $statusClass = 'bg-warning-subtle text-warning';
                                                                            break;
                                                                        case 'cancelled':
                                                                        case 'rejected':
                                                                            $statusClass = 'bg-danger-subtle text-danger';
                                                                            break;
                                                                        default:
                                                                            $statusClass = 'bg-info-subtle text-info';
                                                                    }
                                                                    ?>
                                                                    <span class="badge <?php echo $statusClass; ?>"><?php echo htmlspecialchars($statusText); ?></span>
                                                                </td>
                                                                <td>
                                                                    <?php echo date('d/m/Y', strtotime($l['created_at'])); ?>
                                                                </td>
                                                            </tr>
                                                        <?php endwhile; ?>
                                                    <?php else: ?>
                                                        <tr>
                                                            <td colspan="6" class="text-center">No leads found.</td>
                                                        </tr>
                                                    <?php endif; ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>


            </div>

        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
    <?php include 'includes/footer.php'; ?>
</div>

<?php include 'includes/common-footer.php'; ?>
