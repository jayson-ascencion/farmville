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
$pdf->Cell(190,5,"CHICKEN REPORT",0,1,'C');
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

// -----------------------------------CHICKEN TABLE AND SQL QUERY-------------------------------------//
$main_query = "
SELECT coopNumber, male, female FROM chickenproduction
";

$main_query .= " GROUP BY coopNumber ";

$main_query .= ' ORDER BY coopNumber ASC ';

$statement = $conn->prepare($main_query);
$statement->execute();

$result = $conn->query($main_query, PDO::FETCH_ASSOC);

$data = array();

foreach($result as $row)
{
    $sub_array = array();

    $sub_array[] = $row['coopNumber'];

    $sub_array[] = $row['male'];

    $sub_array[] = $row['female'];

    // $sub_array[] = $row['reductions'];

    $data[] = $sub_array;
}

$output = array(
    "data"			=>	$data
);

//make the table
$html = "
<h3> Chicken Inventory </h3>
	<table>
		<tr>
			<th>Coop Number</th>
			<th>Male</th>
			<th>Female</th>
		</tr>
		";
//load the json data
// $file = file_get_contents('MOCK_DATA-100.json');
// $data = json_decode($file);

//loop the data
if(empty($output['data'])){
    $html .= '<tr><td colspan="5" style="text-align:center;">No records</td></tr>';
} else {
foreach($output['data'] as $chicken){	
	$html .= "
			<tr>
				<td>". $chicken[0] ."</td>
				<td>". $chicken[1] ."</td>
				<td>". $chicken[2] ."</td>
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
$main_query = "SELECT dispositionType, SUM(COALESCE(quantity,0)) as quantity FROM chickentransaction
WHERE archive = 'not archived' AND  dispositionType IN ('Culled', 'Sold', 'Death')";

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

    $sub_array[] = $row['quantity'];

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


//--------------------------------------IN STOCK SUMMARY BY EGG SIZE----------------------------------//
$main_query = "SELECT SUM(COALESCE(inStock,0)) as inStock, breedType FROM chickenproduction";

$main_query .= " GROUP BY breedType ";

$main_query .= ' ORDER BY breedType ASC ';

$statement = $conn->prepare($main_query);
$statement->execute();

$result = $conn->query($main_query, PDO::FETCH_ASSOC);
// $result = $statement->fetchAll(PDO::FETCH_ASSOC);

$data = array();

foreach($result as $row)
{
    $sub_array = array();

    $sub_array[] = $row['breedType'];

    $sub_array[] = $row['inStock'];

    $data[] = $sub_array;
}

$output = array(
    "data"			=>	$data
);

//make the table
$html3 = "
<h3>In Stock Summary By Breed Type</h3>
	<table>
		<tr>
			<th>Breed Type</th>
			<th>Total In Stock</th>
		</tr>
		";
//load the json data
// $file = file_get_contents('MOCK_DATA-100.json');
// $data = json_decode($file);

//loop the data
if(empty($output['data'])){
    $html3 .= '<tr><td colspan="5" style="text-align:center;">No records</td></tr>';
} else {
foreach($output['data'] as $breedType){	
	$html3 .= "
			<tr>
				<td>". $breedType[0] ."</td>
				<td>". $breedType[1] ."</td>
			</tr>
			";
}		
}
$html3 .= "
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
$pdf->WriteHTMLCell(192,0,9,'',$html3,0);	
$pdf->Ln();
$pdf->Ln(10);

//output
// $pdf->Output();

$pdf->Output('Chicken Report - '.$currentDate.'.pdf', 'D');