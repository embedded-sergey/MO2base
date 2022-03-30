<?php

require_once 'database.php';

$request_body = file_get_contents('php://input');

$json_data = json_decode($request_body);

$db_request = 'SELECT l.id, s.name species, p.doi publication, mmr.name mmr_method, 
meas.temperature, meas.salinity, meas.do_level, meas.smr_avg,
meas.smr_min, meas.smr_max, meas.mmr_avg, meas.mmr_max,
meas.mass_avg, meas.br_test, meas.comment 
FROM links l 
LEFT JOIN species s on s.id = l.species_id 
LEFT JOIN measurements meas on meas.id = l.measurements_id 
LEFT JOIN mmr_method mmr on mmr.id = l.mmr_method_id 
LEFT JOIN publication p on p.id = l.publication_id ';

$where_flag = 0;

if (array_key_exists('filter_Species', $json_data))
{
    if ($where_flag == 0)
    {
        $where_flag = 1;
        $db_request .= 'WHERE ';
    }
    $db_request .= 's.name = "' . $json_data['filter_Species'] . '*" ';
}

if (array_key_exists('filter_Publication', $json_data))
{
    if ($where_flag == 0)
    {
        $where_flag = 1;
        $db_request .= 'WHERE ';
    }
    $db_request .= 'pub.doi = "' . $json_data['filter_Publication'] . '*" ';
}

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
        echo "      \"" . $col['name'] . "\":";
        if ($col['native_type'] == "STRING"
        ||  $col['native_type'] == "VAR_STRING"
        ||  $col['native_type'] == "BLOB")
            echo "\"";
        if (isset($row[$i]))
            echo $row[$i];
        else
            echo "null";
        if ($col['native_type'] == "STRING"
        ||  $col['native_type'] == "VAR_STRING"
        ||  $col['native_type'] == "BLOB")
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