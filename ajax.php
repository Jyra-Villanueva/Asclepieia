<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data_type = $_POST['data_type'];

    if ($data_type === 'profile-edit') {

        $email = $_POST['email'];
        $firstname = $_POST['firstname'];

        $response = [
            'success' => true,
            'message' => 'Profile updated successfully',
        ];

        echo json_encode($response);
        exit;
    }
}

$response = [
    'success' => false,
    'message' => 'Invalid request or unable to process',
];

echo json_encode($response);
exit;
?>