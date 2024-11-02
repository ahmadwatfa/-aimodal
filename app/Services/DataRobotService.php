<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DataRobotService
{
    protected $apiKey;
    protected $apiUrl;

    public function __construct()
    {
        $this->apiKey = config('services.datarobot.api_key');
        $this->apiUrl = config('services.datarobot.api_url');
    }

    public function getDataRobotAnalysis($query, $openAIResults)
    {
         
        $url = "https://app.datarobot.com/projects/670aac08f4e6731ce091f922/eda/home";

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post($url, [
            'query' => $query,
            'market_potential' => $openAIResults['market_potential']
        ]);
        
        if ($response->successful()) {
            $dataRobotResults = $response->json();
            dd($dataRobotResults); // عرض النتائج للتحقق منها
        } else {
            dd($response->status(), $response->body()); // التحقق من الأخطاء
        }
        
    }
}
