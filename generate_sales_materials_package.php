<?php

/**
 * Generates ready-to-print PDF documents from the sales proofs
 * and packages all JPEGs + PDFs into:
 * 1. C:\Users\User\Documents\SMS_EXTRACTED\SALES_MATERIALS_TO_PRINT
 * 2. C:\Users\User\Desktop\SCHOOL_SALES_MATERIALS
 * 3. C:\Users\User\Downloads\SCHOOL_SALES_MATERIALS
 * 4. public/sales-materials/sales-proofs-kit.zip
 */

function jpegToPdf($jpegPath, $pdfPath, $orientation = 'portrait') {
    if (!file_exists($jpegPath)) {
        echo "Source file missing: {$jpegPath}\n";
        return false;
    }

    $data = file_get_contents($jpegPath);
    $size = getimagesize($jpegPath);
    $width = $size[0];
    $height = $size[1];

    if ($orientation === 'landscape') {
        $pageW = 841.89; // A4 landscape
        $pageH = 595.28;
    } else {
        $pageW = 595.28; // A4 portrait
        $pageH = 841.89;
    }

    $margin = 15;
    $availW = $pageW - (2 * $margin);
    $availH = $pageH - (2 * $margin);
    $scale = min($availW / $width, $availH / $height);
    $renderW = $width * $scale;
    $renderH = $height * $scale;
    $posX = ($pageW - $renderW) / 2;
    $posY = ($pageH - $renderH) / 2;

    $contentStream = sprintf("q\n%0.2f 0 0 %0.2f %0.2f %0.2f cm\n/Im1 Do\nQ\n", $renderW, $renderH, $posX, $posY);
    $contentLen = strlen($contentStream);
    $imageLen = strlen($data);

    $objects = [];
    $objects[1] = "<< /Type /Catalog /Pages 2 0 R >>";
    $objects[2] = "<< /Type /Pages /Kids [ 3 0 R ] /Count 1 >>";
    $objects[3] = "<< /Type /Page /Parent 2 0 R /MediaBox [ 0 0 {$pageW} {$pageH} ] /Contents 4 0 R /Resources << /XObject << /Im1 5 0 R >> >> >>";
    $objects[4] = "<< /Length {$contentLen} >>\nstream\n" . $contentStream . "endstream";
    $objects[5] = "<< /Type /XObject /Subtype /Image /Width {$width} /Height {$height} /ColorSpace /DeviceRGB /BitsPerComponent 8 /Filter /DCTDecode /Length {$imageLen} >>\nstream\n" . $data . "\nendstream";

    $pdf = "%PDF-1.4\n";
    $offsets = [];
    for ($i = 1; $i <= 5; $i++) {
        $offsets[$i] = strlen($pdf);
        $pdf .= "{$i} 0 obj\n" . $objects[$i] . "\nendobj\n";
    }

    $xrefOffset = strlen($pdf);
    $pdf .= "xref\n0 6\n0000000000 65535 f \n";
    for ($i = 1; $i <= 5; $i++) {
        $pdf .= sprintf("%010d 00000 n \n", $offsets[$i]);
    }
    $pdf .= "trailer\n<< /Size 6 /Root 1 0 R >>\nstartxref\n{$xrefOffset}\n%%EOF\n";

    file_put_contents($pdfPath, $pdf);
    return true;
}

$baseDir = __DIR__;
$publicImages = $baseDir . '/public/images';

