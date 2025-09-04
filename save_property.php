<?php
include 'config.php';

// Upload function
function uploadFile($fileInput, $folder = "uploads/")
{
    if (!empty($_FILES[$fileInput]['name']) && $_FILES[$fileInput]['error'] === 0) {
        $filename = time() . "_" . basename($_FILES[$fileInput]['name']);
        $targetPath = $folder . $filename;
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }
        if (move_uploaded_file($_FILES[$fileInput]['tmp_name'], $targetPath)) {
            return $filename;
        }
    }
    return null;
}

// Collect form data
$project_name = $_POST['project_name'] ?? '';
$description = $_POST['description'] ?? '';
$sub_heading = $_POST['sub_heading'] ?? '';
$project_heading = $_POST['project_heading'] ?? '';
$project_details = $_POST['project_details'] ?? '';
$starting_price = $_POST['starting_price'] ?? '';
$payment_plan = $_POST['payment_plan'] ?? '';
$handover = $_POST['handover'] ?? '';
$aed_per_sqft = $_POST['aed_per_sqft'] ?? '';
$starting_area = $_POST['starting_area'] ?? '';
$location = $_POST['location'] ?? '';
$extra_text = $_POST['extra_text'] ?? '';
$burj_al_arab = $_POST['burj_al_arab'] ?? '';
$dubai_marina = $_POST['dubai_marina'] ?? '';
$dubai_mall = $_POST['dubai_mall'] ?? '';
$sheikh_zayed = $_POST['sheikh_zayed'] ?? '';
$amenities = isset($_POST['amenities']) ? implode(", ", $_POST['amenities']) : "";




// File uploads
$brochure = uploadFile("brochure");
$main_picture = uploadFile("main_picture");
$gallery_images = [];
if (!empty($_FILES['gallery_images']['name'][0])) {
    foreach ($_FILES['gallery_images']['name'] as $index => $name) {
        if ($_FILES['gallery_images']['error'][$index] === 0) {
            $filename = time() . "_" . basename($name);
            $targetPath = "uploads/" . $filename;
            if (!is_dir("uploads/")) {
                mkdir("uploads/", 0777, true);
            }
            if (move_uploaded_file($_FILES['gallery_images']['tmp_name'][$index], $targetPath)) {
                $gallery_images[] = $filename;
            }
        }
    }
}
$image2 = $gallery_images[0] ?? null;
$image3 = $gallery_images[1] ?? null;
$image4 = $gallery_images[2] ?? null;
$gallery_images_str = implode(",", $gallery_images);
$floor_plan = uploadFile("floor_plan");


// Insert Query
$sql = "INSERT INTO properties
(project_name, description, sub_heading, brochure, project_heading, project_details, starting_price, payment_plan, handover, main_picture, image2, image3, image4, gallery_images, amenities, floor_plan, aed_per_sqft, starting_area, location, extra_text, burj_al_arab, dubai_marina, dubai_mall, sheikh_zayed)
VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

// bind_param → total 24 parameters, all treated as string "s"
if (
    !$stmt->bind_param(
        "ssssssssssssssssssssssss",  // 24 "s"
        $project_name,
        $description,
        $sub_heading,
        $brochure,
        $project_heading,
        $project_details,
        $starting_price,
        $payment_plan,
        $handover,
        $main_picture,
        $image2,
        $image3,
        $image4,
        $gallery_images_str,
        $amenities,
        $floor_plan,
        $aed_per_sqft,
        $starting_area,
        $location,
        $extra_text,
        $burj_al_arab,
        $dubai_marina,
        $dubai_mall,
        $sheikh_zayed
    )
) {
    die("Bind failed: " . $stmt->error);
}
if ($stmt->execute()) {
    // Redirect to the newly added property's detail page
    $newId = $conn->insert_id;
    $stmt->close();
    $conn->close();
    header("Location: property-details.php?id=" . $newId);
    exit;
} else {
    $stmt->close();
    $conn->close();
    echo "<script>alert('❌ Error while saving data');</script>";
}
