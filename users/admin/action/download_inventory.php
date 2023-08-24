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
SELECT reductionType, SUM(COALESCE(quantity,0)) as quantity FROM medicinetransaction
WHERE archive = 'not archived' ";

if(isset($_POST["start_date"], $_POST["end_date"]) && $_POST["start_date"] != '' && $_POST["end_date"] != '')
{
	$main_query .= "AND transactionDate >= '".$_POST["start_date"]."' AND transactionDate <= '".$_POST["end_date"]."' ";
}

// if(isset($_POST["search"]["value"]))
// {
// 	$main_query .= "AND (medicineName LIKE '%".$_POST["search"]["value"]."%' OR inStock LIKE '%".$_POST["search"]["value"]."%' OR transactionDate LIKE '%".$_POST["search"]["value"]."%') ";
// }

$main_query .= "GROUP BY reductionType";

$statement = $conn->prepare($main_query);// . $search_query . $group_by_query

$statement->execute();

$result = $conn->query($main_query, PDO::FETCH_ASSOC);// . $search_query . $group_by_query

$data = array();

foreach($result as $row)
{
	$sub_array = array();

	// $sub_array[] = $row['transactionDate'];

	$sub_array[] = $row['reductionType'];

	// $sub_array[] = $row['startingQuantity'];

	// $sub_array[] = $row['inStock'];

	$sub_array[] = $row['quantity'];

	$data[] = $sub_array;
}

$output = array(
	"data"			=>	$data
);

//make the table
$html = "
<h3>Summary By Medicine Reduction Type </h3>
	<table>
		<tr>
			<th>Reduction Type</th>
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
SELECT medicineName, DATE_FORMAT(expirationDate,'%M %d, %Y') AS expirationDate, inStock
FROM medicines
";

$search_query = ' WHERE DATEDIFF(expirationDate, NOW()) <=60 ';

$statement = $conn->prepare($main_query . $search_query ); 

$statement->execute();

$filtered_rows = $statement->rowCount();

$total_rows = $statement->rowCount();

$result = $conn->query($main_query . $search_query , PDO::FETCH_ASSOC); 

$data = array();

foreach($result as $row)
{
	$sub_array = array();

	// $sub_array[] = $row['dateAdded'];

	$sub_array[] = $row['medicineName'];

	$sub_array[] = $row['expirationDate'];

	// $sub_array[] = $row['startingQuantity'];

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
			<th>Medicine Name</th>
			<th>Expiration Date</th>
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
SELECT medicineName, DATE_FORMAT(expirationDate,'%M %d, %Y') AS expirationDate, inStock
FROM medicines
";

$search_query = ' WHERE	 inStock <=10 ';

$statement = $conn->prepare($main_query . $search_query );

$statement->execute();

$filtered_rows = $statement->rowCount();

$total_rows = $statement->rowCount();

$result = $conn->query($main_query . $search_query , PDO::FETCH_ASSOC); 

$data = array();

foreach($result as $row)
{
	$sub_array = array();

	// $sub_array[] = $row['dateAdded'];

	$sub_array[] = $row['medicineName'];

	$sub_array[] = $row['expirationDate'];

	// $sub_array[] = $row['startingQuantity'];

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
			<th>Medicine Name</th>
			<th>Expiration Date</th>
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
//low in stock
$main_query = "
SELECT feedName, inStock
FROM feeds
";

$search_query = ' WHERE inStock <=10 ';

$statement = $conn->prepare($main_query . $search_query );

$statement->execute();

$filtered_rows = $statement->rowCount();

$total_rows = $statement->rowCount();

$result = $conn->query($main_query . $search_query , PDO::FETCH_ASSOC); 

$data = array();

foreach($result as $row)
{
	$sub_array = array();

	// $sub_array[] = $row['dateAdded'];

	$sub_array[] = $row['feedName'];

	// $sub_array[] = $row['expirationDate'];

	// $sub_array[] = $row['startingQuantity'];

	$sub_array[] = $row['inStock'];

	$data[] = $sub_array;
}

$output = array(
	"data"			=>	$data
);
//make the table
$html4 = "
<h3>Feeds Low In Stock </h3>
	<table>
		<tr>
			<th>Feed Name</th>
			<th>In Stock</th>
		</tr>
		";

//loop the data
if(empty($output['data'])){
    $html4 .= '<tr><td colspan="5" style="text-align:center;">No records</td></tr>';
} else {
foreach($output['data'] as $lowinstock){	
	$html4 .= "
			<tr>
				<td>". $lowinstock[0] ."</td>
				<td>". $lowinstock[1] ."</td>
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

//reduction type
$main_query = "
SELECT reductionType, SUM(COALESCE(quantity,0)) as quantity FROM feedtransaction
WHERE archive = 'not archived' ";

if(isset($_POST["start_date"], $_POST["end_date"]) && $_POST["start_date"] != '' && $_POST["end_date"] != '')
{
	$main_query .= "AND transactionDate >= '".$_POST["start_date"]."' AND transactionDate <= '".$_POST["end_date"]."' ";
}

// if(isset($_POST["search"]["value"]))
// {
// 	$main_query .= "AND (medicineName LIKE '%".$_POST["search"]["value"]."%' OR inStock LIKE '%".$_POST["search"]["value"]."%' OR transactionDate LIKE '%".$_POST["search"]["value"]."%') ";
// }

$main_query .= "GROUP BY reductionType";

$statement = $conn->prepare($main_query);// . $search_query . $group_by_query

$statement->execute();

$result = $conn->query($main_query, PDO::FETCH_ASSOC);// . $search_query . $group_by_query

$data = array();

foreach($result as $row)
{
	$sub_array = array();

	// $sub_array[] = $row['transactionDate'];

	$sub_array[] = $row['reductionType'];

	// $sub_array[] = $row['startingQuantity'];

	// $sub_array[] = $row['inStock'];

	$sub_array[] = $row['quantity'];

	$data[] = $sub_array;
}

$output = array(
	"data"			=>	$data
);

//make the table
$html5 = "
<h3>Summary By Feed Reduction Type </h3>
	<table>
		<tr>
			<th>Reduction Type</th>
			<th>Reductions</th>
		</tr>
		";
//load the json data
// $file = file_get_contents('MOCK_DATA-100.json');
// $data = json_decode($file);

//loop the data
if(empty($output['data'])){
    $html5 .= '<tr><td colspan="5" style="text-align:center;">No records</td></tr>';
} else {
foreach($output['data'] as $feeds){	
	$html5 .= "
			<tr>
				<td>". $feeds[0] ."</td>
				<td>". $feeds[1] ."</td>
			</tr>
			";
}		
}
$html5 .= "
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
$pdf->WriteHTMLCell(192,0,9,'',$html5,0);	
$pdf->Ln();
$pdf->Ln(10);

$pdf->Output('Inventory Report - '.$currentDate.'.pdf', 'D');
