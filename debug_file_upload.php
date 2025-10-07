<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

// Debug script to trace the file upload process
echo "=== FILE UPLOAD DEBUG SCRIPT ===\n";

// 1. Check if the storage disk is properly configured
echo "\n1. Checking storage disk configuration:\n";
$disk = Storage::disk('public');
echo "Public disk exists: " . ($disk ? "YES" : "NO") . "\n";

// 2. Check if the directory exists and is writable
$imgDir = 'img';
echo "\n2. Checking directory '$imgDir':\n";
$dirExists = Storage::disk('public')->exists($imgDir);
echo "Directory exists: " . ($dirExists ? "YES" : "NO") . "\n";

// 3. Attempt to create the directory if it doesn't exist
if (!$dirExists) {
    echo "Creating directory '$imgDir'...\n";
    Storage::disk('public')->makeDirectory($imgDir);
    $dirExists = Storage::disk('public')->exists($imgDir);
    echo "Directory created: " . ($dirExists ? "YES" : "NO") . "\n";
}

// 4. Test storing a simple test file
echo "\n3. Testing file storage:\n";
$testContent = "This is a test file for debugging.";
$testFilename = 'debug_test.txt';
$testPath = $imgDir . '/' . $testFilename;

echo "Attempting to store test file at: $testPath\n";
$stored = Storage::disk('public')->put($testPath, $testContent);

if ($stored) {
    echo "Test file stored successfully!\n";
    $exists = Storage::disk('public')->exists($testPath);
    echo "File exists after storing: " . ($exists ? "YES" : "NO") . "\n";
    
    if ($exists) {
        $content = Storage::disk('public')->get($testPath);
        echo "File content: " . $content . "\n";
    }
} else {
    echo "Failed to store test file!\n";
}

// 5. Check the actual storage path on the filesystem
echo "\n4. Checking actual filesystem paths:\n";
$storagePath = storage_path('app/public/' . $imgDir);
echo "Storage path: $storagePath\n";
echo "Directory exists on filesystem: " . (is_dir($storagePath) ? "YES" : "NO") . "\n";
echo "Directory is writable: " . (is_writable($storagePath) ? "YES" : "NO") . "\n";

// 6. Test file_put_contents as an alternative
echo "\n5. Testing alternative file creation method:\n";
$altPath = storage_path('app/public/' . $testPath);
echo "Attempting to create file at: $altPath\n";

// Make sure directory exists
$dirPath = dirname($altPath);
if (!is_dir($dirPath)) {
    mkdir($dirPath, 0755, true);
    echo "Created directory: $dirPath\n";
}

$fileCreated = file_put_contents($altPath, $testContent);
if ($fileCreated !== false) {
    echo "File created using file_put_contents!\n";
    echo "File exists: " . (file_exists($altPath) ? "YES" : "NO") . "\n";
} else {
    echo "Failed to create file using file_put_contents!\n";
}

// 7. Show storage configuration
echo "\n6. Storage Configuration:\n";
echo "Storage path: " . storage_path() . "\n";
echo "Public storage path: " . storage_path('app/public') . "\n";
echo "Public disk root: " . (Storage::disk('public')->path('')) . "\n";

// 8. Test a real image upload simulation
echo "\n7. Simulating image upload process:\n";

// Create a fake uploaded file for testing
$tempFile = tempnam(sys_get_temp_dir(), 'test_img');
file_put_contents($tempFile, 'fake image data');

echo "Created temporary file: $tempFile\n";

// Try to store the temp file using storeAs
$extension = 'jpg';
$randomName = bin2hex(random_bytes(5)) . '.' . $extension;
$finalPath = $imgDir . '/' . $randomName;

echo "Attempting to store with storeAs: $finalPath\n";

// This simulates what happens in the controller
$uploadedFile = new class($tempFile, $randomName) extends \Illuminate\Http\UploadedFile {
    public function __construct($path, $originalName)
    {
        parent::__construct($path, $originalName, null, UPLOAD_ERR_OK, true);
    }
};

// Test storeAs method
$result = $uploadedFile->storeAs($imgDir, $randomName, 'public');
echo "storeAs result: " . ($result ? $result : 'false') . "\n";

if ($result) {
    $filePath = storage_path('app/public/' . $result);
    echo "File should be at: $filePath\n";
    echo "File exists: " . (file_exists($filePath) ? "YES" : "NO") . "\n";
}

// Clean up temp file
unlink($tempFile);

echo "\n=== DEBUG SCRIPT COMPLETE ===\n";