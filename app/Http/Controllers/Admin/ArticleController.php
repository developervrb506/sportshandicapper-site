<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleSupplement;
use App\Models\Pick;
use App\Services\ClaudeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $articles = Article::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('category', 'like', "%{$search}%")
                      ->orWhere('author', 'like', "%{$search}%")
                      ->orWhere('expert_name', 'like', "%{$search}%");
                });
            })
            ->orderByRaw('published_at IS NULL')
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.articles.index', [
            'articles' => $articles,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('admin.articles.form', [
            'article' => new Article(),
            'picks'   => Pick::orderBy('game_date', 'desc')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'          => ['required', 'string', 'max:255'],
            'excerpt'        => ['nullable', 'string'],
            'content'        => ['required', 'string'],
            'category'       => ['required', 'string', 'max:50'],
            'sport'          => ['nullable', 'string', 'max:50'],
            'author'         => ['nullable', 'string', 'max:255'],
            'expert_name'    => ['nullable', 'string', 'max:255'],
            'featured_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'is_premium'     => ['boolean'],
            'is_published'   => ['boolean'],
            'published_at'   => ['nullable', 'date'],
            'related_pick_id'=> ['nullable', 'exists:picks,id'],
        ]);

        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $i = 2;
        while (Article::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $i++;
        }
        $validated['slug'] = $slug;

        $validated['is_premium'] = $request->boolean('is_premium');
        $validated['is_published'] = $request->boolean('is_published');
        if ($validated['is_published'] && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('uploads/articles', 'public');
            $validated['featured_image'] = $path;
        }

        // Auto-generate excerpt if blank
        if (empty($validated['excerpt']) && !empty($validated['content'])) {
            try {
                $validated['excerpt'] = app(ClaudeService::class)->generateExcerpt($validated['content']);
            } catch (\Exception) {
                // Silently skip if API fails — excerpt stays empty
            }
        }

        $relatedPickId = $validated['related_pick_id'] ?? null;
        unset($validated['related_pick_id']);

        $article = Article::create($validated);

        // Link the selected pick to this article
        if ($relatedPickId) {
            // Unlink any other pick already pointing to this article (safety)
            Pick::where('related_article_id', $article->id)->update(['related_article_id' => null]);
            Pick::where('id', $relatedPickId)->update(['related_article_id' => $article->id]);
        }

        return redirect()->route('admin.articles.index')->with('success', 'Article created successfully.');
    }

    public function edit(Article $article): View
    {
        $article->load('supplements');
        return view('admin.articles.form', [
            'article' => $article,
            'picks'   => Pick::orderBy('game_date', 'desc')->get(),
        ]);
    }

    public function update(Request $request, Article $article): RedirectResponse
    {
        $validated = $request->validate([
            'title'          => ['required', 'string', 'max:255'],
            'excerpt'        => ['nullable', 'string'],
            'content'        => ['required', 'string'],
            'category'       => ['required', 'string', 'max:50'],
            'sport'          => ['nullable', 'string', 'max:50'],
            'author'         => ['nullable', 'string', 'max:255'],
            'expert_name'    => ['nullable', 'string', 'max:255'],
            'featured_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'is_premium'     => ['boolean'],
            'is_published'   => ['boolean'],
            'published_at'   => ['nullable', 'date'],
            'related_pick_id'=> ['nullable', 'exists:picks,id'],
        ]);

        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $i = 2;
        while (Article::where('slug', $slug)->where('id', '!=', $article->id)->exists()) {
            $slug = $baseSlug . '-' . $i++;
        }
        $validated['slug'] = $slug;

        $validated['is_premium'] = $request->boolean('is_premium');
        $validated['is_published'] = $request->boolean('is_published');
        if ($validated['is_published'] && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        if ($request->hasFile('featured_image')) {
            if ($article->featured_image) {
                Storage::disk('public')->delete($article->featured_image);
            }
            $path = $request->file('featured_image')->store('uploads/articles', 'public');
            $validated['featured_image'] = $path;
        }

        // Auto-generate excerpt if blank
        if (empty($validated['excerpt']) && !empty($validated['content'])) {
            try {
                $validated['excerpt'] = app(ClaudeService::class)->generateExcerpt($validated['content']);
            } catch (\Exception) {
                // Silently skip if API fails
            }
        }

        $relatedPickId = $validated['related_pick_id'] ?? null;
        unset($validated['related_pick_id']);

        $article->update($validated);

        // Unlink all picks currently pointing to this article, then re-link the chosen one
        Pick::where('related_article_id', $article->id)->update(['related_article_id' => null]);
        if ($relatedPickId) {
            Pick::where('id', $relatedPickId)->update(['related_article_id' => $article->id]);
        }

        return redirect()->route('admin.articles.index')->with('success', 'Article updated successfully.');
    }

    public function destroy(Article $article): RedirectResponse
    {
        $article->delete();
        return redirect()->route('admin.articles.index')->with('success', 'Article deleted successfully.');
    }

    public function parsePdf(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate(['pdf' => ['required', 'file', 'mimes:pdf', 'max:10240']]);

        try {
            $parser = new \Smalot\PdfParser\Parser();
            $pdf    = $parser->parseFile($request->file('pdf')->getRealPath());
            $text   = $pdf->getText();

            // Convert plain text to basic HTML paragraphs
            $lines = preg_split('/\n{2,}/', trim($text));
            $html  = '';
            foreach ($lines as $line) {
                $line = trim($line);
                if ($line === '') continue;
                // Single-line that looks like a heading (short, no period at end)
                if (strlen($line) < 80 && !str_ends_with($line, '.')) {
                    $html .= '<h2>' . htmlspecialchars($line) . '</h2>' . "\n";
                } else {
                    $html .= '<p>' . nl2br(htmlspecialchars($line)) . '</p>' . "\n";
                }
            }

            return response()->json(['html' => $html ?: '<p>' . htmlspecialchars($text) . '</p>']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Could not parse PDF: ' . $e->getMessage()], 422);
        }
    }

    public function addSupplement(Request $request, Article $article): RedirectResponse
    {
        $validated = $request->validate([
            'type'         => 'required|in:video,debate,infographic,flashcard,audio,other',
            'title'        => 'nullable|string|max:255',
            'embed_code'   => 'nullable|string',
            'external_url' => 'nullable|url|max:500',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'sort_order'   => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('uploads/supplements', 'public');
        }
        unset($validated['image']);

        $article->supplements()->create($validated);

        return back()->with('success', 'Content added successfully.');
    }

    public function deleteSupplement(Article $article, ArticleSupplement $supplement): RedirectResponse
    {
        if ($supplement->image_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($supplement->image_path);
        }
        $supplement->delete();
        return back()->with('success', 'Content removed.');
    }

    public function generateSidebar(Request $request, Article $article)
    {
        $apiKey = config('services.anthropic.api_key') ?? env('ANTHROPIC_API_KEY');
        if (!$apiKey) {
            return response()->json(['error' => 'Claude API key not configured.'], 422);
        }

        $content = strip_tags($article->content ?? '');
        if (strlen($content) < 100) {
            return response()->json(['error' => 'Article content is too short to analyze.'], 422);
        }

        $prompt = "You are a professional sports betting analyst. Read this article and return ONLY valid JSON (no markdown, no extra text, no code blocks) in this exact format:
{
  \"insights\": [\"insight 1\", \"insight 2\", \"insight 3\", \"insight 4\", \"insight 5\"],
  \"debate\": {\"sharp\": \"one sentence about sharp money angle\", \"public\": \"one sentence about public betting angle\"},
  \"stats\": [\"key stat 1\", \"key stat 2\", \"key stat 3\"],
  \"executive_summary\": \"One clear paragraph summarizing the key betting angle and recommendation from this article.\",
  \"tweet\": \"One punchy tweet-length summary under 240 characters. No hashtags.\",
  \"flashcards\": [
    {\"q\": \"question about a key fact in the article\", \"a\": \"concise answer\"},
    {\"q\": \"question\", \"a\": \"answer\"}
  ]
}

Rules:
- insights: exactly 5 bullet points
- flashcards: between 8 and 12 Q&A pairs covering key facts, stats, matchup details, and betting angles
- executive_summary: 2-3 sentences max
- tweet: punchy, no hashtags, under 240 chars
- Return ONLY the JSON object, nothing else

Article:
" . substr($content, 0, 4000);

        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'x-api-key'         => $apiKey,
            'anthropic-version' => '2023-06-01',
            'content-type'      => 'application/json',
        ])->post('https://api.anthropic.com/v1/messages', [
            'model'      => 'claude-haiku-4-5-20251001',
            'max_tokens' => 1800,
            'messages'   => [['role' => 'user', 'content' => $prompt]],
        ]);

        if (!$response->successful()) {
            return response()->json(['error' => 'Claude API error: ' . $response->body()], 422);
        }

        $text = $response->json('content.0.text') ?? '';

        // Strip markdown code fences if Claude wrapped the JSON
        $text = preg_replace('/^```(?:json)?\s*/i', '', trim($text));
        $text = preg_replace('/\s*```$/', '', $text);

        // Extract the JSON object if there's surrounding text
        if (preg_match('/\{[\s\S]*\}/s', $text, $matches)) {
            $text = $matches[0];
        }

        $data = json_decode(trim($text), true);
        if (!$data) {
            return response()->json(['error' => 'Could not parse Claude response. Raw: ' . substr($text, 0, 200)], 422);
        }

        // Remove old AI-generated supplements
        $article->supplements()->where('type', 'ai_generated')->delete();

        // Save Claude analysis — sort_order 1 so audio (order 0) appears above it
        $article->supplements()->create([
            'type'       => 'ai_generated',
            'title'      => 'AI Analysis',
            'ai_content' => json_encode($data),
            'sort_order' => 1,
        ]);

        // ── Phase 2: Generate Audio with OpenAI TTS ──────────────────
        $openAiKey = env('OPENAI_API_KEY');
        $audioPath = null;

        if ($openAiKey) {
            try {
                // Build a clean narration script from executive summary + insights
                $script = $article->title . ". \n\n";
                if (!empty($data['executive_summary'])) {
                    $script .= $data['executive_summary'] . "\n\n";
                }
                if (!empty($data['insights'])) {
                    $script .= "Key insights: ";
                    $script .= implode('. ', $data['insights']) . '.';
                }
                // Fallback to article text if no AI data
                if (strlen($script) < 100) {
                    $script = substr(strip_tags($article->content ?? ''), 0, 4096);
                }
                $script = substr($script, 0, 4096);

                $audioResponse = \Illuminate\Support\Facades\Http::withHeaders([
                    'Authorization' => 'Bearer ' . $openAiKey,
                    'Content-Type'  => 'application/json',
                ])->post('https://api.openai.com/v1/audio/speech', [
                    'model'          => 'tts-1',
                    'input'          => $script,
                    'voice'          => 'onyx',
                    'response_format'=> 'mp3',
                ]);

                if ($audioResponse->successful()) {
                    $filename  = 'uploads/audio/article-' . $article->id . '-' . time() . '.mp3';
                    \Illuminate\Support\Facades\Storage::disk('public')->put($filename, $audioResponse->body());
                    $audioPath = $filename;

                    // Remove old audio supplement and save new one
                    $article->supplements()->where('type', 'audio')->where('image_path', 'like', 'uploads/audio/%')->delete();
                    $article->supplements()->create([
                        'type'       => 'audio',
                        'title'      => 'Listen to This Analysis',
                        'image_path' => $audioPath,
                        'sort_order' => 0, // Audio first in sidebar
                    ]);
                }
            } catch (\Exception $e) {
                // Audio failed silently — Claude content still saved
            }
        }

        return response()->json([
            'success'    => true,
            'data'       => $data,
            'audio_path' => $audioPath ? \Illuminate\Support\Facades\Storage::url($audioPath) : null,
        ]);
    }
}
