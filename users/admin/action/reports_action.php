<?php

//database connection, located in the config directory
include('../../../config/database_connection.php');

if(isset($_POST["action"]))
{
	//-------------------------CHICKEN REPORT-----------------------------//
	if($_POST["action"] == 'fetch')
	{

		$order_column = array('dateAcquired','totalQuantity', 'instock','reductions');

		$main_query = "
		SELECT cp.chickenBatch_ID, SUM(COALESCE(cp.inStock,0)) AS inStock, cp.dateAcquired, SUM(COALESCE(cp.startingQuantity,0)) as totalQuantity, SUM(COALESCE(cr.quantity,0)) as reductions
		FROM chickenproduction cp
		LEFT JOIN chickenreduction cr ON cp.chickenBatch_ID = cr.chickenBatch_ID
		";

		$search_query = ' WHERE cp.archive = "not archived" AND ';

		if(isset($_POST["start_date"], $_POST["end_date"]) && $_POST["start_date"] != '' && $_POST["end_date"] != '')
		{
			$search_query .= 'cp.dateAcquired >= "'.$_POST["start_date"].'" AND cp.dateAcquired <= "'.$_POST["end_date"].'" AND ';
		}

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= '(cp.chickenBatch_ID LIKE "%'.$_POST["search"]["value"].'%" OR inStock LIKE "%'.$_POST["search"]["value"].'%" OR cp.dateAcquired LIKE "%'.$_POST["search"]["value"].'%")';
		}

		$group_by_query = " GROUP BY cp.dateAcquired ";

		$order_by_query = "";

		if(isset($_POST["order"]))
		{
			$order_by_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_by_query = 'ORDER BY cp.dateAcquired DESC ';
		}

		$limit_query = '';

		if($_POST["length"] != -1)
		{
			$limit_query = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}

		$statement = $conn->prepare($main_query . $search_query . $group_by_query . $order_by_query);

		$statement->execute();

		$filtered_rows = $statement->rowCount();

		$statement = $conn->prepare($main_query . $group_by_query);

		$statement->execute();

		$total_rows = $statement->rowCount();

		$result = $conn->query($main_query . $search_query . $group_by_query . $order_by_query . $limit_query, PDO::FETCH_ASSOC);

		$data = array();

		foreach($result as $row)
		{
			$sub_array = array();

			$sub_array[] = $row['dateAcquired'];

			// $sub_array[] = $row['chickenBatch_ID'];

			$sub_array[] = $row['totalQuantity'];

			$sub_array[] = $row['inStock'];

			$sub_array[] = $row['reductions'];

			$data[] = $sub_array;
		}

		$output = array(
			"draw"			=>	intval($_POST["draw"]),
			"recordsTotal"	=>	$total_rows,
			"recordsFiltered" => $filtered_rows,
			"data"			=>	$data
		);

		echo json_encode($output);
	}

	if($_POST["action"] == 'reduction')
	{
		$order_column = array('dispositionType','quantity');

		$reductions_query = "
		SELECT dispositionType, quantity FROM chickentransaction
		";

		$search_query = ' WHERE archive = "not archived" AND  dispositionType IN ("Culled", "Sold", "Death") AND ';

		if(isset($_POST["start_date"], $_POST["end_date"]) && $_POST["start_date"] != '' && $_POST["end_date"] != '')
		{
			$search_query .= ' transactionDate >= "'.$_POST["start_date"].'" AND transactionDate <= "'.$_POST["end_date"].'" AND ';
		}

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= ' (transactionDate LIKE "%'.$_POST["search"]["value"].'%")';
		}

		$group_by_query = " GROUP BY dispositionType ";

		
		$order_by_query = "";

		if(isset($_POST["order"]))
		{
			$order_by_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_by_query = 'ORDER BY transaction_ID DESC ';
		}

		$statement = $conn->prepare($reductions_query . $search_query . $group_by_query . $order_by_query);

		$statement->execute();

		$filtered_rows = $statement->rowCount();

		$statement = $conn->prepare($reductions_query . $group_by_query);

		$statement->execute();

		$total_rows = $statement->rowCount();

		$result = $conn->query($reductions_query . $search_query . $group_by_query . $order_by_query, PDO::FETCH_ASSOC);

		$data = array();

		foreach($result as $row)
		{
			$sub_array = array();

			$sub_array[] = $row['dispositionType'];

			$sub_array[] = $row['quantity'];

			$data[] = $sub_array;
		}

		$output = array(
			"draw"			=>	intval($_POST["draw"]),
			"recordsTotal"	=>	$total_rows,
			"recordsFiltered" => $filtered_rows,
			"data"			=>	$data
		);
		
		echo json_encode($output);
	}

	if($_POST["action"] == 'breed')
	{
		$order_column = array('breedType','instock');

		$reductions_query = "
		SELECT breedType, SUM(COALESCE(inStock, 0)) as instock
		FROM chickenproduction
		";

		$search_query = ' WHERE archive = "not archived" AND ';

		if(isset($_POST["start_date"], $_POST["end_date"]) && $_POST["start_date"] != '' && $_POST["end_date"] != '')
		{
			$search_query .= ' dateAcquired >= "'.$_POST["start_date"].'" AND dateAcquired <= "'.$_POST["end_date"].'" AND ';
		}

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= ' (dateAcquired LIKE "%'.$_POST["search"]["value"].'%")';
		}

		$group_by_query = " GROUP BY breedType ";

		
		$order_by_query = "";

		if(isset($_POST["order"]))
		{
			$order_by_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_by_query = 'ORDER BY breedType DESC ';
		}

		$statement = $conn->prepare($reductions_query . $search_query . $group_by_query . $order_by_query);

		$statement->execute();

		$filtered_rows = $statement->rowCount();

		$statement = $conn->prepare($reductions_query . $group_by_query);

		$statement->execute();

		$total_rows = $statement->rowCount();

		$result = $conn->query($reductions_query . $search_query . $group_by_query . $order_by_query, PDO::FETCH_ASSOC);

		$data = array();

		foreach($result as $row)
		{
			$sub_array = array();

			$sub_array[] = $row['breedType'];

			$sub_array[] = $row['instock'];

			$data[] = $sub_array;
		}

		$output = array(
			"draw"			=>	intval($_POST["draw"]),
			"recordsTotal"	=>	$total_rows,
			"recordsFiltered" => $filtered_rows,
			"data"			=>	$data
		);
		
		echo json_encode($output);
	}

	if($_POST["action"] == 'egg_reduction')
	{
		$order_column = array('dispositionType','quantity');

		$reductions_query = "
		SELECT dispositionType, SUM(COALESCE(quantity, 0)) as quantity
		FROM eggtransaction
		";

		$search_query = ' WHERE archive = "not archived" AND dispositionType IN ("Distributed to Customer", "Personal Consumption", "Spoiled") AND ';

		if(isset($_POST["start_date"], $_POST["end_date"]) && $_POST["start_date"] != '' && $_POST["end_date"] != '')
		{
			$search_query .= ' transactionDate >= "'.$_POST["start_date"].'" AND transactionDate <= "'.$_POST["end_date"].'" AND ';
		}

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= ' (transactionDate LIKE "%'.$_POST["search"]["value"].'%")';
		}

		$group_by_query = " GROUP BY dispositionType ";

		
		$order_by_query = "";

		if(isset($_POST["order"]))
		{
			$order_by_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_by_query = 'ORDER BY dispositionType DESC ';
		}

		$statement = $conn->prepare($reductions_query . $search_query . $group_by_query . $order_by_query);

		$statement->execute();

		$filtered_rows = $statement->rowCount();

		$statement = $conn->prepare($reductions_query . $group_by_query);

		$statement->execute();

		$total_rows = $statement->rowCount();

		$result = $conn->query($reductions_query . $search_query . $group_by_query . $order_by_query, PDO::FETCH_ASSOC);

		$data = array();

		foreach($result as $row)
		{
			$sub_array = array();

			$sub_array[] = $row['dispositionType'];

			$sub_array[] = $row['quantity'];

			$data[] = $sub_array;
		}

		$output = array(
			"draw"			=>	intval($_POST["draw"]),
			"recordsTotal"	=>	$total_rows,
			"recordsFiltered" => $filtered_rows,
			"data"			=>	$data
		);
		
		echo json_encode($output);
	}

	if($_POST["action"] == 'eggsize')
	{
		$order_column = array('eggSize','instock');

		$reductions_query = "
		SELECT eggSize, SUM(COALESCE(quantity, 0)) as instock FROM eggproduction
		";

		$search_query = ' WHERE archive = "not archived" AND ';

		if(isset($_POST["start_date"], $_POST["end_date"]) && $_POST["start_date"] != '' && $_POST["end_date"] != '')
		{
			$search_query .= ' collectionDate >= "'.$_POST["start_date"].'" AND collectionDate <= "'.$_POST["end_date"].'" AND ';
		}

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= ' (collectionDate LIKE "%'.$_POST["search"]["value"].'%")';
		}

		$group_by_query = " GROUP BY eggSize ";

		
		$order_by_query = "";

		if(isset($_POST["order"]))
		{
			$order_by_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_by_query = 'ORDER BY eggSize DESC ';
		}

		$statement = $conn->prepare($reductions_query . $search_query . $group_by_query . $order_by_query);

		$statement->execute();

		$filtered_rows = $statement->rowCount();

		$statement = $conn->prepare($reductions_query . $group_by_query);

		$statement->execute();

		$total_rows = $statement->rowCount();

		$result = $conn->query($reductions_query . $search_query . $group_by_query . $order_by_query, PDO::FETCH_ASSOC);

		$data = array();

		foreach($result as $row)
		{
			$sub_array = array();

			$sub_array[] = $row['eggSize'];

			$sub_array[] = $row['instock'];

			$data[] = $sub_array;
		}

		$output = array(
			"draw"			=>	intval($_POST["draw"]),
			"recordsTotal"	=>	$total_rows,
			"recordsFiltered" => $filtered_rows,
			"data"			=>	$data
		);
		
		echo json_encode($output);
	}

	//----------------------MEDICINE REPORTS--------------------//
	if($_POST["action"] == 'medicinereduction')
	{
		
		$order_column = array('reductionType','quantity');

		$reductions_query = "
		SELECT reductionType, SUM(COALESCE(quantity,0)) as quantity FROM medicinetransaction
		";

		$search_query = ' WHERE archive = "not archived" AND  reductionType IN ("Used", "Expired") AND ';

		if(isset($_POST["start_date"], $_POST["end_date"]) && $_POST["start_date"] != '' && $_POST["end_date"] != '')
		{
			$search_query .= ' transactionDate >= "'.$_POST["start_date"].'" AND transactionDate <= "'.$_POST["end_date"].'" AND ';
		}

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= ' (transactionDate LIKE "%'.$_POST["search"]["value"].'%")';
		}

		$group_by_query = " GROUP BY reductionType ";

		
		$order_by_query = "";

		if(isset($_POST["order"]))
		{
			$order_by_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_by_query = 'ORDER BY transaction_ID DESC ';
		}

		$statement = $conn->prepare($reductions_query . $search_query . $group_by_query . $order_by_query);

		$statement->execute();

		$filtered_rows = $statement->rowCount();

		$statement = $conn->prepare($reductions_query . $group_by_query);

		$statement->execute();

		$total_rows = $statement->rowCount();

		$result = $conn->query($reductions_query . $search_query . $group_by_query . $order_by_query, PDO::FETCH_ASSOC);

		$data = array();

		foreach($result as $row)
		{
			$sub_array = array();

			$sub_array[] = $row['reductionType'];

			$sub_array[] = $row['quantity'];

			$data[] = $sub_array;
		}

		$output = array(
			"draw"			=>	intval($_POST["draw"]),
			"recordsTotal"	=>	$total_rows,
			"recordsFiltered" => $filtered_rows,
			"data"			=>	$data
		);
		
		echo json_encode($output);

	}

	if($_POST["action"] == 'toexpire')
	{
		$order_column = array('medicineName','expirationDate','inStock');

		$main_query = "
		SELECT medicineName, expirationDate, inStock
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
			"draw"			=>	intval($_POST["draw"]),
			"recordsTotal"	=>	$total_rows,
			"recordsFiltered" => $filtered_rows,
			"data"			=>	$data
		);

		echo json_encode($output);
	}

	if($_POST["action"] == 'lowstock')
	{
		$order_column = array('medicineName','expirationDate','inStock');

		$main_query = "
		SELECT medicineName, expirationDate, inStock
		FROM medicines
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

			$sub_array[] = $row['medicineName'];

			$sub_array[] = $row['expirationDate'];

			// $sub_array[] = $row['startingQuantity'];

			$sub_array[] = $row['inStock'];

			$data[] = $sub_array;
		}

		$output = array(
			"draw"			=>	intval($_POST["draw"]),
			"recordsTotal"	=>	$total_rows,
			"recordsFiltered" => $filtered_rows,
			"data"			=>	$data
		);

		echo json_encode($output);
	}

	if($_POST["action"] == 'feeds_lowstock')
	{
		$order_column = array('feedName','inStock');

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
			"draw"			=>	intval($_POST["draw"]),
			"recordsTotal"	=>	$total_rows,
			"recordsFiltered" => $filtered_rows,
			"data"			=>	$data
		);

		echo json_encode($output);
	}

	//----------------------FEEDS REPORTS--------------------//
	if($_POST["action"] == 'feeds')
	{
		$order_column = array('datePurchased','feedName','startingQuantity','inStock','reductions');

		$main_query = "
		SELECT f.datePurchased, f.feedName, f.brand, f.startingQuantity, f.inStock, SUM(COALESCE(fr.quantity,0)) AS reductions
		FROM feeds f
		LEFT JOIN feedreduction fr ON f.feed_ID = fr.feed_ID
		";

		$search_query = ' WHERE f.archive = "not archived" AND ';

		if(isset($_POST["start_date"], $_POST["end_date"]) && $_POST["start_date"] != '' && $_POST["end_date"] != '')
		{
			$search_query .= 'f.datePurchased >= "'.$_POST["start_date"].'" AND f.datePurchased <= "'.$_POST["end_date"].'" AND ';
		}

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= '(f.datePurchased LIKE "%'.$_POST["search"]["value"].'%")';
		}

		$group_by_query = " GROUP BY f.feed_ID "; // AND f.datePurchased

		$order_by_query = "";

		if(isset($_POST["order"]))
		{
			$order_by_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_by_query = 'ORDER BY f.datePurchased DESC ';
		}

		$limit_query = '';

		if($_POST["length"] != -1)
		{
			$limit_query = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}

		$statement = $conn->prepare($main_query . $search_query . $group_by_query . $order_by_query);

		$statement->execute();

		$filtered_rows = $statement->rowCount();

		$statement = $conn->prepare($main_query . $group_by_query);

		$statement->execute();

		$total_rows = $statement->rowCount();

		$result = $conn->query($main_query . $search_query . $group_by_query . $order_by_query . $limit_query, PDO::FETCH_ASSOC);

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
			"draw"			=>	intval($_POST["draw"]),
			"recordsTotal"	=>	$total_rows,
			"recordsFiltered" => $filtered_rows,
			"data"			=>	$data
		);

		echo json_encode($output);
	}

	if($_POST["action"] == 'feedreduction')
	{
		
		$order_column = array('reductionType','quantity');

		$reductions_query = "
		SELECT reductionType, SUM(COALESCE(quantity,0)) as quantity FROM feedtransaction
		";

		$search_query = ' WHERE archive = "not archived" AND  reductionType IN ("Used", "Damaged") AND ';

		if(isset($_POST["start_date"], $_POST["end_date"]) && $_POST["start_date"] != '' && $_POST["end_date"] != '')
		{
			$search_query .= ' transactionDate >= "'.$_POST["start_date"].'" AND transactionDate <= "'.$_POST["end_date"].'" AND ';
		}

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= ' (transactionDate LIKE "%'.$_POST["search"]["value"].'%")';
		}

		$group_by_query = " GROUP BY reductionType ";

		
		$order_by_query = "";

		if(isset($_POST["order"]))
		{
			$order_by_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_by_query = 'ORDER BY transaction_ID DESC ';
		}

		$statement = $conn->prepare($reductions_query . $search_query . $group_by_query . $order_by_query);

		$statement->execute();

		$filtered_rows = $statement->rowCount();

		$statement = $conn->prepare($reductions_query . $group_by_query);

		$statement->execute();

		$total_rows = $statement->rowCount();

		$result = $conn->query($reductions_query . $search_query . $group_by_query . $order_by_query, PDO::FETCH_ASSOC);

		$data = array();

		foreach($result as $row)
		{
			$sub_array = array();

			$sub_array[] = $row['reductionType'];

			$sub_array[] = $row['quantity'];

			$data[] = $sub_array;
		}

		$output = array(
			"draw"			=>	intval($_POST["draw"]),
			"recordsTotal"	=>	$total_rows,
			"recordsFiltered" => $filtered_rows,
			"data"			=>	$data
		);
		
		echo json_encode($output);
	}
}