$items = [
    [
        'id' => '01-Master-Broadsheet-Tally',
        'src' => $publicImages . '/proof-master-tally.jpg',
        'orientation' => 'landscape',
        'title' => 'Official Continuous Assessment & Broadsheet Tally Sheet'
    ],
    [
        'id' => '02-Graduation-Certificate',
        'src' => $publicImages . '/proof-certificate-sample.jpg',
        'orientation' => 'landscape',
        'title' => 'Luxury Victorian Graduation Certificate & Testimonial'
    ],
    [
        'id' => '03-Student-Terminal-Report-Card',
        'src' => $publicImages . '/proof-report-card.jpg',
        'orientation' => 'portrait',
        'title' => 'Official Student Terminal Continuous Assessment Dossier'
    ],
    [
        'id' => '04-Bursary-Tuition-Recovery-Audit',
        'src' => $publicImages . '/proof-bursar-clearance.jpg',
        'orientation' => 'portrait',
        'title' => 'Bursar Tuition Recovery Audit & Paystack Fee Clearance Slip'
    ],
    [
        'id' => '05-Executive-PR-FAQ-One-Pager',
        'src' => $publicImages . '/proof-executive-memo.jpg',
        'orientation' => 'portrait',
        'title' => 'Amazon-Style Executive Briefing & 48-Hour Onboarding Plan'
    ],
    [
        'id' => '06-Presentation-Folder-Overview',
        'src' => $publicImages . '/executive-sales-kit.jpg',
        'orientation' => 'landscape',
        'title' => 'Master Presentation Folder Overview'
    ],
    [
        'id' => '07-Customized-Student-ID-Card',
        'src' => $publicImages . '/proof-student-id-cards.jpg',
        'orientation' => 'landscape',
        'title' => 'Customized Student PVC Identity Card (Front & Back with Lanyard)'
    ],
    [
        'id' => '08-Customized-Staff-Teacher-ID-Card',
        'src' => $publicImages . '/proof-staff-id-cards.jpg',
        'orientation' => 'landscape',
        'title' => 'Customized Faculty & Staff PVC Identity Card (Front & Back with Lanyard)'
    ],
    [
        'id' => '09-Senior-Secondary-Graduation-Certificate',
        'src' => $publicImages . '/proof-senior-graduation-cert.jpg',
        'orientation' => 'landscape',
        'title' => 'Prestige Senior Secondary School Graduation Certificate & Testimonial'
    ],
    [
        'id' => '10-Nursery-Primary-Graduation-Certificate',
        'src' => $publicImages . '/proof-primary-graduation-cert.jpg',
        'orientation' => 'landscape',
        'title' => 'Nursery & Primary School Leaving Transition Graduation Certificate'
    ]
];

// Target directories to populate
$targetDirs = [
    $baseDir . '/SALES_MATERIALS_TO_PRINT',
    $baseDir . '/public/sales-materials',
    'C:/Users/User/Desktop/SCHOOL_SALES_MATERIALS',
    'C:/Users/User/Downloads/SCHOOL_SALES_MATERIALS'
];

foreach ($targetDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
}

echo "Generating PDFs and copying files...\n";

$createdFiles = [];

foreach ($items as $item) {
    $jpgName = $item['id'] . '.jpg';
    $pdfName = $item['id'] . '.pdf';

    $tempPdf = $baseDir . '/' . $pdfName;
    jpegToPdf($item['src'], $tempPdf, $item['orientation']);

    foreach ($targetDirs as $dir) {
        if (is_dir($dir)) {
            copy($item['src'], $dir . '/' . $jpgName);
            copy($tempPdf, $dir . '/' . $pdfName);
        }
    }

    if (file_exists($tempPdf)) {
        unlink($tempPdf);
    }

    echo "Generated: {$item['id']} [JPG & PDF]\n";
}

// Create README.txt in each folder
$readmeText = <<<EOT
================================================================================
ES-SCHOOLS: PHYSICAL OUTREACH & PROOF MATERIALS FOR PRIVATE SCHOOLS
================================================================================

These materials are ready to print or carry on your phone/tablet/flash drive to 
show to Proprietors, Principals, Head Teachers, and Bursars.

FILES IN THIS FOLDER:
--------------------------------------------------------------------------------
1. 01-Master-Broadsheet-Tally.pdf / .jpg
   - FORMAT: A4 Landscape
   - FOR: Principals & Examination Officers
   - TALKING POINT: Replaces 3 weeks of manual math, arithmetic errors, and sleepless 
     nights with an instant 10-second automated tally broadsheet.

