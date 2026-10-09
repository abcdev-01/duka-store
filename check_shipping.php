<?php
require_once __DIR__ . '/connection/connection.php';
$city_id = $_POST['city_id'] ?? '';
$courier = $_POST['courier'] ?? '';
$weight = intval($_POST['weight'] ?? 0);

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => "origin=$STORE_CITY_ID&destination=$city_id&weight=$weight&courier=$courier",
    CURLOPT_HTTPHEADER => [
        "content-type: application/x-www-form-urlencoded",
        "key: $RAJAONGKIR_API_KEY"
    ],
]);
$response = curl_exec($curl);
$result = json_decode($response, true);
$costs = $result['rajaongkir']['results'][0]['costs'] ?? [];
echo "<option value=''>-- Select Package --</option>";
foreach ($costs as $c) {
    $service = $c['service'];
    $cost = $c['cost'][0]['value'];
    $etd = $c['cost'][0]['etd'];
    echo "<option package='$service' shipping_cost='$cost' etd='$etd'>$service — Rp. " . number_format($cost) . " ($etd days)</option>";
}
?>