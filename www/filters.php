<?php

require_once 'database.php';

$db_request = 'SELECT td.json_ident, 
f.sql_code
FROM table_data td
LEFT JOIN filters f on f.id = td.filter_id';

$filter_data = $DB->query($db_request)->fetchAll();


$request_body = file_get_contents('php://input');
// echo $request_body;
$json_data = json_decode($request_body, true);

$db_request = 'SELECT meas.id, species.name species, publication.name publication, mmr_method.name mmr_method, 
meas.temperature, meas.salinity, meas.do_level, meas.smr_avg,
meas.smr_min, meas.smr_max, meas.mmr_avg, meas.mmr_max,
meas.mass_avg, meas.comment, br_test.name
FROM measurements meas 
LEFT JOIN species on species.id = meas.species_id 
LEFT JOIN mmr_method on mmr_method.id = meas.mmr_method_id 
LEFT JOIN publication on publication.id = meas.publication_id
LEFT JOIN br_test on br_test.id = meas.br_test_id';

$where_flag = 0;

foreach($filter_data as $row)
{
    if (array_key_exists($row['json_ident'], $json_data))
    {
        if ($where_flag == 0)
        {
            $where_flag = 1;
            $db_request .= ' WHERE ';
        } 
        else
            $db_request .= ' AND ';
        $db_request .= str_replace(array('%JSON_ID%', '%VALUE%'),
                                   array($row['json_ident'], $json_data[$row['json_ident']]),
                                   $row['sql_code']);
    }
    if (array_key_exists($row['json_ident'].'__min', $json_data))
    {
        if ($where_flag == 0)
        {
            $where_flag = 1;
            $db_request .= ' WHERE ';
        } 
        else
            $db_request .= ' AND ';
        $db_request .= $json_data[$row['json_ident'] . '__min'] . ' <= meas.' . $row['json_ident'];
    }
    if (array_key_exists($row['json_ident'].'__max', $json_data))
    {
        if ($where_flag == 0)
        {
            $where_flag = 1;
            $db_request .= ' WHERE ';
        } 
        else
            $db_request .= ' AND ';
        $db_request .= 'meas.' . $row['json_ident'] . ' <= ' . $json_data[$row['json_ident'] . '__max'];
    }
}

// echo $db_request;
$stmt = $DB->query($db_request);

$comma_flag = 0;
echo "{\r\n";
echo "  \"count\":" . $stmt->rowCount() . ",\r\n";
echo "  \"data\": [";
while ($row = $stmt->fetch())
{
    if ($comma_flag)
        echo ",";
    else
        $comma_flag = 1;    
    echo "\r\n";
    
    echo "    {\r\n";
    for ($i = 0; $i < $stmt->columnCount(); $i++) 
    {
        $col = $stmt->getColumnMeta($i);
        // echo $col['native_type'];
        echo "      \"" . $col['name'] . "\":";
        if ( isset($row[$i])
        &&  (   $col['native_type'] == "STRING"
             || $col['native_type'] == "VAR_STRING"
             || $col['native_type'] == "BLOB"
            )
        )
            echo "\"";
        if (isset($row[$i]))
            echo $row[$i];
        else
            echo "null";
        if ( isset($row[$i])
        &&  (   $col['native_type'] == "STRING"
                || $col['native_type'] == "VAR_STRING"
                || $col['native_type'] == "BLOB"
            )
        )
            echo "\"";
        if ($i < $stmt->columnCount()-1)
            echo ",";
        echo "\r\n";
    }
    echo "    }";
}
echo "\r\n ]";
echo "\r\n}";

?>