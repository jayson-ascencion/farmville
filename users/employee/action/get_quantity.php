<?php
// Connect to the database
include('../../../config/database_connection.php');

if (isset($_POST['coopNumber'])) {
    $coopNumber = $_POST['coopNumber'];

    // Prepare a statement to select the inStock for the selected coopNumber
    $stmt = $conn->prepare('SELECT inStock FROM chickenproduction WHERE coopNumber = :coopNumber AND archive = "not archived"');
    $stmt->bindValue(':coopNumber', $coopNumber, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $response = array(
            'status' => 'success',
            'inStock' => $row['inStock']
        );
        echo json_encode($response);
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'No inStock found for the selected coop number.'
        );
        echo json_encode($response);
    }
}else if (isset($_POST['feed_ID'])) {
    $feed_ID = $_POST['feed_ID'];

    // Prepare a statement to select the inStock for the selected coopNumber
    $stmt = $conn->prepare('SELECT inStock FROM feeds WHERE feed_ID = :feed_ID');
    $stmt->bindValue(':feed_ID', $feed_ID, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $response = array(
            'status' => 'success',
            'inStock' => $row['inStock']
        );
        echo json_encode($response);
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'No inStock found for the selected coop number.'
        );
        echo json_encode($response);
    }
}else if (isset($_POST['eggSize_ID'])) {
    $eggSize_ID = $_POST['eggSize_ID'];

    // Prepare a statement to select the inStock for the selected coopNumber
    $stmt = $conn->prepare('SELECT inStock FROM eggproduction WHERE eggSize_ID = :eggSize_ID');
    $stmt->bindValue(':eggSize_ID', $eggSize_ID, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $response = array(
            'status' => 'success',
            'inStock' => $row['inStock']
        );
        echo json_encode($response);
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'No inStock found for the selected coop number.'
        );
        echo json_encode($response);
    }
}else if (isset($_POST['medicine_ID'])) {
    $medicine_ID = $_POST['medicine_ID'];

    // Prepare a statement to select the inStock for the selected coopNumber
    $stmt = $conn->prepare('SELECT inStock FROM medicines WHERE medicine_ID = :medicine_ID');
    $stmt->bindValue(':medicine_ID', $medicine_ID, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $response = array(
            'status' => 'success',
            'inStock' => $row['inStock']
        );
        echo json_encode($response);
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'No inStock found for the selected coop number.'
        );
        echo json_encode($response);
    }
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Invalid request.'
    );
    echo json_encode($response);
}

// Close the database connection
unset($conn);
?>
