<?php

namespace App\Services;

use App\Models\Google;
use Illuminate\Support\Facades\Http;

class GoogleSearchService
{
    protected $apiKey;
    protected $searchEngineId;

    public function __construct()
    {
        $this->apiKey = config('services.google.api_key');
        $this->searchEngineId = config('services.google.search_engine_id');
    }

    public function search($query, $location, $user_id, $project_id, $Keywords)
    {
        $fullQuery = $query . ' ' . $Keywords;

        $response = Http::get('https://www.googleapis.com/customsearch/v1', [
            'key' => $this->apiKey,
            'cx' => $this->searchEngineId,
            'q' => $fullQuery,
            'gl' => $location,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $this->storeSearchResults($data['items'] ?? [], $user_id, $project_id);
            return $data;
        }

        return null;
    }
    protected function storeSearchResults($items, $user_id, $project_id)
    {

        foreach ($items as $item) {
            Google::create([
                'title' => $item['title'],
                'user_id' => $user_id,
                'project_id' => $project_id,
                'link' => $item['link'],
                'display_link' => $item['displayLink'] ?? null,
                'snippet' => $item['snippet'] ?? null,
                'formatted_url' => $item['formattedUrl'] ?? null,
            ]);
        }
    }
}
