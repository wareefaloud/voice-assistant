<?php
// ============================================================
// api/chat.php — يستقبل النص من app.js ويستدعي Gemini API بأمان
// ============================================================

header('Content-Type: application/json; charset=utf-8');

require __DIR__ . '/../config.php';

// اسمح فقط بطلبات POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'الطريقة غير مسموحة']);
    exit;
}

// قراءة البيانات القادمة من JavaScript
$input = json_decode(file_get_contents('php://input'), true);
$prompt = isset($input['prompt']) ? trim($input['prompt']) : '';

if ($prompt === '') {
    http_response_code(400);
    echo json_encode(['error' => 'الرجاء إرسال نص صالح في الحقل prompt']);
    exit;
}

// التأكد من وجود المفتاح
if (!defined('GEMINI_API_KEY') || trim(GEMINI_API_KEY) === '') {
    http_response_code(500);
    echo json_encode(['error' => 'لم يتم ضبط مفتاح Gemini في config.php']);
    exit;
}

// موديل Gemini
$model = 'gemini-flash-latest';

// رابط API
$url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent";

// البيانات المرسلة
$body = json_encode([
    "contents" => [
        [
            "parts" => [
                [
                    "text" => $prompt
                ]
            ]
        ]
    ]
], JSON_UNESCAPED_UNICODE);

// إنشاء اتصال cURL
$ch = curl_init($url);

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'X-goog-api-key: ' . GEMINI_API_KEY
    ],
    CURLOPT_POSTFIELDS => $body,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_SSL_VERIFYPEER => true,
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlErr = curl_error($ch);

curl_close($ch);

// إذا فشل الاتصال
if ($response === false) {
    http_response_code(500);
    echo json_encode([
        'error' => 'cURL Error',
        'details' => $curlErr
    ]);
    exit;
}

// تحويل الرد إلى Array
$data = json_decode($response, true);

// إذا رفضت Gemini الطلب
if ($httpCode >= 400) {
    http_response_code($httpCode);
    echo json_encode([
        'error' => 'Gemini API Error',
        'details' => $data
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// استخراج الرد
$reply = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

if (!$reply) {
    http_response_code(500);
    echo json_encode([
        'error' => 'لم يتم العثور على رد من Gemini',
        'details' => $data
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// إرسال الرد للواجهة
echo json_encode([
    'reply' => $reply
], JSON_UNESCAPED_UNICODE);