<?php
function handleImageUpload($uploadDir, $files)
{
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0777, true)) {
            die("Error: Unable to create the upload directory.");
        }
    }

    if (!is_array($files['name'])) {
        $files = array($files);
    }

    $uploadedFiles = array();

    for ($i = 0; $i < count($files['name']); $i++) {
        $fileName = $files['name'][$i];
        $fileTmpName = $files['tmp_name'][$i];
        $fileSize = $files['size'][$i];
        $fileType = $files['type'][$i];
        $fileError = $files['error'][$i];

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($fileType, $allowedTypes)) {
            die("Error: Invalid file type for {$fileName}.");
        }

        $maxFileSize = 5 * 1024 * 1024; // 5 MB
        if ($fileSize > $maxFileSize) {
            die("Error: File size exceeds the maximum limit for {$fileName}.");
        }

        $uniqueFilename = time() . '_' . uniqid() . '_' . $fileName;
        $targetFilePath = $uploadDir . '/' . $uniqueFilename;

        if ($fileError === 0) {
            if (move_uploaded_file($fileTmpName, $targetFilePath)) {
                $uploadedFiles[] = array(
                    'name' => $uniqueFilename,
                    'path' => $targetFilePath,
                );
                echo "File {$fileName} has been uploaded successfully.<br>";
            } else {
                error_log("Error uploading {$fileName}.");
                echo "Error uploading {$fileName}. Please try again later.<br>";
            }
        } else {
            echo "Error: {$fileName} has an upload error (Error code: {$fileError}).<br>";
        }
    }
    return json_encode($uploadedFiles);
}
