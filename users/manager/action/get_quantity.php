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
