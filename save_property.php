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

function uploadMultipleFiles($fileInput, $folder = "uploads/")
{
    $uploaded = [];
    if (!empty($_FILES[$fileInput]['name'][0])) {
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }
        foreach ($_FILES[$fileInput]['name'] as $key => $name) {
            if ($_FILES[$fileInput]['error'][$key] === 0) {
                $filename = time() . "_" . $key . "_" . basename($name);
                $targetPath = $folder . $filename;
                if (move_uploaded_file($_FILES[$fileInput]['tmp_name'][$key], $targetPath)) {
                    $uploaded[] = $filename;
                }
            }
        }
    }
    return !empty($uploaded) ? implode(',', $uploaded) : null;
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
$main_picture = uploadMultipleFiles("main_picture");
$image2 = uploadFile("image2");
$image3 = uploadFile("image3");
$image4 = uploadFile("image4");
$floor_plan = uploadFile("floor_plan");


// Insert Query
$sql = "INSERT INTO properties 
(project_name, description, sub_heading, brochure, project_heading, project_details, starting_price, payment_plan, handover, main_picture, image2, image3, image4, amenities, floor_plan, aed_per_sqft, starting_area, location, extra_text, burj_al_arab, dubai_marina, dubai_mall, sheikh_zayed) 
VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

// bind_param → total 23 parameters, all treated as string "s"
if (
    !$stmt->bind_param(
        "sssssssssssssssssssssss",  // 23 "s"
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
