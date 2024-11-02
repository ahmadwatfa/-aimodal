<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class KeywordToolService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('KEYWORD_TOOL_API_KEY'); // جلب مفتاح API من ملف .env
    }

    public function getKeywordData($query)
    {
        // إعداد URL للطلب
        $url = 'https://api.keywordtool.io/v2/search/';

        $params = [
            'apikey' => $this->apiKey,
            'keyword' => $query,
            'metrics' => 'true', // تأكد من إضافة المعلمات الضرورية
        ];

        $response = Http::get($url, $params);


        // معالجة الاستجابة
        // if ($response->successful()) {
        //     return $response->json(); // إرجاع البيانات كـ JSON
        // } else {
        //     return null; // أو يمكنك تسجيل الأخطاء
        // }
    }
}
