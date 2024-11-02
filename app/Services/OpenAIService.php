<?php

namespace App\Services;

use App\Models\ReportSection;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class OpenAIService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.openai.api_key');
    }

    public function generateText($sections)
    {
        $responses = [];
        $client = new Client();
        foreach ($sections as $section) {
            $prompt = $section['content'];

            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ])->timeout(60000)->post("https://api.openai.com/v1/chat/completions", [
                    'model' => 'gpt-4o',
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => $prompt,
                        ]
                    ],
                    "temperature" => 0.5,
                    "max_tokens" => 16384,
                    "top_p" => 1.0,
                    "frequency_penalty" => 0.52,
                    "presence_penalty" => 0.5,

                ]);

                $responseBody = json_decode($response->getBody(), true);
                $generatedText = $responseBody['choices'][0]['message']['content'];

                ReportSection::where('project_id', $section['project_id'])
                    ->where('section_name', $section['section_name'])
                    ->update([
                        'completed' => true,
                        'response_openai' => $generatedText,
                    ]);
            } catch (\Exception $e) {

                $responses[] = [
                    'section_name' => $section['section_name'],
                    'error' => $e->getMessage(),
                ];
            }
        }
    }
}
