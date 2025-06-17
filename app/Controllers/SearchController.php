<?php

namespace App\Controllers;

use App\Models\KeywordModel;
use App\Models\KeywordDetailModel;
use App\Models\HistoryKeywordModel;

class SearchController extends BaseController
{
    protected $keywordModel;
    protected $keywordDetailModel;
    protected $historyKeywordModel;

    // Replace these with your actual Google API key and Search Engine ID (cx)
    private $googleApiKey = 'AIzaSyDWsaUaRfvkA_oMD1ZJACi0G-OzcUY4MKQ';
    private $googleSearchEngineId = '54ed9cb78443c4a54';

    public function __construct()
    {
        $this->keywordModel = new KeywordModel();
        $this->keywordDetailModel = new KeywordDetailModel();
        $this->historyKeywordModel = new HistoryKeywordModel();
    }

    public function index()
    {
        helper(['form']);
        $data = [];

        if ($this->request->getMethod() === 'POST') {
            $keyword = trim($this->request->getPost('keyword'));
            $perPage = 10;
            $page = (int) $this->request->getPost('page') ?: 1;

            // Save keyword to history keyword table
            $this->historyKeywordModel->insert(['keyword' => $keyword]);

            // Search for keyword in keyword table
            $keywordData = $this->keywordModel->where('keyword', $keyword)->first();

            if ($keywordData) {
                // Keyword found, get keyword details ordered by position ascending
                $keywordDetails = $this->keywordDetailModel
                    ->where('keyword_id', $keywordData['id'])
                    ->orderBy('position', 'ASC')
                    ->findAll();

                $data['results'] = $keywordDetails;
                $data['source'] = 'database';
                $data['pagination'] = [
                    'current_page' => $page,
                    'total_pages' => 1, // Pagination for keyword details not implemented
                ];
                $data['keyword'] = $keyword;
            } else {
                // Keyword not found, perform Google search via API
                $data['results'] = $this->googleSearch($keyword);
                $data['source'] = 'google';
                $data['keyword'] = $keyword;
            }
        }

        echo view('search', $data);
    }

    protected function googleSearch(string $keyword)
    {
        $apiKey = $this->googleApiKey;
        $searchEngineId = $this->googleSearchEngineId;

        // Add 'gl=ID' parameter to bias search results to Indonesia
        $url = "https://www.googleapis.com/customsearch/v1?key={$apiKey}&cx={$searchEngineId}&q=" . urlencode($keyword) . "&gl=ID&lr=lang_id";

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
            ],
        ]);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            curl_close($curl);
            return ['error' => 'Curl error: ' . curl_error($curl)];
        }

        curl_close($curl);

        $results = [];

        $data = json_decode($response, true);


        if (isset($data['items'])) {
            foreach ($data['items'] as $item) {
                $imageSrc = isset($item['pagemap']['cse_image'][0]['src']) ? $item['pagemap']['cse_image'][0]['src'] : null;

                // Mengambil deskripsi dari og:description atau twitter:description, jika kosong ambil dari snippet
                $description = null;
                if (!empty($item['pagemap']['metatags'][0]['og:description'])) {
                    $description = $item['pagemap']['metatags'][0]['og:description'];
                } elseif (!empty($item['pagemap']['metatags'][0]['twitter:description'])) {
                    $description = $item['pagemap']['metatags'][0]['twitter:description'];
                } else {
                    $description = $item['snippet'];
                }

                $results[] = [
                    'title' => $item['title'],
                    'link' => $item['link'],
                    'description' => $description,
                    'image' => $imageSrc
                ];
            }
        } else {
            $results[] = ['title' => 'No results found or API error', 'link' => '#'];
        }


        return $results;
    }
}
