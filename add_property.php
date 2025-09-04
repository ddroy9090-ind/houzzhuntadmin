<form id="propertyForm" method="POST" action="save_property1111.php" enctype="multipart/form-data" novalidate
    class="property-detailsForm">
    <div class="row">
        <!-- Project Name -->
        <div class="mb-3 col-md-6">
            <label for="project_name" class="form-label">Project Name</label>
            <input type="text" class="form-control" id="project_name" name="project_name" required>
            <div class="error-msg">Please enter project name</div>
        </div>

        <!-- Sub heading -->
        <div class="mb-3 col-md-6">
            <label for="sub_heading" class="form-label">Sub Heading</label>
            <input type="text" class="form-control" id="sub_heading" name="sub_heading" required>
            <div class="error-msg">Please enter sub heading</div>
        </div>

        <!-- Description -->
        <div class="mb-3 col-12">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            <div class="error-msg">Please enter description</div>
        </div>

        <!-- Brochure Upload -->
        <div class="mb-3 col-12">
            <label class="form-label">Brochure Upload</label>
            <div class="custom-upload" onclick="document.getElementById('brochure').click()"
                ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)"
                ondrop="handleDrop(event, 'brochure')">
                <div class="icon"><img width="40" src="assets/icons/upload-pdf.png" alt=""></div>
                <p>Drop files here or click to upload</p>
                <input type="file" id="brochure" name="brochure" required onchange="showFileName(this)">
            </div>
            <div id="file-name-brochure" class="file-name"></div>
            <div class="error-msg">Please upload a brochure</div>
        </div>
    </div>


    <h4 class="mt-5">Offplan Details</h4>
    <div class="row">
        <!-- Project Heading -->
        <div class="mb-3 col-md-6">
            <label for="project_heading" class="form-label">Project Heading</label>
            <input type="text" class="form-control" id="project_heading" name="project_heading" required>
            <div class="error-msg">Please enter project heading</div>
        </div>

        <!-- Starting Price -->
        <div class="mb-3 col-md-6">
            <label for="starting_price" class="form-label">Starting Price</label>
            <div class="input-group">
                <span class="input-group-text currency-symbol"></span>
                <input type="number" class="form-control" id="starting_price" name="starting_price" required data-base-value="0">
            </div>
            <div class="error-msg">Please enter starting price</div>
        </div>

        <!-- Payment Plan -->
        <div class="mb-3 col-md-6">
            <label for="payment_plan" class="form-label">Payment Plan</label>
            <input type="text" class="form-control" id="payment_plan" name="payment_plan" required>
            <div class="error-msg">Please enter payment plan</div>
        </div>

        <!-- Project Handover -->
        <div class="mb-3 col-md-6">
            <label for="handover" class="form-label">Project Handover</label>
            <input type="date" class="form-control" id="handover" name="handover" required>
            <div class="error-msg">Please enter handover date</div>
        </div>

        <!-- Project Details -->
        <div class="mb-3 col-md-12">
            <label for="project_details" class="form-label">Project Details</label>
            <textarea class="form-control" id="project_details" name="project_details" rows="3" required></textarea>
            <div class="error-msg">Please enter project details</div>
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
                <input type="file" id="main_picture" name="main_picture" required onchange="showFileName(this)">
            </div>
            <div id="file-name-main_picture" class="file-name"></div>
            <div class="error-msg">Please upload main picture</div>
        </div>

        <!-- Additional Images -->
        <div class="mb-3 col-md-6">
            <label class="form-label">Image 2</label>
            <div class="custom-upload" onclick="document.getElementById('image2').click()"
                ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)"
                ondrop="handleDrop(event, 'image2')">
                <div class="icon"><img width="40" src="assets/icons/upload-images.png" alt=""></div>
                <p>Drop files here or click to upload</p>
                <input type="file" id="image2" name="image2" required onchange="showFileName(this)">
            </div>
            <div id="file-name-image2" class="file-name"></div>
            <div class="error-msg">Please upload image 2</div>
        </div>

        <!-- Image 3 -->
        <div class="mb-3 col-md-6">
            <label class="form-label">Image 3</label>
            <div class="custom-upload" onclick="document.getElementById('image3').click()"
                ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)"
                ondrop="handleDrop(event, 'image3')">
                <div class="icon"><img width="40" src="assets/icons/upload-images.png" alt=""></div>
                <p>Drop files here or click to upload</p>
                <input type="file" id="image3" name="image3" required onchange="showFileName(this)">
            </div>
            <div id="file-name-image3" class="file-name"></div>
            <div class="error-msg">Please upload image 3</div>
        </div>

        <!-- Image 4 -->
        <div class="mb-3 col-md-6">
            <label class="form-label">Image 4</label>
            <div class="custom-upload" onclick="document.getElementById('image4').click()"
                ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)"
                ondrop="handleDrop(event, 'image4')">
                <div class="icon"><img width="40" src="assets/icons/upload-images.png" alt=""></div>
                <p>Drop files here or click to upload</p>
                <input type="file" id="image4" name="image4" required onchange="showFileName(this)">
            </div>
            <div id="file-name-image4" class="file-name"></div>
            <div class="error-msg">Please upload image 4</div>
        </div>
    </div>


    <!-- Amenities -->
    <div class="mb-3">
        <h4 class="mt-5">Amenities</h4>
        <div class="row">
            <div class="col-12">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="amenity1" name="amenities[]" value="Gym"
                        required>
                    <label class="form-check-label" for="amenity1">Gym</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="amenity2" name="amenities[]" value="Pool">
                    <label class="form-check-label" for="amenity2">Pool</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="amenity3" name="amenities[]"
                        value="Central Clubhouses and Fitness Facilities">
                    <label class="form-check-label" for="amenity3">Central Clubhouses and Fitness
                        Facilities</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="amenity4" name="amenities[]"
                        value="Lagoon and Natural Waterways">
                    <label class="form-check-label" for="amenity4">Lagoon and Natural Waterways</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="amenity5" name="amenities[]"
                        value="33 KM Cycling Trail and 7.1 KM Promenade">
                    <label class="form-check-label" for="amenity5">33 KM Cycling Trail and 7.1 KM
                        Promenade</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="amenity6" name="amenities[]"
                        value="Community Mall and Coastal Retail">
                    <label class="form-check-label" for="amenity6">Community Mall and Coastal
                        Retail</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="amenity7" name="amenities[]"
                        value="Wellness Centre and Spa">
                    <label class="form-check-label" for="amenity7">Wellness Centre and Spa</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="amenity8" name="amenities[]"
                        value="Business Park and Sports Complex">
                    <label class="form-check-label" for="amenity8">Business Park and Sports
                        Complex</label>
                </div>
            </div>
        </div>
        <div class="error-msg">Please select at least one amenity</div>
    </div>


    <h4 class="mt-5">Floor Plan</h4>
    <div class="row">
        <!-- Floor Plan -->
        <div class="mb-3 col-md-6">
            <label for="floor_plan" class="form-label">Floor Plan</label>
            <input type="file" class="form-control" id="floor_plan" name="floor_plan" required>
            <div class="error-msg">Please upload floor plan</div>
        </div>

        <!-- Starting Price (Floor Plan) -->
        <div class="mb-3 col-md-6">
            <label for="floor_starting_price" class="form-label">Starting Price (Floor Plan)</label>
            <div class="input-group">
                <span class="input-group-text currency-symbol"></span>
                <input type="text" class="form-control" id="floor_starting_price" name="floor_starting_price" data-base-value="0">
            </div>
        </div>

        <!-- Price per Sqft -->
        <div class="mb-3 col-md-6">
            <label for="aed_per_sqft" class="form-label">Price per Sqft</label>
            <div class="input-group">
                <span class="input-group-text currency-symbol"></span>
                <input type="text" class="form-control" id="aed_per_sqft" name="aed_per_sqft" required data-base-value="0">
            </div>
            <div class="error-msg">Please enter AED per Sqft</div>
        </div>

        <!-- Starting Area -->
        <div class="mb-3 col-md-6">
            <label for="starting_area" class="form-label">Starting Area</label>
            <input type="text" class="form-control" id="starting_area" name="starting_area" required>
            <div class="error-msg">Please enter starting area</div>
        </div>

        <!-- Location Coordinates -->
        <div class="mb-3 col-md-6">
            <label for="location" class="form-label">Location Coordinates</label>
            <input type="text" class="form-control" id="location" name="location" required>
            <div class="error-msg">Please enter location coordinates</div>
        </div>

        <!-- Text Field -->
        <div class="mb-3 col-md-6">
            <label for="extra_text" class="form-label">Additional Information</label>
            <input type="text" class="form-control" id="extra_text" name="extra_text" required>
            <div class="error-msg">Please enter additional info</div>
        </div>
    </div>


    <!-- Submit -->
    <div class="row">
        <div class="col-12 text-end">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>