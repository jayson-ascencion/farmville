<?php
// header('Content-Disposition: attachment; filename="sample.pdf"');

//include tcpdf library
include("../../../assets/tcpdf/tcpdf.php");

//database connection, located in the config directory
include('../../../config/database_connection.php');

//make TCPDF object
$pdf = new TCPDF('P','mm','A4');

//remove default header and footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

//add page
$pdf->AddPage();

//add content (student list)
//title

$pdf->SetFont('Helvetica','',18);
$pdf->Cell(190,10,"Arlin's Farmville",0,1,'C');
$pdf->SetFont('Helvetica','',10);
$pdf->Cell(190,5,"EGG REPORT",0,1,'C');
$pdf->Ln();
$pdf->Ln(3);
$sd = $_POST['start_date'];
$ed = $_POST['end_date'];
$start_date = date("F d, Y", strtotime($sd));
$end_date = date("F d, Y", strtotime($ed));
$pdf->SetFont('Helvetica','',10);
$pdf->Cell(30,5,"Report Timeframe",0);
$pdf->Cell(160,5,": ". $start_date . " - " . $end_date,0);
$pdf->Ln();

$currentDate = date("F d, Y");
$pdf->Cell(30,5,"Date Created",0);
$pdf->Cell(160,5,": " . $currentDate,0);
$pdf->Ln();
$pdf->Ln(5);

// -----------------------------------EGG TABLE AND SQL QUERY-------------------------------------//
$main_query = "
SELECT eggSize, inStock 
FROM eggproduction
 ";
// SELECT DATE_FORMAT(ep.collectionDate,'%M %d, %Y') AS collectionDate, ep.eggSize, SUM(COALESCE(ep.quantity,0)) as totalQuantity, SUM(COALESCE(er.quantity,0)) as totalReductions 
// FROM eggproduction ep 
// LEFT JOIN eggreduction er ON ep.eggBatch_ID = er.eggBatch_ID 
// WHERE ep.archive = 'not archived'
// if(isset($_POST["start_date"], $_POST["end_date"]) && $_POST["start_date"] != '' && $_POST["end_date"] != '')
// {
//     $main_query .= ' AND ep.collectionDate >= "'.$_POST["start_date"].'" AND ep.collectionDate <= "'.$_POST["end_date"].'"';
// }

// if(isset($_POST["search"]["value"]))
// {
//     $main_query .= ' AND (ep.eggBatch_ID LIKE "%'.$_POST["search"]["value"].'%" OR ep.eggSize LIKE "%'.$_POST["search"]["value"].'%" OR ep.collectionDate LIKE "%'.$_POST["search"]["value"].'%")';
// }

// $main_query .= " GROUP BY eggSize_ID ";

// $main_query .= ' ORDER BY ep.collectionDate DESC ';

$statement = $conn->prepare($main_query);
$statement->execute();
$result = $conn->query($main_query, PDO::FETCH_ASSOC);
// $result = $statement->fetchAll(PDO::FETCH_ASSOC);

$data = array();

foreach($result as $row)
{
    $sub_array = array();

    // $sub_array[] = $row['collectionDate'];

    $sub_array[] = $row['eggSize'];

    $sub_array[] = $row['inStock'];

    // $sub_array[] = $row['totalReductions'];

    $data[] = $sub_array;
}

$output = array(
    "data"			=>	$data
);

//make the table
$html = "
<h3> Egg Inventory </h3>
	<table>
		<tr>
			<th>Egg Size</th>
			<th>Total In Stock</th>
		</tr>
		";
//load the json data
// $file = file_get_contents('MOCK_DATA-100.json');
// $data = json_decode($file);

//loop the data
if(empty($output['data'])){
    $html .= '<tr><td colspan="5" style="text-align:center;">No records</td></tr>';
} else {
foreach($output['data'] as $egg){	
	$html .= "
			<tr>
				<td>". $egg[0] ."</td>
				<td>". $egg[1] ."</td>
			</tr>
			";
}		
}
$html .= "
	</table>
	<style>
	table {
		border-collapse:collapse;
		text-align: center;
	}
	th,td {
		border:1px solid #888;
	}
	table tr th {
		background-color:#888;
		color:#fff;
		font-weight:bold;
	}
	</style>
";
//WriteHTMLCell
$pdf->WriteHTMLCell(192,0,9,'',$html,0);	
$pdf->Ln();
$pdf->Ln(10);

//--------------------------------------SUMMARY BY REDUCTION TYPE------------------------------//
$main_query = "SELECT dispositionType, SUM(COALESCE(quantity, 0)) as reductions
FROM eggtransaction
WHERE archive = 'not archived' AND dispositionType IN ('Distributed to Customer', 'Personal Consumption', 'Spoiled')
";

if(isset($_POST["start_date"], $_POST["end_date"]) && $_POST["start_date"] != '' && $_POST["end_date"] != '')
{
    $main_query .= ' AND transactionDate >= "'.$_POST["start_date"].'" AND transactionDate <= "'.$_POST["end_date"].'"';
}

if(isset($_POST["search"]["value"]))
{
    $main_query .= ' AND (transactionDate LIKE "%'.$_POST["search"]["value"].'%")';
}

$main_query .= " GROUP BY dispositionType ";

$main_query .= ' ORDER BY transactionDate DESC ';

$statement = $conn->prepare($main_query);
$statement->execute();

$result = $conn->query($main_query, PDO::FETCH_ASSOC);
// $result = $statement->fetchAll(PDO::FETCH_ASSOC);

$data = array();

foreach($result as $row)
{
    $sub_array = array();

    $sub_array[] = $row['dispositionType'];

    $sub_array[] = $row['reductions'];

    $data[] = $sub_array;
}

$output = array(
    "data"			=>	$data
);

//make the table
$html2 = "
<h3>Summary By Reduction Type </h3>
	<table>
		<tr>
			<th>Reduction Type </th>
			<th>Total Reductions</th>
		</tr>
		";
//load the json data
// $file = file_get_contents('MOCK_DATA-100.json');
// $data = json_decode($file);

//loop the data
if(empty($output['data'])){
    $html2 .= '<tr><td colspan="5" style="text-align:center;">No records</td></tr>';
} else {
foreach($output['data'] as $eggreduction){	
	$html2 .= "
			<tr>
				<td>". $eggreduction[0] ."</td>
				<td>". $eggreduction[1] ."</td>
			</tr>
			";
}		
}
$html2 .= "
	</table>
	<style>
	table {
		border-collapse:collapse;
		text-align: center;
	}
	th,td {
		border:1px solid #888;
	}
	table tr th {
		background-color:#888;
		color:#fff;
		font-weight:bold;
	}
	</style>
";
//WriteHTMLCell
$pdf->WriteHTMLCell(192,0,9,'',$html2,0);	
$pdf->Ln();
$pdf->Ln(10);

$pdf->Output('Egg Report - '.$currentDate.'.pdf', 'D');