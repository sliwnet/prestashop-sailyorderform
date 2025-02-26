<?php
require_once dirname(__FILE__).'/../../config/config.inc.php';
require_once dirname(__FILE__).'/../../init.php';

$token = Tools::getValue('token');
$secureToken = Configuration::get('ORDERDATECRON_TOKEN');

if (!$token || $token !== $secureToken) {
    die('Unauthorized access');
}

$sql = "SELECT id_order_detail, product_name FROM "._DB_PREFIX_."order_detail WHERE termin IS NULL";
$results = Db::getInstance()->executeS($sql);

foreach ($results as $row) {
    if (preg_match('/(\d{2})\.(\d{2})\.(\d{4})/', $row['product_name'], $matches)) {
        $dateFormatted = $matches[3] . '-' . $matches[2] . '-' . $matches[1] . ' 00:00:00';
        Db::getInstance()->update('order_detail', ['termin' => $dateFormatted], 'id_order_detail=' . (int)$row['id_order_detail']);
    }
}

die('Cron executed successfully');
