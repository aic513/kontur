<?php

$data1 = json_decode(file_get_contents('/home/denis/projects/kontur/1.json'), true);
$data2 = json_decode(file_get_contents('/home/denis/projects/kontur/2.json'), true);

$data2_dict = [];
foreach ($data2 as $item) {
    $data2_dict[$item['id']] = $item;
}

$result = [];
foreach ($data1 as $item) {
    if ($item['status'] == 'need_to_update') {
        $id = $item['id'];
        if (isset($data2_dict[$id])) {
            $item['counter'] += $data2_dict[$id]['counter'];
        }
        $result[] = $item;
    }
}

$sql_statements = [];
foreach ($result as $item) {
    $sql = sprintf(
        "INSERT INTO bd.tbl_test (id, status, counter) 
                VALUES (%d, '%s', %d) 
                ON DUPLICATE KEY UPDATE counter = counter + VALUES(counter);",
        $item['id'],
        $item['status'],
        $item['counter']
    );
    $sql_statements[] = $sql;
}

foreach ($sql_statements as $sql) {
    echo $sql . "\n";
}


