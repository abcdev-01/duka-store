<?php
require_once __DIR__ . '/connection/connection.php';
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => ["key: $RAJAONGKIR_API_KEY"],
]);
$response = curl_exec($curl);
$data = json_decode($response, true);
echo "<option value=''>-- Select Province --</option>";
foreach ($data['rajaongkir']['results'] as $p) {
    echo "<option value='{$p['province_id']}'>{$p['province']}</option>";
}
?>