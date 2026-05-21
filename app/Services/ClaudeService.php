<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ClaudeService
{
    private string $apiKey;
    private string $model = 'claude-sonnet-4-6';
    private string $baseUrl = 'https://api.anthropic.com/v1/messages';

    public function __construct()
    {
        $this->apiKey = config('services.anthropic.key');
    }

    private function call(string $prompt, int $maxTokens = 2048): string
    {
        $response = Http::withHeaders([
            'x-api-key'         => $this->apiKey,
            'anthropic-version' => '2023-06-01',
            'content-type'      => 'application/json',
        ])->timeout(60)->post($this->baseUrl, [
            'model'      => $this->model,
            'max_tokens' => $maxTokens,
            'messages'   => [
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        if ($response->failed()) {
            throw new \RuntimeException('Claude API error: ' . $response->body());
        }

        return $response->json('content.0.text', '');
    }

    public function formatPdfAsHtml(string $rawText): string
    {
        $prompt = <<<PROMPT
You are a sports betting content formatter. I will give you raw text extracted from a PDF article.
Your job is to reformat it as clean HTML suitable for a rich text editor (CKEditor).

Rules:
- Use <h2> for section headings, <h3> for sub-headings
- Use <p> for paragraphs
- Reconstruct any tables using proper <table><thead><tbody><tr><th><td> tags with inline style="border-collapse:collapse;width:100%" on the table and style="border:1px solid #e2e8f0;padding:8px;" on th/td
- Use <ul><li> for bullet lists, <ol><li> for numbered lists
- Use <strong> for bold text where appropriate
- Remove page numbers, headers/footers, and metadata artifacts
- Output ONLY the HTML — no markdown, no explanation, no code fences

Raw PDF text:
{$rawText}
PROMPT;

        return $this->call($prompt, 4096);
    }

    public function generateArticle(string $sport, string $teams, string $pickType, ?string $expertName = ''): array
    {
        $byline = ($expertName ?? '') ? "Written by expert handicapper {$expertName}." : '';
        $prompt = <<<PROMPT
You are a professional sports betting analyst writing for INSPIN.com, a premium sports betting analysis platform.

Write a complete, detailed betting analysis article for the following matchup:
- Sport: {$sport}
- Teams/Matchup: {$teams}
- Pick/Bet Type: {$pickType}
{$byline}

Return a JSON object with exactly these three fields:
1. "title" — a compelling article title (max 80 characters)
2. "excerpt" — a 1-2 sentence teaser summary for the article card (max 160 characters)
3. "content" — the full article as HTML using <h2>, <h3>, <p>, <ul>, <li>, <strong>, <table> tags. Should be 400-700 words covering: matchup overview, key stats & trends, injury report notes, betting analysis, and the recommendation. Make it professional and data-driven.

Output ONLY valid JSON — no markdown, no code fences, nothing else.
PROMPT;

        $raw = $this->call($prompt, 3000);

        // Strip any accidental markdown fences
        $raw = preg_replace('/^```json\s*/i', '', trim($raw));
        $raw = preg_replace('/```$/', '', trim($raw));

        $decoded = json_decode(trim($raw), true);

        if (!$decoded || !isset($decoded['title'], $decoded['content'])) {
            throw new \RuntimeException('Claude returned invalid JSON for article generation.');
        }

        return $decoded;
    }

    public function generateExcerpt(string $content): string
    {
        // Strip HTML for the prompt
        $text = strip_tags($content);
        $text = substr($text, 0, 2000); // limit input size

        $prompt = <<<PROMPT
You are a sports betting content editor. Write a 1-2 sentence excerpt/teaser for the following article.
It should entice readers to click and read the full article.
Keep it under 160 characters. Output ONLY the excerpt text — no quotes, no explanation.

Article content:
{$text}
PROMPT;

        return trim($this->call($prompt, 200));
    }

    public function checkPickQuality(string $sport, string $team1, string $team2, string $pick, string $gameDate = ''): array
    {
        $prompt = <<<PROMPT
You are a professional sports betting editor reviewing a pick before publication on a premium betting site.

Review this pick for quality and completeness:
- Sport: {$sport}
- Teams: {$team1} vs {$team2}
- Game Date: {$gameDate}
- Pick Text: {$pick}

Check for these issues:
1. Are the odds/line included? (e.g. -110, +150, -3.5)
2. Are team names clear and correct?
3. Is the bet type clear? (spread, moneyline, over/under, etc.)
4. Is anything missing or unclear?

Return a JSON object with:
- "passed" — true if the pick looks complete and professional, false if there are issues
- "score" — quality score from 1-10
- "issues" — array of specific problems found (empty array if none)
- "suggestions" — array of specific improvement suggestions (empty array if none)
- "summary" — one sentence overall assessment

Output ONLY valid JSON — no markdown, no code fences.
PROMPT;

        $raw = $this->call($prompt, 600);
        $raw = preg_replace('/^```json\s*/i', '', trim($raw));
        $raw = preg_replace('/```$/', '', trim($raw));

        $decoded = json_decode(trim($raw), true);

        if (!$decoded) {
            throw new \RuntimeException('Claude returned invalid response for pick check.');
        }

        return $decoded;
    }
}
