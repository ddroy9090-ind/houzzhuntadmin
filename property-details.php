<?php
include 'includes/auth.php';
include 'includes/common-header.php';
include 'config.php';

// Fetch property by ID if provided; otherwise show latest property
$property = null;
$property_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($property_id > 0) {
    // Use prepared statement to safely fetch requested property
    $stmt = $conn->prepare("SELECT * FROM properties WHERE id = ? LIMIT 1");
    $stmt->bind_param('i', $property_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $property = $result->fetch_assoc();
    $stmt->close();
} else {
    // Fall back to the most recent property
    $result = $conn->query("SELECT * FROM properties ORDER BY id DESC LIMIT 1");
    $property = $result->fetch_assoc();
}

// If no property found, stop rendering to avoid undefined index notices
if (!$property) {
    echo '<div class="main-content"><div class="page-content"><div class="container"><p>Property not found.</p></div></div></div>';
    include 'includes/common-footer.php';
    exit;
}

$heroImage = !empty($property['main_picture'])
    ? 'uploads/' . $property['main_picture']
    : 'assets/images/banner/hero-banner.webp';
?>

<div class="main-content">
    <div class="page-content">

        <!-- Hero Section -->
        <section class="hero-section" style="background-image: url('<?= $heroImage ?>');">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-10 text-center">
                        <div class="hero-description">
                            <h1><?= $property['project_name']; ?></h1>
                            <h5><?= $property['sub_heading']; ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Project Header Section -->
        <section class="project-header">
            <div class="container text-center">
                <div class="row">
                    <div class="col-12">
                        <h2 class="fw-bold">Download Brochure</h2>
                        <p class="subtitle">Live the Vibe WHERE THE VIBE MEETS HOME</p>
                    </div>
                    <div class="col-12 mt-3">
                        <div class="d-flex justify-content-center gap-3 flex-wrap">
                            <?php if (!empty($property['brochure'])): ?>
                                <a href="uploads/<?= htmlspecialchars($property['brochure']); ?>" class="btn-custom"
                                    download>
                                    Download Brochure
                                    <i class="bi bi-download"></i>
                                </a>
                            <?php endif; ?>
                            <a href="leads.php" class="btn-custom">
                                Enquire Now
                                <i class="bi bi-arrow-right"></i>
                            </a>
                            <a href="#" class="share-icon">
                                <i class="bi bi-share"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Community Section -->
        <section class="community-section">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Left Column (Stats) -->
                    <div class="col-md-5">
                        <p>Starting Price</p>
                        <h5>
                            <span class="currency-symbol"></span>
                            <span data-base-amount="<?= htmlspecialchars($property['starting_price']); ?>">
                                <?= htmlspecialchars($property['starting_price']); ?>
                            </span>
                        </h5>

                        <p>Payment Plan</p>
                        <h5><?= $property['payment_plan']; ?></h5>

                        <p>Project Handover</p>
                        <h5><?= $property['handover']; ?></h5>
                    </div>

                    <!-- Right Column (Content) -->
                    <div class="col-md-7">
                        <div class="texture-right">
                            <h2 class="heading-title"><span
                                    class="whiteYellow"><?= $property['project_heading']; ?></span></h2>
                            <p><?= $property['project_details']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Property Gallery Section -->
        <section class="property-gallery-section">
            <div class="container-fluid">
                <div class="row g-3">
                    <!-- Left Large Image -->
                    <div class="col-12 col-lg-8 position-relative">
                        <div class="swiper main-swiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="https://d33om22pidobo4.cloudfront.net/projects/featuredimages/frame-37160png-343fecfa-3bee-4958-897c-d71777a0bcb2.png?d=1000x666&f=webp"
                                        alt="Building" class="img-fluid w-100 rounded">
                                </div>
                                <div class="swiper-slide">
                                    <img src="https://d33om22pidobo4.cloudfront.net/projects/gallery/4jpg-727f9584-8b71-47df-add6-acced22a441d.jpg?d=500x333&f=webp"
                                        alt="Alternate Building" class="img-fluid w-100 rounded">
                                </div>
                            </div>
                            <!-- Navigation -->
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>

                    <!-- Right Side Images -->
                    <div class="col-12 col-lg-4">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="swiper side-swiper">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <img src="https://d33om22pidobo4.cloudfront.net/projects/gallery/4jpg-727f9584-8b71-47df-add6-acced22a441d.jpg?d=500x333&f=webp"
                                                alt="Jacuzzi" class="img-fluid w-100 rounded">
                                        </div>
                                        <div class="swiper-slide">
                                            <img src="https://d33om22pidobo4.cloudfront.net/projects/gallery/5jpg-dbb4e1d6-8f7d-44cf-8660-e93edec0a993.jpg?d=500x333&f=webp"
                                                alt="Living Room" class="img-fluid w-100 rounded">
                                        </div>
                                    </div>
                                    <!-- Navigation -->
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-button-prev"></div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="swiper side-swiper">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <img src="https://d33om22pidobo4.cloudfront.net/projects/gallery/5jpg-dbb4e1d6-8f7d-44cf-8660-e93edec0a993.jpg?d=500x333&f=webp"
                                                alt="Living Room" class="img-fluid w-100 rounded">
                                        </div>
                                        <div class="swiper-slide">
                                            <img src="https://d33om22pidobo4.cloudfront.net/projects/gallery/4jpg-727f9584-8b71-47df-add6-acced22a441d.jpg?d=500x333&f=webp"
                                                alt="Jacuzzi" class="img-fluid w-100 rounded">
                                        </div>
                                    </div>
                                    <!-- Navigation -->
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-button-prev"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Amenities Section -->
        <section class="property-amenities">
            <div class="container">
                <div class="row text-center mb-4">
                    <div class="col-12">
                        <h2 class="heading-title"><span class="whiteYellow">Amenities</span></h2>
                    </div>
                </div>
                <div class="row g-4">
                    <?php
                    if (!empty($property['amenities'])) {
                        $amenities = explode(",", $property['amenities']);
                        foreach ($amenities as $amenity): ?>
                            <div class="col-md-4 col-sm-6">
                                <div class="amenity-box">
                                    <img src="assets/icons/gym.png" alt="Amenity">
                                    <p><?= trim($amenity); ?></p>
                                </div>
                            </div>
                        <?php endforeach;
                    } ?>
                </div>
            </div>
        </section>

        <div class="floorplan-container">
            <!-- LEFT SECTION -->
            <div class="floorplan-left">
                <div class="swiper mySwiper1">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="https://a.storyblok.com/f/165304/668x690/d73ba1d330/gardenia-bay-floor-plan.png"
                                alt="Floorplan 1">
                            <div class="floorplan-details">
                                <div><strong>8.5M AED</strong> Starting price</div>
                                <div><strong>12,108 AED</strong> per ft²</div>
                                <div><strong>702 ft²</strong> Starting area</div>
                            </div>
                            <a href="#" class="gradient-btn btn-green-glossy mt-3">Green Glossy</a>
                        </div>
                        <div class="swiper-slide">
                            <img src="https://a.storyblok.com/f/165304/996x668/1a83678dd5/gardenia-bay-floor-plan.png"
                                alt="Floorplan 2">
                            <div class="floorplan-details">
                                <div><strong>7.2M AED</strong> Starting price</div>
                                <div><strong>10,500 AED</strong> per ft²</div>
                                <div><strong>620 ft²</strong> Starting area</div>
                            </div>
                            <a href="#" class="gradient-btn btn-green-glossy mt-3">Green Glossy</a>
                        </div>
                        <div class="swiper-slide">
                            <img src="https://a.storyblok.com/f/165304/1322x750/97d0d615e6/gardenia-bay-floor-plan.png"
                                alt="Floorplan 3">
                            <div class="floorplan-details">
                                <div><strong>9M AED</strong> Starting price</div>
                                <div><strong>13,000 AED</strong> per ft²</div>
                                <div><strong>780 ft²</strong> Starting area</div>
                            </div>
                            <a href="#" class="gradient-btn btn-green-glossy mt-3">Green Glossy</a>
                        </div>
                    </div>
                    <!-- Swiper buttons -->
                    <div class="swiper-button-prev">&#8592;</div>
                    <div class="swiper-button-next"> &#8594;</div>
                </div>
            </div>

            <!-- RIGHT SECTION -->
            <div class="floorplan-right">
                <h3>Get all the floor plans <br> and the best offers in this project</h3>
                <img src="https://houzzhunt.com/assets/images/homepage/help-contact.webp" alt="3D Plan 1">
                <button class="right-btn">→</button>
            </div>
        </div>

        <!-- Payment Plan Section -->
        <section class="payment-plan-section d-none">
            <div class="container">
                <div class="row justify-content-center mb-4">
                    <div class="col-12 text-center">
                        <h2 class="payment-title heading-title"><span>Payment Plan</span></h2>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <!-- Box 1 -->
                    <div class="col-md-3 col-12 mb-3">
                        <div class="payment-box text-center p-4">
                            <h4 class=" mb-2">12%</h4>
                            <p class="mb-0">DOWN PAYMENT</p>
                        </div>
                    </div>
                    <!-- Box 2 -->
                    <div class="col-md-3 col-12 mb-3">
                        <div class="payment-box text-center p-4">
                            <h4 class=" mb-2">48%</h4>
                            <p class="mb-0">DURING CONSTRUCTION</p>
                        </div>
                    </div>
                    <!-- Box 3 -->
                    <div class="col-md-3 col-12 mb-3">
                        <div class="payment-box text-center p-4">
                            <h4 class=" mb-2">40%</h4>
                            <p class="mb-0">ON HANDOVER</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Nearby Places Section -->
        <section class="nearby-places">
            <div class="container">
                <div class="row justify-content-center mb-4">
                    <div class="col-12 text-center mt-4">
                        <h2 class="heading-title"><span>Nearby Places of Aspirz at Dubai Sports City</span></h2>
                    </div>
                </div>

                <!-- Google Map -->
                <?php
                $defaultMap = "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d115619.66473777338!2d55.17128!3d25.204849!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e5f434f8dfdf0b7%3A0x28f3f8b35e5a2c2c!2sDubai!5e0!3m2!1sen!2sae!4v1692184877643!5m2!1sen!2sae";
                $mapSrc = !empty($property['location'])
                    ? 'https://www.google.com/maps?q=' . urlencode($property['location']) . '&z=15&output=embed'
                    : $defaultMap;
                ?>
                <div class="map-container mb-4">
                    <iframe src="<?= $mapSrc ?>" width="100%" height="500" style="border:0;" allowfullscreen=""
                        loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>

                <!-- Nearby Places Icons -->
                <div class="row text-center justify-content-center">
                    <div class="col-md-3 col-6 mb-4">
                        <img src="assets/icons/location.png" width="50" alt="Burj Al Arab">
                        <h6 class="mt-2">Burj Al Arab</h6>
                        <small class="text-muted"><?php echo $property['burj_al_arab']; ?> Minutes</small>
                    </div>
                    <div class="col-md-3 col-6 mb-4">
                        <img src="assets/icons/marina.png" width="50" alt="Dubai Marina">
                        <h6 class="mt-2">Dubai Marina</h6>
                        <small class="text-muted"><?php echo $property['dubai_marina']; ?> Minutes</small>
                    </div>
                    <div class="col-md-3 col-6 mb-4">
                        <img src="assets/icons/phone.png" width="50" alt="Dubai Mall">
                        <h6 class="mt-2">Dubai Mall</h6>
                        <small class="text-muted"><?php echo $property['dubai_mall']; ?> Minutes</small>
                    </div>
                    <div class="col-md-3 col-6 mb-4">
                        <img src="assets/icons/route.png" width="50" alt="Sheikh Zayed Road">
                        <h6 class="mt-2">Sheikh Zayed Road</h6>
                        <small class="text-muted"><?php echo $property['sheikh_zayed']; ?> Minutes</small>
                    </div>
                </div>

            </div>
        </section>

        <section class="related-properties">
            <div class="container">

                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <h2 class="payment-title heading-title"><span>Other properties that may interest you</span></h2>
                    </div>
                </div>

                <div class="row g-4">

                    <!-- Property Card 1 -->
                    <div class="col-md-3 col-sm-6">
                        <div class="card h-100 shadow-sm border-0">
                            <img src="https://ggfx-handh3.s3.eu-west-2.amazonaws.com/x/750x506/ADDRESS_VILLAS_TIERRA_hausandhaus_2_154caeebd6.webp"
                                class="card-img-top" alt="Belmont Residences">
                            <div class="card-body">
                                <h6 class=" mb-1">Belmont Residences</h6>
                                <p class="mb-0 text-muted small">by ELLINGTON</p>
                            </div>
                        </div>
                    </div>

                    <!-- Property Card 2 -->
                    <div class="col-md-3 col-sm-6">
                        <div class="card h-100 shadow-sm border-0">
                            <img src="https://ggfx-handh3.s3.eu-west-2.amazonaws.com/x/750x506/OASIS_PALMIERA_x_hausandhaus_1_e125317ee0.webp"
                                class="card-img-top" alt="FH Residency">
                            <div class="card-body">
                                <h6 class=" mb-1">FH Residency</h6>
                                <p class="mb-0 text-muted small">by Forum Real Estate Development</p>
                            </div>
                        </div>
                    </div>

                    <!-- Property Card 3 -->
                    <div class="col-md-3 col-sm-6">
                        <div class="card h-100 shadow-sm border-0">
                            <img src="https://ggfx-handh3.s3.eu-west-2.amazonaws.com/x/750x506/The_Oasis_Mirage_7df4992efc.webp"
                                class="card-img-top" alt="Elaya">
                            <div class="card-body">
                                <h6 class=" mb-1">Elaya</h6>
                                <p class="mb-0 text-muted small">by Nshama</p>
                            </div>
                        </div>
                    </div>

                    <!-- Property Card 4 -->
                    <div class="col-md-3 col-sm-6">
                        <div class="card h-100 shadow-sm border-0">
                            <img src="https://ggfx-handh3.s3.eu-west-2.amazonaws.com/x/750x506/19560_photo_1628518170.webp"
                                class="card-img-top" alt="Gardenia Bay">
                            <div class="card-body">
                                <h6 class=" mb-1">Gardenia Bay</h6>
                                <p class="mb-0 text-muted small">by ALDAR</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>


        <section class="mortgage-section">
            <div class="container">
                <div class="row g-4">
                    <!-- Card 1 -->
                    <div class="col-md-4">
                        <div class="card custom-card text-white">
                            <img src="https://ggfx-handh3.s3.eu-west-2.amazonaws.com/x/750x506/ADDRESS_VILLAS_TIERRA_hausandhaus_2_154caeebd6.webp"
                                class="card-img" alt="Getting a Mortgage">
                            <div class="card-overlay"></div>
                            <div class="card-img-overlay d-flex flex-column justify-content-center text-center">
                                <h5 class="card-title text-uppercase text-white">Getting a Mortgage</h5>
                                <p class="card-text text-capitalize">
                                    Mira mortgage is a perfect key for your dream home opportunities
                                </p>
                                <div class="mt-2">
                                    <a href="#" class="btn btn-light rounded-circle">
                                        <span>&#8594;</span>
                                    </a>
                                </div>
                                <div class="mt-auto">
                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcREpBayBrjFn05lN_5dEYqebr4DpAIVRR5F8Q&s"
                                        alt="Mira Logo" class="img-fluid" style="max-height: 30px;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="col-md-4">
                        <div class="card custom-card text-white">
                            <img src="https://ggfx-handh3.s3.eu-west-2.amazonaws.com/x/750x506/ADDRESS_VILLAS_TIERRA_hausandhaus_2_154caeebd6.webp"
                                class="card-img" alt="Getting a Mortgage">
                            <div class="card-overlay"></div>
                            <div class="card-img-overlay d-flex flex-column justify-content-center text-center">
                                <h5 class="card-title text-uppercase text-white">Getting a Mortgage</h5>
                                <p class="card-text text-capitalize">
                                    Mira mortgage is a perfect key for your dream home opportunities
                                </p>
                                <div class="mt-2">
                                    <a href="#" class="btn btn-light rounded-circle">
                                        <span>&#8594;</span>
                                    </a>
                                </div>
                                <div class="mt-auto">
                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcREpBayBrjFn05lN_5dEYqebr4DpAIVRR5F8Q&s"
                                        alt="Mira Logo" class="img-fluid" style="max-height: 30px;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3 -->

                    <div class="col-md-4">
                        <div class="card custom-card text-white">
                            <img src="https://ggfx-handh3.s3.eu-west-2.amazonaws.com/x/750x506/ADDRESS_VILLAS_TIERRA_hausandhaus_2_154caeebd6.webp"
                                class="card-img" alt="Getting a Mortgage">
                            <div class="card-overlay"></div>
                            <div class="card-img-overlay d-flex flex-column justify-content-center text-center">
                                <h5 class="card-title text-uppercase text-white">Getting a Mortgage</h5>
                                <p class="card-text text-capitalize">
                                    Mira mortgage is a perfect key for your dream home opportunities
                                </p>
                                <div class="mt-2">
                                    <a href="#" class="btn btn-light rounded-circle">
                                        <span>&#8594;</span>
                                    </a>
                                </div>
                                <div class="mt-auto">
                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcREpBayBrjFn05lN_5dEYqebr4DpAIVRR5F8Q&s"
                                        alt="Mira Logo" class="img-fluid" style="max-height: 30px;">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </div>
    <?php include 'includes/footer.php' ?>
</div>

<?php include 'includes/common-footer.php'; ?>