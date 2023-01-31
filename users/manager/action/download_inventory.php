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
$pdf->Cell(190,5,"INVENTORY REPORT",0,1,'C');
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

// -----------------------------------MEDICINE TABLE AND SQL QUERY-------------------------------------//
$main_query = "
SELECT DATE_FORMAT(m.dateAdded,'%M %d, %Y') AS dateAdded, m.medicineName, m.medicineName, DATE_FORMAT(m.expirationDate,'%M %d, %Y') AS expirationDate, m.startingQuantity, m.inStock, SUM(COALESCE(mr.quantity,0)) AS reductions
FROM medicines m
LEFT JOIN medicinereduction mr ON m.medicine_ID = mr.medicine_ID
WHERE m.archive = 'not archived' ";

if(isset($_POST["start_date"], $_POST["end_date"]) && $_POST["start_date"] != '' && $_POST["end_date"] != '')
{
	$main_query .= "AND m.dateAdded >= '".$_POST["start_date"]."' AND m.dateAdded <= '".$_POST["end_date"]."' ";
}

if(isset($_POST["search"]["value"]))
{
	$main_query .= "AND (m.medicineName LIKE '%".$_POST["search"]["value"]."%' OR m.inStock LIKE '%".$_POST["search"]["value"]."%' OR m.dateAdded LIKE '%".$_POST["search"]["value"]."%') ";
}

$main_query .= "GROUP BY m.medicine_ID";

$statement = $conn->prepare($main_query);// . $search_query . $group_by_query

$statement->execute();

$result = $conn->query($main_query, PDO::FETCH_ASSOC);// . $search_query . $group_by_query

$data = array();

foreach($result as $row)
{
	$sub_array = array();

	$sub_array[] = $row['dateAdded'];

	$sub_array[] = $row['medicineName'];

	$sub_array[] = $row['startingQuantity'];

	$sub_array[] = $row['inStock'];

	$sub_array[] = $row['reductions'];

	$data[] = $sub_array;
}

$output = array(
	"data"			=>	$data
);

//make the table
$html = "
<h3>Medicine Inventory </h3>
	<table>
		<tr>
			<th>Medicine ID</th>
			<th>Medicine Name</th>
			<th>Starting Quantity</th>
			<th>In Stock</th>
			<th>Reductions</th>
		</tr>
		";
//load the json data
// $file = file_get_contents('MOCK_DATA-100.json');
// $data = json_decode($file);

