<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $provider = config('services.ai.provider', 'huggingface');
        $systemPrompt = "Bạn là trợ lý tư vấn mua sắm cho website FashionTee. " .
            "Trả lời ngắn gọn, thân thiện, ưu tiên tiếng Việt và bám theo nhu cầu khách hàng.";

        if ($provider === 'openai') {
            return $this->chatWithOpenAI($validated['message'], $systemPrompt);
        }

        if ($provider === 'gemini') {
            return $this->chatWithGemini($validated['message'], $systemPrompt);
        }

        return $this->chatWithHuggingFace($validated['message'], $systemPrompt);
    }

    private function chatWithOpenAI(string $message, string $systemPrompt)
    {
        $apiKey = config('services.openai.api_key');
        $model = config('services.openai.model', 'gpt-4o-mini');

        if (empty($apiKey)) {
            return response()->json([
                'status' => false,
                'message' => 'OPENAI_API_KEY chưa được cấu hình',
            ], 500);
        }

        try {
            $response = Http::withToken($apiKey)
                ->timeout(30)
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => $model,
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $message],
                    ],
                    'temperature' => 0.7,
                    'max_tokens' => 400,
                ]);

            if (!$response->successful()) {
                $errorCode = data_get($response->json(), 'error.code');
                $errorType = data_get($response->json(), 'error.type');

                Log::warning('OpenAI chat failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                if ($response->status() === 429 && ($errorCode === 'insufficient_quota' || $errorType === 'insufficient_quota')) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Tài khoản OpenAI đã hết quota. Vui lòng nạp billing hoặc đổi API key khác.',
                    ], 429);
                }

                if ($response->status() === 401) {
                    return response()->json([
                        'status' => false,
                        'message' => 'OPENAI_API_KEY không hợp lệ hoặc đã bị thu hồi.',
                    ], 401);
                }

                return response()->json([
                    'status' => false,
                    'message' => 'Không thể kết nối OpenAI, vui lòng thử lại sau',
                ], 502);
            }

            $assistantMessage = data_get($response->json(), 'choices.0.message.content');
            if (!$assistantMessage) {
                return response()->json([
                    'status' => false,
                    'message' => 'AI không trả về nội dung hợp lệ',
                ], 502);
            }

            return response()->json([
                'status' => true,
                'reply' => trim($assistantMessage),
            ]);
        } catch (\Throwable $e) {
            Log::error('OpenAI chat exception', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'status' => false,
                'message' => 'OpenAI đang bận, vui lòng thử lại',
            ], 500);
        }
    }

    private function chatWithGemini(string $message, string $systemPrompt)
    {
        $apiKey = config('services.gemini.api_key');

        if (empty($apiKey)) {
            return response()->json([
                'status' => false,
                'message' => 'GEMINI_API_KEY chưa được cấu hình',
            ], 500);
        }

        try {
            $response = Http::timeout(30)
                ->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=' . $apiKey, [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $systemPrompt . "\n\nNgười dùng: " . $message]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature' => 0.7,
                        'maxOutputTokens' => 400,
                    ],
                ]);

            if (!$response->successful()) {
                Log::warning('Gemini chat failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return response()->json([
                    'status' => false,
                    'message' => 'Không thể kết nối Gemini, vui lòng thử lại sau',
                ], 502);
            }

            $candidates = data_get($response->json(), 'candidates');
            if (!$candidates || !is_array($candidates) || empty($candidates)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Gemini không trả về nội dung hợp lệ',
                ], 502);
            }

            $text = data_get($candidates, '0.content.parts.0.text');
            if (!$text) {
                return response()->json([
                    'status' => false,
                    'message' => 'Gemini không trả về nội dung hợp lệ',
                ], 502);
            }

            return response()->json([
                'status' => true,
                'reply' => trim($text),
            ]);
        } catch (\Throwable $e) {
            Log::error('Gemini chat exception', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Gemini đang bận, vui lòng thử lại',
            ], 500);
        }
    }

    private function chatWithHuggingFace(string $message, string $systemPrompt)
    {
        $apiKey = config('services.huggingface.api_key');
        $model = config('services.huggingface.model', 'google/flan-t5-large');

        $prompt = $systemPrompt . "\n\nNgười dùng: " . $message . "\nTrợ lý:";

        try {
            $request = Http::timeout(45);
            if (!empty($apiKey)) {
                $request = $request->withToken($apiKey);
            }

            $response = $request->post('https://api-inference.huggingface.co/models/' . $model, [
                'inputs' => $prompt,
                'parameters' => [
                    'max_new_tokens' => 220,
                    'temperature' => 0.7,
                    'return_full_text' => false,
                ],
                'options' => [
                    'wait_for_model' => true,
                ],
            ]);

            if (!$response->successful()) {
                Log::warning('HuggingFace chat failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                // Fallback free provider không cần key để tránh gián đoạn chat.
                return $this->chatWithPollinations($message, $systemPrompt);
            }

            $generated = data_get($response->json(), '0.generated_text');
            if (!$generated || !is_string($generated)) {
                return response()->json([
                    'status' => false,
                    'message' => 'AI free chưa trả về nội dung hợp lệ, vui lòng thử lại.',
                ], 502);
            }

            return response()->json([
                'status' => true,
                'reply' => trim($generated),
            ]);
        } catch (\Throwable $e) {
            Log::error('HuggingFace chat exception', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'status' => false,
                'message' => 'AI free đang bận, vui lòng thử lại sau ít phút.',
            ], 500);
        }
    }

    private function chatWithPollinations(string $message, string $systemPrompt)
    {
        $prompt = $systemPrompt . "\n\nNgười dùng: " . $message . "\nTrợ lý:";

        try {
            $response = Http::timeout(45)
                ->get('https://text.pollinations.ai/' . rawurlencode($prompt));

            if (!$response->successful()) {
                Log::warning('Pollinations chat failed', [
                    'status' => $response->status(),
                    'body' => substr($response->body(), 0, 500),
                ]);

                return response()->json([
                    'status' => false,
                    'message' => 'Không thể kết nối AI free lúc này. Bạn có thể thêm HUGGINGFACE_API_KEY để ổn định hơn.',
                ], 502);
            }

            $text = trim((string) $response->body());
            if ($text === '') {
                return response()->json([
                    'status' => false,
                    'message' => 'AI free chưa trả về nội dung hợp lệ, vui lòng thử lại.',
                ], 502);
            }

            return response()->json([
                'status' => true,
                'reply' => $text,
            ]);
        } catch (\Throwable $e) {
            Log::error('Pollinations chat exception', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'status' => false,
                'message' => 'AI free đang bận, vui lòng thử lại sau.',
            ], 500);
        }
    }
}
