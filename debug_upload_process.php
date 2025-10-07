<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Models\Product;

echo "=== COMPREHENSIVE FILE UPLOAD DEBUG ===\n";

// Create a fake image file for testing
$tempFile = tempnam(sys_get_temp_dir(), 'test_product_img');
file_put_contents($tempFile, base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8/5+hHgAHggJ/PchI7wAAAABJRU5ErkJggg==')); // Tiny valid PNG

echo "Created temporary test image file: $tempFile\n";

// Create a fake uploaded file instance
$testFile = new class($tempFile, 'test_image.jpg', 'image/jpeg', UPLOAD_ERR_OK, true) extends \Illuminate\Http\UploadedFile {
    public function __construct($path, $name, $type, $error, $test) {
        parent::__construct($path, $name, $type, $error, $test);
    }
};

// Test the file validation
echo "File exists: " . (file_exists($tempFile) ? "YES" : "NO") . "\n";
echo "File is valid: " . ($testFile->isValid() ? "YES" : "NO") . "\n";
echo "File extension: " . $testFile->getClientOriginalExtension() . "\n";

// Generate filename (mimicking the controller's method)
$randomFilename = bin2hex(random_bytes(5)) . '.' . $testFile->getClientOriginalExtension();
echo "Generated filename: $randomFilename\n";

// Test the storeAs operation - CORRECTED VERSION (without 'public/')
echo "Attempting to store via storeAs (corrected)...\n";
$storePath = $testFile->storeAs('img', $randomFilename);  // Using 'img' instead of 'public/img'
echo "storeAs result: $storePath\n";

if ($storePath) {
    echo "File should be stored at: " . storage_path("app/public/$storePath") . "\n";
    $actualFilePath = storage_path("app/public/$storePath");
    echo "File exists on disk: " . (file_exists($actualFilePath) ? "YES" : "NO") . "\n";
    
    // Check the expected web path
    $webPath = '/storage/' . $storePath;
    $webPathExists = file_exists(public_path(substr($webPath, 1))); // Remove leading slash to check public path
    echo "Web path would be: $webPath\n";
    echo "Web path exists: " . ($webPathExists ? "YES" : "NO") . "\n";
} else {
    echo "ERROR: storeAs failed!\n";
}

// Clean up
unlink($tempFile);
if ($storePath && file_exists(storage_path("app/public/$storePath"))) {
    unlink(storage_path("app/public/$storePath"));
    echo "Cleaned up test file\n";
}

echo "\n=== COMPREHENSIVE DEBUG COMPLETE ===\n";