//loop the data
if(empty($output['data'])){
    $html .= '<tr><td colspan="5" style="text-align:center;">No records</td></tr>';
} else {
foreach($output['data'] as $medicine){	
	$html .= "
			<tr>
				<td>". $medicine[0] ."</td>
				<td>". $medicine[1] ."</td>
				<td>". $medicine[2] ."</td>
				<td>". $medicine[3] ."</td>
				<td>". $medicine[4] ."</td>
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

//--------------------------------------MEDICINES ABOUT TO EXPIRE TABLE AND QUERY------------------------------//
$main_query = "
SELECT DATE_FORMAT(dateAdded,'%M %d, %Y') AS dateAdded, medicineName, DATE_FORMAT(expirationDate,'%M %d, %Y') AS expirationDate, startingQuantity, inStock
FROM medicines
";

$search_query = ' WHERE archive = "not archived" AND DATEDIFF(expirationDate, NOW()) <=60 ';

$statement = $conn->prepare($main_query . $search_query ); 

$statement->execute();

$filtered_rows = $statement->rowCount();

$total_rows = $statement->rowCount();

$result = $conn->query($main_query . $search_query , PDO::FETCH_ASSOC); 

$data = array();

foreach($result as $row)
{
	$sub_array = array();

	$sub_array[] = $row['dateAdded'];

	$sub_array[] = $row['medicineName'];

	$sub_array[] = $row['expirationDate'];

	$sub_array[] = $row['startingQuantity'];

	$sub_array[] = $row['inStock'];

	$data[] = $sub_array;
}

$output = array(
	"data"			=>	$data
);

//make the table
$html2 = "
<h3>Medicines About To Expire </h3>
	<table>
		<tr>
			<th>Date Added</th>
			<th>Medicine Name</th>
			<th>Expiration Date</th>
			<th>Starting Quantity</th>
			<th>In Stock</th>
		</tr>
		";

//loop the data
if(empty($output['data'])){
    $html2 .= '<tr><td colspan="5" style="text-align:center;">No records</td></tr>';
} else {
foreach($output['data'] as $toexpire){	
	$html2 .= "
			<tr>
				<td>". $toexpire[0] ."</td>
				<td>". $toexpire[1] ."</td>
				<td>". $toexpire[2] ."</td>
				<td>". $toexpire[3] ."</td>
				<td>". $toexpire[4] ."</td>
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

//----------------------------MEDICINE LOW IN STOCK----------------------------//
$main_query = "
SELECT DATE_FORMAT(dateAdded,'%M %d, %Y') AS dateAdded, medicineName, DATE_FORMAT(expirationDate,'%M %d, %Y') AS expirationDate, startingQuantity, inStock
FROM medicines
";

$search_query = ' WHERE archive = "not archived" AND inStock <=10 ';

$statement = $conn->prepare($main_query . $search_query );

$statement->execute();

$filtered_rows = $statement->rowCount();

$total_rows = $statement->rowCount();

$result = $conn->query($main_query . $search_query , PDO::FETCH_ASSOC); 

$data = array();

foreach($result as $row)
{
	$sub_array = array();

	$sub_array[] = $row['dateAdded'];

	$sub_array[] = $row['medicineName'];

	$sub_array[] = $row['expirationDate'];

	$sub_array[] = $row['startingQuantity'];

	$sub_array[] = $row['inStock'];

	$data[] = $sub_array;
}

$output = array(
	"data"			=>	$data
);
//make the table
$html3 = "
<h3>Medicines Low In Stock </h3>
	<table>
		<tr>
			<th>Date Added</th>
			<th>Medicine Name</th>
			<th>Expiration Date</th>
			<th>Starting Quantity</th>
			<th>In Stock</th>
		</tr>
		";

//loop the data
if(empty($output['data'])){
    $html3 .= '<tr><td colspan="5" style="text-align:center;">No records</td></tr>';
} else {
foreach($output['data'] as $lowinstock){	
	$html3 .= "
			<tr>
				<td>". $lowinstock[0] ."</td>
				<td>". $lowinstock[1] ."</td>
				<td>". $lowinstock[2] ."</td>
				<td>". $lowinstock[3] ."</td>
				<td>". $lowinstock[4] ."</td>
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

//------------------FEEDS TBALE AND QUERY--------//
$main_query = "
SELECT DATE_FORMAT(f.datePurchased,'%M %d, %Y') as datePurchased, f.feedName, f.brand, f.startingQuantity, f.inStock, SUM(COALESCE(fr.quantity,0)) AS reductions
FROM feeds f
LEFT JOIN feedreduction fr ON f.feed_ID = fr.feed_ID
WHERE f.archive = 'not archived' ";
if(isset($_POST["start_date"], $_POST["end_date"]) && $_POST["start_date"] != '' && $_POST["end_date"] != '')
{
	$main_query .= "AND f.datePurchased >= '".$_POST["start_date"]."' AND f.datePurchased <= '".$_POST["end_date"]."' ";
}

if(isset($_POST["search"]["value"]))
{
	$main_query .= "AND (f.feedName LIKE '%".$_POST["search"]["value"]."%' OR f.inStock LIKE '%".$_POST["search"]["value"]."%' OR f.datePurchased LIKE '%".$_POST["search"]["value"]."%') ";
}

$main_query .= "GROUP BY f.feed_ID";

$statement = $conn->prepare($main_query);// . $search_query . $group_by_query

$statement->execute();

$result = $conn->query($main_query, PDO::FETCH_ASSOC);// . $search_query . $group_by_query

$data = array();

foreach($result as $row)
{
	$sub_array = array();

	$sub_array[] = $row['datePurchased'];

	$sub_array[] = $row['feedName'];

	$sub_array[] = $row['startingQuantity'];

	$sub_array[] = $row['inStock'];

	$sub_array[] = $row['reductions'];

	$data[] = $sub_array;
}

$output = array(
	"data"			=>	$data
);
//make the table
$html4 = "
<h3>Feeds Inventory </h3>
	<table>
		<tr>
			<th>Date Added</th>
			<th>Feed Name</th>
			<th>Starting Quantity</th>
			<th>In Stock</th>
			<th>Reductions</th>
		</tr>
		";

//loop the data
if(empty($output['data'])){
    $html4 .= '<tr><td colspan="5" style="text-align:center;">No records</td></tr>';
} else {
foreach($output['data'] as $feeds){	
	$html4 .= "
			<tr>
				<td>". $feeds[0] ."</td>
				<td>". $feeds[1] ."</td>
				<td>". $feeds[2] ."</td>
				<td>". $feeds[3] ."</td>
				<td>". $feeds[4] ."</td>
			</tr>
			";
}		
}
$html4 .= "
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
$pdf->WriteHTMLCell(192,0,9,'',$html4,0);	
$pdf->Ln();
$pdf->Ln(10);
//output
// $pdf->Output();

$pdf->Output('Inventory Report - '.$currentDate.'.pdf', 'D');
