<?php
require_once __DIR__ . '/connection/connection.php';
$province_id = $_GET['province_id'] ?? '';
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.rajaongkir.com/starter/city?province=$province_id",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => ["key: $RAJAONGKIR_API_KEY"],
]);
$response = curl_exec($curl);
$data = json_decode($response, true);
foreach ($data['rajaongkir']['results'] as $c) {
    echo "<option value='{$c['city_id']}'
        province_name='" . htmlspecialchars($c['province'], ENT_QUOTES) . "'
        city_name='" . htmlspecialchars($c['city_name'], ENT_QUOTES) . "'
        city_type='" . htmlspecialchars($c['type'], ENT_QUOTES) . "'
        postal_code='{$c['postal_code']}'>
        {$c['city_name']}
    </option>";
}
?>