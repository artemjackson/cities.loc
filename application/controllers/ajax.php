<?php

    $region_id = $_POST['id'];
    $cities = Controller::getCitiesByRegionId($region_id);

    ob_start();
    include($_SERVER['DOCUMENT_ROOT']  . "/application/views/city_options.phtml");
    $content = ob_get_contents();
    ob_end_clean();

    echo json_encode(array('html' => $content));
    exit;