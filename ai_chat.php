<?php
// ai_chat.php
header('Content-Type: application/json; charset=utf-8');

// دریافت پیام کاربر
$input = json_decode(file_get_contents('php://input'), true);
$userMessage = $input['message'] ?? '';

if (empty($userMessage)) {
    echo json_encode(['error' => 'پیام نمی‌تواند خالی باشد']);
    exit;
}

// آدرس API Kilo Gateway (سازگار با OpenAI)
$url = 'https://api.kilo.ai/api/openrouter/chat/completions';

// ساخت درخواست
$data = [
    // استفاده از یک مدل رایگان، شناسه مدل ممکن است به‌روزرسانی شود
    // می‌توانید مدل‌های رایگان موجود را در https://kilo.ai/docs/gateway/models-and-providers مشاهده کنید
    'model' => 'minimax/minimax-m2.1:free',
    'messages' => [
        [
            'role' => 'system',
            'content' => 'شما یک دستیار هوشمند برای وب‌سایت "موسسه هنری سیمورگ" هستید. لطفاً به سوالات کاربران به زبان فارسی پاسخ دهید و در صورت امکان آن‌ها را به صفحات مرتبط با دوره‌ها، بسته‌های آموزشی، رادیو و غیره راهنمایی کنید.'
        ],
        [
            'role' => 'user',
            'content' => $userMessage
        ]
    ],
    'max_tokens' => 500,
    'temperature' => 0.7
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    // کلید دسترسی ناشناس Kilo
    'Authorization: Bearer anonymous',
    'X-KILOCODE-EDITORNAME: simorgh-chat'
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode !== 200) {
    // ثبت خطا برای عیب‌یابی
    error_log("Kilo API Error: HTTP $httpCode - $response");
    echo json_encode(['reply' => 'متأسفم، در حال حاضر نمی‌توانم به درخواست شما پاسخ دهم. لطفاً بعداً دوباره تلاش کنید.']);
    exit;
}

$result = json_decode($response, true);
$reply = $result['choices'][0]['message']['content'] ?? 'پاسخی دریافت نشد.';

echo json_encode(['reply' => $reply]);