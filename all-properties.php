<?php
include 'includes/auth.php';
include 'includes/common-header.php';
include 'config.php'; // Database connection

// Fetch all properties
$result = $conn->query("SELECT * FROM properties ORDER BY id DESC"); 
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
