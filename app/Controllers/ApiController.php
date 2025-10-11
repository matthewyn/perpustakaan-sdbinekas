<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class ApiController extends Controller
{
    public function analyzeImage()
    {
        $imageUrl = $this->request->getGet('image_url');
        if (!$imageUrl) {
            return $this->response->setJSON(['error' => "Parameter 'image_url' is required"])->setStatusCode(400);
        }

        $openaiApiKey = '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';
        $visionModel = "gpt-4.1";
        $searchModel = "gpt-4o-search-preview";

        // Step 1: Analyze image
        $visionPayload = [
            "model" => $visionModel,
            "messages" => [
                [
                    "role" => "user",
                    "content" => [
                        ["type" => "text", "text" => "What's in this image?"],
                        ["type" => "image_url", "image_url" => ["url" => $imageUrl]],
                    ],
                ]
            ]
        ];

        $visionResponse = $this->openaiRequest($visionPayload, $openaiApiKey);
        $description = $visionResponse['choices'][0]['message']['content'] ?? '';

        // Step 2: Get book info as JSON
        $searchPayload = [
            "model" => $searchModel,
            "messages" => [
                [
                    "role" => "user",
                    "content" =>
                        "Find everything from {$description} and return ONLY valid JSON with this exact structure (no explanation, no markdown):\n" .
                        "{\n" .
                        '  "code": "",' . "\n" .
                        '  "isbn": FIND ISBN IF NOT FOUND SAY NOT FOUND"",' . "\n" .
                        '  "ddcNumber": ANALYZE THE BOOK DEWEY DECIMAL NUMBER"",' . "\n" .
                        '  "title": "",' . "\n" .
                        '  "author": "",' . "\n" .
                        '  "illustrator": "",' . "\n" .
                        '  "publisher": "",' . "\n" .
                        '  "series": "",' . "\n" .
                        '  "category": "",' . "\n" .
                        '  "notes": "",' . "\n" .
                        '  "image": "",' . "\n" .
                        '  "quantity": "1",' . "\n" .
                        '  "isOneDayBook": false,' . "\n" .
                        '  "available": true,' . "\n" .
                        '  "borrower": "",' . "\n" .
                        '  "dateCreated": "2025-10-06T12:08:44.132921",' . "\n" .
                        '  "dateModified": "2025-10-06T12:08:44.132948",' . "\n" .
                        '  "createdBy": "",' . "\n" .
                        '  "modifiedBy": ""' . "\n" .
                        "}"
                ]
            ]
        ];

        $searchResponse = $this->openaiRequest($searchPayload, $openaiApiKey);
        $rawJson = trim($searchResponse['choices'][0]['message']['content'] ?? '');

        // Return the JSON string (parsed if possible)
        $jsonData = json_decode($rawJson, true);
        if ($jsonData === null) {
            return $this->response->setJSON(['error' => 'Failed to parse JSON', 'raw' => $rawJson])->setStatusCode(500);
        }
        return $this->response->setJSON($jsonData);
    }

    // Helper function for OpenAI API requests
    private function openaiRequest($payload, $apiKey)
    {
        $ch = curl_init('https://api.openai.com/v1/chat/completions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $apiKey,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result, true);
    }
}