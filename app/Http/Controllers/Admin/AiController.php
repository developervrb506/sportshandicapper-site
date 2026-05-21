<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ClaudeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AiController extends Controller
{
    public function __construct(private ClaudeService $claude) {}

    public function parsePdf(Request $request): JsonResponse
    {
        $request->validate(['pdf' => ['required', 'file', 'mimes:pdf', 'max:10240']]);

        try {
            $parser  = new \Smalot\PdfParser\Parser();
            $pdf     = $parser->parseFile($request->file('pdf')->getRealPath());
            $rawText = $pdf->getText();

            if (empty(trim($rawText))) {
                return response()->json(['error' => 'Could not extract text from this PDF. It may be image-based.'], 422);
            }

            $html = $this->claude->formatPdfAsHtml($rawText);

            return response()->json(['html' => $html]);
        } catch (\RuntimeException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'PDF parsing failed: ' . $e->getMessage()], 422);
        }
    }

    public function generateArticle(Request $request): JsonResponse
    {
        $request->validate([
            'sport'       => ['required', 'string'],
            'teams'       => ['required', 'string'],
            'pick_type'   => ['required', 'string'],
            'expert_name' => ['nullable', 'string'],
        ]);

        try {
            $result = $this->claude->generateArticle(
                $request->input('sport'),
                $request->input('teams'),
                $request->input('pick_type'),
                $request->input('expert_name', '')
            );

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function generateExcerpt(Request $request): JsonResponse
    {
        $request->validate(['content' => ['required', 'string']]);

        try {
            $excerpt = $this->claude->generateExcerpt($request->input('content'));
            return response()->json(['excerpt' => $excerpt]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function checkPick(Request $request): JsonResponse
    {
        $request->validate([
            'sport'     => ['required', 'string'],
            'team1'     => ['required', 'string'],
            'team2'     => ['required', 'string'],
            'pick'      => ['required', 'string'],
            'game_date' => ['nullable', 'string'],
        ]);

        try {
            $result = $this->claude->checkPickQuality(
                $request->input('sport'),
                $request->input('team1'),
                $request->input('team2'),
                $request->input('pick'),
                $request->input('game_date', '')
            );

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
