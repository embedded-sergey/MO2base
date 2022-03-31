<?php
// Connect to database
require_once 'database.php';

// Request filters sql_codes
$db_request = 'SELECT td.json_ident, 
f.sql_code
FROM table_data td
LEFT JOIN filters f on f.id = td.filter_id';
// Exec query
$filter_data = $DB->query($db_request)->fetchAll();

// POST request content
$request_body = file_get_contents('php://input');
// Convert to JSON
$json_data = json_decode($request_body, true);
// echo $request_body;

// Request for data w/o filters
$db_request = 'SELECT meas.id, species.name species, publication.name publication, mmr_method.name mmr_method, 
meas.temperature, meas.salinity, meas.do_level, meas.smr_avg,
meas.smr_min, meas.smr_max, meas.mmr_avg, meas.mmr_max,
meas.mass_avg, meas.comment, br_test.name
FROM measurements meas 
LEFT JOIN species on species.id = meas.species_id 
LEFT JOIN mmr_method on mmr_method.id = meas.mmr_method_id 
LEFT JOIN publication on publication.id = meas.publication_id
LEFT JOIN br_test on br_test.id = meas.br_test_id';

// First time WHERE flag, next times AND
$where_flag = 0;

// For each available filter from DB
foreach($filter_data as $row)
{
    // if available filter in json_data from POST
    if (array_key_exists($row['json_ident'], $json_data))
    {
        if ($where_flag == 0)
        {
            $where_flag = 1;
            $db_request .= ' WHERE ';
        } 
        else
            $db_request .= ' AND ';
        // Replace keys by values
        $db_request .= str_replace(array('%JSON_ID%', '%VALUE%'),
                                   array($row['json_ident'], $json_data[$row['json_ident']]),
                                   $row['sql_code']);
    }
    // if available filter for minimum value in json_data from POST 
    if (array_key_exists($row['json_ident'].'__min', $json_data))
    {
        if ($where_flag == 0)
        {
            $where_flag = 1;
            $db_request .= ' WHERE ';
        } 
        else
            $db_request .= ' AND ';
        // Replace keys by values
        $db_request .= $json_data[$row['json_ident'] . '__min'] . ' <= meas.' . $row['json_ident'];
    }
    // if available filter for maximum value in json_data from POST
    if (array_key_exists($row['json_ident'].'__max', $json_data))
    {
        if ($where_flag == 0)
        {
            $where_flag = 1;
            $db_request .= ' WHERE ';
        } 
        else
            $db_request .= ' AND ';
        // Replace keys by values
        $db_request .= 'meas.' . $row['json_ident'] . ' <= ' . $json_data[$row['json_ident'] . '__max'];
    }
}

// echo $db_request;
// Exec query
$stmt = $DB->query($db_request);

// For printing commas after elements in list
$comma_flag = 0;

echo "{\r\n";
echo "  \"count\":" . $stmt->rowCount() . ",\r\n";
echo "  \"data\": [";
// Each row from DB -> JSON.data
while ($row = $stmt->fetch())
{
    if ($comma_flag)
        echo ",";
    else
        $comma_flag = 1;    
    echo "\r\n";
    
    echo "    {\r\n";
    // for each colunt set it name and value
    for ($i = 0; $i < $stmt->columnCount(); $i++) 
    {
        $col = $stmt->getColumnMeta($i);
        // echo $col['native_type'];
        echo "      \"" . $col['name'] . "\":";

        if ( isset($row[$i]))
        {
            // quotes if its req. for strings
            if ($col['native_type'] == "STRING"
            ||  $col['native_type'] == "VAR_STRING"
            ||  $col['native_type'] == "BLOB"
            )
                echo "\"";
            // print value
            echo $row[$i];
            // quotes if its req. for strings
            if ($col['native_type'] == "STRING"
            ||  $col['native_type'] == "VAR_STRING"
            ||  $col['native_type'] == "BLOB"
                )
                echo "\"";
        }
        else
            echo "null";
        
        if ($i < $stmt->columnCount()-1)
            echo ",";
        echo "\r\n";
    }
    echo "    }";
}
echo "\r\n ]";
echo "\r\n}";

?>