2. 02-Graduation-Certificate.pdf / .jpg
   - FORMAT: A4 Landscape
   - FOR: Proprietors & School Boards
   - TALKING POINT: Luxury Victorian gold-foil graduation certificate with verifiable 
     QR code and anti-forgery serial number. Immediate prestige upgrade for their school.

3. 03-Student-Terminal-Report-Card.pdf / .jpg
   - FORMAT: A4 Portrait
   - FOR: Parents & Teachers
   - TALKING POINT: Complete terminal dossier with WAEC letter grades, psychomotor/affective 
     domain appraisal, attendance, and official red principal stamp. Locked until fees are cleared.

4. 04-Bursary-Tuition-Recovery-Audit.pdf / .jpg
   - FORMAT: A4 Portrait
   - FOR: Bursars & Proprietors
   - TALKING POINT: Shows 98.2% automated tuition collection, eliminates fake paper tellers, 
     and generates instant Paystack electronic payment clearance slips with ₦0.00 balance.

5. 05-Executive-PR-FAQ-One-Pager.pdf / .jpg
   - FORMAT: A4 Portrait
   - FOR: Proprietor Leave-Behind
   - TALKING POINT: Amazon-style 1-page executive memo showing how Kingsway Model College 
     collected 98% fees in 14 days, with a 48-hour seamless onboarding guarantee.

6. 06-Presentation-Folder-Overview.pdf / .jpg
   - FORMAT: A4 Landscape
   - FOR: Sales Overview
   - TALKING POINT: Executive physical folder presentation overview on mahogany desk.

7. 07-Customized-Student-ID-Card.pdf / .jpg
   - FORMAT: High-res PVC Identity Card Mockup (Front & Back with Lanyard)
   - FOR: Students & Parents
   - TALKING POINT: Customized school student identity card with passport photo, class, 
     admission number, blood group, parent emergency contact, barcode, and anti-forgery QR code.

8. 08-Customized-Staff-Teacher-ID-Card.pdf / .jpg
   - FORMAT: High-res PVC Identity Card Mockup (Front & Back with Lanyard)
   - FOR: Teachers, HODs & Non-Academic Staff
   - TALKING POINT: Standardized faculty credentials with teacher photograph, designation, 
     staff ID, employee QR code, and proprietor authorization. Instills pride and institutional order.

9. 09-Senior-Secondary-Graduation-Certificate.pdf / .jpg
   - FORMAT: A4 Landscape (Rich Ivory Cardstock with Victorian Gold Foil Borders)
   - FOR: Secondary School Graduands & Parents
   - TALKING POINT: Senior Secondary School Certificate of Completion & Moral Conduct 
     Testimonial with metallic gold seal, WAEC-level completion statement, and verification QR code.

10. 10-Nursery-Primary-Graduation-Certificate.pdf / .jpg
    - FORMAT: A4 Landscape (Vibrant Prestige Cardstock with Gold Star Seal & Ribbons)
    - FOR: Nursery & Primary Transition (Primary Six to JSS 1)
    - TALKING POINT: Colorful, prestigious primary leaving certificate that parents cherish, 
      driving massive admissions into the junior secondary school.

PRINTING INSTRUCTIONS:
- Take these PDF or JPG files to any color cybercafé or print shop.
- Recommend printing the Certificate on 250gsm or 300gsm card stock.
- Print Broadsheet in Landscape orientation.
================================================================================
EOT;

foreach ($targetDirs as $dir) {
    if (is_dir($dir)) {
        file_put_contents($dir . '/README.txt', $readmeText);
    }
}

// Create a ZIP package for 1-click download
$zipFile = $baseDir . '/public/sales-materials/school-sales-materials-package.zip';
$zip = new ZipArchive();
if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
    $folderToZip = $baseDir . '/SALES_MATERIALS_TO_PRINT';
    $files = scandir($folderToZip);
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            $zip->addFile($folderToZip . '/' . $file, $file);
        }
    }
    $zip->close();
    echo "Created ZIP package: {$zipFile} (Size: " . round(filesize($zipFile) / 1024 / 1024, 2) . " MB)\n";
} else {
    echo "Could not create zip file.\n";
}

echo "All materials generated and distributed successfully!\n";

