<?php
// Connect to the database
include('../../../config/database_connection.php');

if (isset($_POST['coopNumber']) && isset($_POST['sex']) ) {
    $coopNumber = $_POST['coopNumber'];
    $sex = $_POST['sex'];

    if($sex == 'Male'){
        // Prepare a statement to select the inStock for the selected coopNumber
        $stmt = $conn->prepare('SELECT male FROM chickenproduction WHERE coopNumber = :coopNumber AND archive = "not archived"');
        $stmt->bindValue(':coopNumber', $coopNumber, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $response = array(
                'status' => 'success',
                'inStock' => $row['male']
            );
            echo json_encode($response);
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'No inStock found for the selected coop number.'
            );
            echo json_encode($response);
        }
    }else{
        // Prepare a statement to select the inStock for the selected coopNumber
        $stmt = $conn->prepare('SELECT female FROM chickenproduction WHERE coopNumber = :coopNumber AND archive = "not archived"');
        $stmt->bindValue(':coopNumber', $coopNumber, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $response = array(
                'status' => 'success',
                'inStock' => $row['female']
            );
            echo json_encode($response);
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'No inStock found for the selected coop number.'
            );
            echo json_encode($response);
        }
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
