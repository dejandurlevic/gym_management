<?php

$photo = $_FILES['photo'];

$photo_name = basename($photo['name']);

$directory = '/member_photos/';
$photo_path = $_SERVER['DOCUMENT_ROOT'] . $directory . $photo_name;

$allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

$ext = pathinfo($photo_name, PATHINFO_EXTENSION);

if (!is_dir($_SERVER['DOCUMENT_ROOT'] . $directory)) {
    mkdir($_SERVER['DOCUMENT_ROOT'] . $directory, 0755, true);
}

if (in_array($ext, $allowed_ext) && $photo['size'] < 2000000) {
    if (move_uploaded_file($photo['tmp_name'], $photo_path)) {
        // Prikazivanje putanje u HTML-u treba da koristi relativnu putanju:
        echo json_encode(['success' => true, 'photo_path' => $directory . $photo_name]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to move uploaded file']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid file']);
}
