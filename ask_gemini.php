<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
// Only POST allowed
if($_SERVER['REQUEST_METHOD']!=='POST'){
  http_response_code(405);
  echo json_encode(['error'=>'Only POST is allowed']);
  exit;
}
$in = json_decode(file_get_contents('php://input'), true);
$prompt = isset($in['prompt']) ? trim($in['prompt']) : '';
if(!$prompt) {
  http_response_code(400);
  echo json_encode(['error'=>'No prompt']);
  exit;
}

// $api_key = 'AIzaSyBMZB3LCiZgrdptq-D5uZdBX_78Baqp7-k';
$api_key = 'AIzaSyA8hyc-dDM11IYTY2nGQ1Du7gtFxhJnzlI';
$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=$api_key";
$body = [
  "contents" => [ [ "parts" => [ [ "text" => $prompt ] ] ] ]
];
$payload = json_encode($body);
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
  'Content-Type: application/json',
  'Content-Length: ' . strlen($payload)
]);
$response = curl_exec($ch);
if($response===false){
  http_response_code(500);
  echo json_encode(['error'=>'cURL error: '.curl_error($ch)]);
  exit;
}
curl_close($ch);
$j = json_decode($response, true);
$result = $j['candidates'][0]['content']['parts'][0]['text'] ?? '';
echo json_encode(['result'=>$result]);
