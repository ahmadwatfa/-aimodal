<?php

namespace App\Services;

use App\Models\Serpapi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class SerpApiService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.serpapi.api_key');
    }


    public function searchGoogleTrends($idea, $location, $keywords)
    {

        $response = Http::get('https://serpapi.com/search.json', [
            'engine' => 'google_trends',
            'q' => $idea,
            'location' => $location,
            'keywords' => $keywords,
            'api_key' => $this->apiKey,
        ]);

        return $response->successful() ? $response->json() : null;
    }

    public function storeInterestData(array $timelineData, string $idea, $project_id, $userId): void
    {

        foreach ($timelineData as $dataPoint) {
            Serpapi::create([
                'query' => $idea,
                'user_id' => $userId,
                'project_id' => $project_id,
                'date' => $dataPoint['date'],
                'timestamp' => $dataPoint['timestamp'],
                'value' => $dataPoint['values'][0]['value'] ?? 0,
                'extracted_value' => $dataPoint['values'][0]['extracted_value'] ?? 0,
                'partial_data' => isset($dataPoint['partial_data']) ? $dataPoint['partial_data'] : false,
            ]);
        }
    }

    /**
     * جلب بيانات interest_over_time بناءً على فكرة معينة
     *
     * @param string $idea
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getInterestData($project_id)
    {
        return Serpapi::where('project_id', $project_id)->get();
    }
}
