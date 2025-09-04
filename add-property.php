<?php include 'includes/auth.php'; ?>

<?php include 'includes/common-header.php' ?>
<div class="main-content">

    <div class="page-content">

        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div
                        class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">Add Property</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active">Property Details</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->
        </div>

        <div class="container-fluid">
            <div class="form-card">
                <h4>Add Property Details <small>(Home Details)</small></h4>

                <form id="propertyForm" method="POST" action="save_property.php" enctype="multipart/form-data"
                    class="property-detailsForm">
                    <div class="row">
                        <!-- Project Name -->
                        <div class="mb-3 col-md-6">
                            <label for="project_name" class="form-label">Project Name</label>
                            <input type="text" class="form-control" id="project_name" name="project_name">

                        </div>

                        <!-- Sub heading -->
                        <div class="mb-3 col-md-6">
                            <label for="sub_heading" class="form-label">Sub Heading</label>
                            <input type="text" class="form-control" id="sub_heading" name="sub_heading">

                        </div>

                        <!-- Description -->
                        <!-- <div class="mb-3 col-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>

                        </div> -->

                        <!-- Brochure Upload -->
                        <div class="mb-3 col-12">
                            <label class="form-label">Brochure Upload</label>
                            <div class="custom-upload" onclick="document.getElementById('brochure').click()"
                                ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)"
                                ondrop="handleDrop(event, 'brochure')">
                                <div class="icon"><img width="40" src="assets/icons/upload-pdf.png" alt=""></div>
                                <p>Drop files here or click to upload</p>
                                <input type="file" id="brochure" name="brochure" onchange="showFileName(this)">
                            </div>
                            <div id="file-name-brochure" class="file-name"></div>

                        </div>
                    </div>

                    <h4 class="mt-5">Offplan Details</h4>
                    <div class="row">
                        <!-- Project Heading -->
                        <div class="mb-3 col-md-6">
                            <label for="project_heading" class="form-label">Project Heading</label>
                            <input type="text" class="form-control" id="project_heading" name="project_heading">

                        </div>

                        <!-- Starting Price -->
                        <div class="mb-3 col-md-6">
                            <label for="starting_price" class="form-label">Starting Price</label>
                            <div class="input-group">
                                <span class="input-group-text currency-symbol"></span>
                                <input type="number" class="form-control" id="starting_price" name="starting_price"
                                    data-base-value="0">
                            </div>

                        </div>

                        <!-- Payment Plan -->
                        <div class="mb-3 col-md-6">
                            <label for="payment_plan" class="form-label">Payment Plan</label>
                            <input type="text" class="form-control" id="payment_plan" name="payment_plan">

                        </div>

                        <!-- Project Handover -->
                        <div class="mb-3 col-md-6">
                            <label for="handover" class="form-label">Project Handover</label>
                            <input type="date" class="form-control" id="handover" name="handover">

                        </div>

                        <!-- Project Details -->
                        <div class="mb-3 col-md-12">
                            <label for="project_details" class="form-label">Project Details</label>
                            <textarea class="form-control" id="project_details" name="project_details"
                                rows="3"></textarea>

                        </div>
                    </div>

                    <h4 class="mt-5">Upload Offplan Images</h4>
                    <div class="row">
                        <!-- Main Picture Upload -->
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Main Picture Upload</label>
                            <div class="custom-upload" onclick="document.getElementById('main_picture').click()"
                                ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)"
                                ondrop="handleDrop(event, 'main_picture')">
                                <div class="icon"><img width="40" src="assets/icons/upload-images.png" alt=""></div>
                                <p>Drop files here or click to upload</p>
                                <input type="file" id="main_picture" name="main_picture" onchange="showFileName(this)">
                            </div>
                            <div id="file-name-main_picture" class="file-name"></div>

                        </div>

                        <!-- Gallery Images -->
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Gallery Images</label>
                            <div class="custom-upload" onclick="document.getElementById('gallery_images').click()"
                                ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)"
                                ondrop="handleDrop(event, 'gallery_images')">
                                <div class="icon"><img width="40" src="assets/icons/upload-images.png" alt=""></div>
                                <p>Drop files here or click to upload</p>
                                <input type="file" id="gallery_images" name="gallery_images[]" multiple
                                    onchange="showFileName(this)">
                            </div>
                            <div id="file-name-gallery_images" class="file-name"></div>

                        </div>
                    </div>

                    <!-- Amenities -->
                    <div class="mb-3">
                        <h4 class="mt-5">Amenities</h4>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="amenity1" name="amenities[]"
                                        value="Central Clubhouses And Fitness Facilities">
                                    <label class="form-check-label" for="amenity1">Central Clubhouses And Fitness
                                        Facilities</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="amenity2" name="amenities[]"
                                        value="Lagoon And Natural Waterways">
                                    <label class="form-check-label" for="amenity2">Lagoon And Natural Waterways</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="amenity3" name="amenities[]"
                                        value="33 Km Cycling Trail And 7.1 Km Promenade">
                                    <label class="form-check-label" for="amenity3">33 Km Cycling Trail And 7.1 Km
                                        Promenade</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="amenity4" name="amenities[]"
                                        value="Community Mall And Coastal Retail">
                                    <label class="form-check-label" for="amenity4">Community Mall And Coastal
                                        Retail</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="amenity5" name="amenities[]"
                                        value="Wellness Centre And Spa">
                                    <label class="form-check-label" for="amenity5">Wellness Centre And Spa</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="amenity6" name="amenities[]"
                                        value="Business Park And Sports Complex">
                                    <label class="form-check-label" for="amenity6">Business Park And Sports
                                        Complex</label>
                                </div>
                            </div>

                        </div>

                    </div>

                    <h4 class="mt-5">Floor Plan 1</h4>
                    <div class="row">
                        <!-- Floor Plan -->
                        <div class="mb-3 col-md-6">
                            <label for="floor_plan1" class="form-label">Floor Plan</label>
                            <input type="file" class="form-control" id="floor_plan1" name="floor_plan[]">

                        </div>

                        <!-- Starting Price (renamed) -->
                        <div class="mb-3 col-md-6">
                            <label for="floor_starting_price1" class="form-label">Starting Price (Floor Plan)</label>
                            <div class="input-group">
                                <span class="input-group-text currency-symbol"></span>
                                <input type="text" class="form-control" id="floor_starting_price1"
                                    name="floor_starting_price[]" data-base-value="0">
                            </div>
                        </div>

                        <!-- Price per Sqft -->
                        <div class="mb-3 col-md-6">
                            <label for="aed_per_sqft1" class="form-label">Price per Sqft</label>
                            <div class="input-group">
                                <span class="input-group-text currency-symbol"></span>
                                <input type="text" class="form-control" id="aed_per_sqft1" name="aed_per_sqft[]"
                                    data-base-value="0">
                            </div>

                        </div>

                        <!-- Starting Area -->
                        <div class="mb-3 col-md-6">
                            <label for="starting_area1" class="form-label">Starting Area</label>
                            <input type="text" class="form-control" id="starting_area1" name="starting_area[]">

                        </div>
                    </div>

                    <h4 class="mt-5">Floor Plan 2</h4>
                    <div class="row">
                        <!-- Floor Plan -->
                        <div class="mb-3 col-md-6">
                            <label for="floor_plan2" class="form-label">Floor Plan</label>
                            <input type="file" class="form-control" id="floor_plan2" name="floor_plan[]">

                        </div>

                        <!-- Starting Price (renamed) -->
                        <div class="mb-3 col-md-6">
                            <label for="floor_starting_price2" class="form-label">Starting Price (Floor Plan)</label>
                            <div class="input-group">
                                <span class="input-group-text currency-symbol"></span>
                                <input type="text" class="form-control" id="floor_starting_price2"
                                    name="floor_starting_price[]" data-base-value="0">
                            </div>
                        </div>

                        <!-- Price per Sqft -->
                        <div class="mb-3 col-md-6">
                            <label for="aed_per_sqft2" class="form-label">Price per Sqft</label>
                            <div class="input-group">
                                <span class="input-group-text currency-symbol"></span>
                                <input type="text" class="form-control" id="aed_per_sqft2" name="aed_per_sqft[]"
                                    data-base-value="0">
                            </div>

                        </div>

                        <!-- Starting Area -->
                        <div class="mb-3 col-md-6">
                            <label for="starting_area2" class="form-label">Starting Area</label>
                            <input type="text" class="form-control" id="starting_area2" name="starting_area[]">

                        </div>
                    </div>

                    <h4 class="mt-5">Floor Plan 3</h4>
                    <div class="row">
                        <!-- Floor Plan -->
                        <div class="mb-3 col-md-6">
                            <label for="floor_plan3" class="form-label">Floor Plan</label>
                            <input type="file" class="form-control" id="floor_plan3" name="floor_plan[]">

                        </div>

                        <!-- Starting Price (renamed) -->
                        <div class="mb-3 col-md-6">
                            <label for="floor_starting_price3" class="form-label">Starting Price (Floor Plan)</label>
                            <div class="input-group">
                                <span class="input-group-text currency-symbol"></span>
                                <input type="text" class="form-control" id="floor_starting_price3"
                                    name="floor_starting_price[]" data-base-value="0">
                            </div>
                        </div>

                        <!-- Price per Sqft -->
                        <div class="mb-3 col-md-6">
                            <label for="aed_per_sqft3" class="form-label">Price per Sqft</label>
                            <div class="input-group">
                                <span class="input-group-text currency-symbol"></span>
                                <input type="text" class="form-control" id="aed_per_sqft3" name="aed_per_sqft[]"
                                    data-base-value="0">
                            </div>

                        </div>

                        <!-- Starting Area -->
                        <div class="mb-3 col-md-6">
                            <label for="starting_area3" class="form-label">Starting Area</label>
                            <input type="text" class="form-control" id="starting_area3" name="starting_area[]">

                        </div>
                    </div>


                    <div class="row">

                        <h4 class="mt-5">Nearby Places</h4>

                        <!-- Burj Al Arab -->
                        <div class="mb-3 col-md-6">
                            <label for="burj_al_arab" class="form-label">Burj Al Arab</label>
                            <input type="number" step="0.01" class="form-control" id="burj_al_arab" name="burj_al_arab">
                        </div>

                        <!-- Dubai Marina -->
                        <div class="mb-3 col-md-6">
                            <label for="dubai_marina" class="form-label">Dubai Marina</label>
                            <input type="number" step="0.01" class="form-control" id="dubai_marina" name="dubai_marina">
                        </div>

                        <!-- Dubai Mall -->
                        <div class="mb-3 col-md-6">
                            <label for="dubai_mall" class="form-label">Dubai Mall</label>
                            <input type="number" step="0.01" class="form-control" id="dubai_mall" name="dubai_mall">
                        </div>

                        <!-- Sheikh Zayed Road -->
                        <div class="mb-3 col-md-6">
                            <label for="sheikh_zayed" class="form-label">Sheikh Zayed Road</label>
                            <input type="number" step="0.01" class="form-control" id="sheikh_zayed" name="sheikh_zayed">
                        </div>


                        <!-- Location Coordinates -->
                        <div class="mb-3 col-md-6">
                            <label for="location" class="form-label">Location Coordinates</label>
                            <input type="text" class="form-control" id="location" name="location"
                                placeholder="25.204849,55.270782">
                            <small class="form-text text-muted">Enter latitude and longitude separated by a
                                comma.</small>
                        </div>

                        <!-- Text Field -->
                        <div class="mb-3 col-md-6">
                            <label for="extra_text" class="form-label">Additional Information</label>
                            <input type="text" class="form-control" id="extra_text" name="extra_text">
                        </div>

                    </div>

                    <!-- Submit -->
                    <div class="row">
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>

    </div>
    <!-- End Page-content -->

    <?php include 'includes/footer.php' ?>
</div>

<?php include 'includes/common-footer.php' ?>