<?php

namespace App\Controllers;

use App\Models\Trans_Message;
use App\Libraries\service\EmbbedingService\NomicEmbbeddingService;
use App\Libraries\service\VectorSearchService;

class APIController extends BaseController
{
    protected $msg;
    protected $embeddingService;
    protected $vectorSearchService;
    protected $client;
    protected $api;

    public function __construct()
    {
        $this->db = db_connect();
        $this->msg = new Trans_Message();
        $this->embeddingService = new NomicEmbbeddingService();
        $this->vectorSearchService = new VectorSearchService();
        $this->client = \Config\Services::curlrequest();
        $this->api = '59c44f469858408bae7b960f8e5d4d2f.oDSYdgc5PVDVzsLDWvxrNtRR';
    }

    public function index($convId = null)
    {
        if (!getSession('isLoggedIn')) {
            return view('login');
        }

        $userid = getSession('userid');

        $data['title'] = 'Playground / Chats';
        $data['content'] = 'chat/playground';
        $data['user'] = getSession('username');
        $data['current'] = 'playground';

        $conversation_id = null;
        if ($convId) {
            $conv = $this->msg->find($convId);
            if ($conv && intval($conv['owner_user_id']) === intval($userid)) {
                $conversation_id = $convId;
                session()->set('conversation_id', $conversation_id);
            }
        }

        if (!$conversation_id) {
            $sess = getSession('conversation_id');
            if ($sess) $conversation_id = $sess;
        }

        $data['conversation_id'] = $conversation_id ?: null;
        $data['chatHistory'] = $conversation_id ? $this->msg->getConversationDetail($conversation_id) : [];
        $data['chatHeaders'] = $this->msg->getUserConversationHeaders($userid);

        return view('layouts', $data);
    }

    public function selectModel()
    {
        try {
            $response = $this->client->get('https://ollama.com/api/tags', [
                'timeout' => 5,
                'http_errors' => false,
            ]);

            $data = json_decode($response->getBody(), true);

            return $this->response->setJSON([
                'status' => 'success',
                'models' => $data['models'] ?? []
            ]);
        } catch (\Throwable $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Tidak dapat terhubung ke Ollama',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function generate()
    {
        $prompt = trim($this->request->getPost('prompt'));
        $model = trim($this->request->getPost('model'));
        $userid = $this->request->getPost('userid');
        $selectedfileid = $this->request->getPost('selectedfileid');
        $conversation_id = $this->request->getPost('conversation_id');

        $selectedfileid = is_numeric($selectedfileid) ? (int)$selectedfileid : null;

        if (!$prompt) return $this->respondError('Prompt tidak boleh kosong.');
        if (!$userid) return $this->response->setJSON(session()->get());
        if (!$model) return $this->respondError('Silahkan pilih model terlebih dahulu.');

        if (!$conversation_id) {
            $conversation_id = $this->msg->insert([
                'owner_user_id' => $userid,
                'title' => substr($prompt, 0, 50),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            session()->set('conversation_id', $conversation_id);
        } else {
            $conv = $this->msg->find($conversation_id);
            if (!$conv || (int)$conv['owner_user_id'] !== (int)$userid) {
                return $this->respondError('Invalid conversation access');
            }
        }

        $historyMessages = $this->msg->getLastMessages($conversation_id, $userid, 10);
        $historyText = '';
        foreach (array_reverse($historyMessages) as $msg) {
            $historyText .= strtoupper($msg['role']) . ": { {$msg['content']} }\n";
        }

        /** ================= RINGKASAN ================= */
        try {
            $summaryRes = $this->client->post('https://ollama.com/api/generate', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->api,
                ],
                'json' => [
                    'model' => $model,
                    'prompt' => "Ringkas percakapan berikut menjadi 1 paragraf inti:\n\n" . $historyText,
                    'stream' => false,
                ],
                'http_errors' => false,
            ]);

            $resultLastConv = json_decode($summaryRes->getBody(), true);
        } catch (\Throwable $e) {
            return $this->respondError('Gagal menghubungi Ollama (summary)');
        }

        if (!isset($resultLastConv['response'])) {
            return $this->respondError('Model tidak mengirim respons.');
        }

        $historySummary = $resultLastConv['response'];

        /** ================= EMBEDDING ================= */
        $promptEmbed = $this->embeddingService->convertToEmbbed($prompt);
        if ($promptEmbed === null) {
            return $this->respondError('Gagal membuat embedding.');
        }

        $contextRows = $this->vectorSearchService->retrieveRelevantContexts(
            $promptEmbed,
            1,
            $selectedfileid,
            6
        );

        $contextText = '';
        if ($historySummary) {
            $contextText .= "=== Ringkasan Percakapan Sebelumnya ===\n$historySummary\n\n";
        }

        if ($contextRows) {
            $contextText .= "=== Konteks dari Knowledge Base ===\n";
            foreach ($contextRows as $i => $row) {
                $contextText .= ($i + 1) . ". {$row['chunktext']}\nSumber: {$row['filenm']}\n\n";
            }
        }

        $finalPrompt = <<<PROMPT
Gunakan konteks berikut sebagai sumber utama. Tampilkan sitasi sumber jawabannya di paling bawah.
Jika informasi tidak cukup atau tidak ditemukan di konteks, jawab "Tidak ditemukan dalam knowledge base".

Konteks:
$contextText

Pertanyaan:
$prompt
PROMPT;

        /** ================= GENERATE ================= */
        try {
            $startTime = microtime(true);

            $res = $this->client->post('https://ollama.com/api/generate', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->api,
                ],
                'json' => [
                    'model' => $model,
                    'prompt' => $finalPrompt,
                    'stream' => false,
                ],
                'http_errors' => false,
            ]);

            $latency_ms = (int)round((microtime(true) - $startTime) * 1000);
            $result = json_decode($res->getBody(), true);
        } catch (\Throwable $e) {
            return $this->respondError('Tidak dapat terhubung ke Ollama.');
        }

        if (!isset($result['response'])) {
            return $this->respondError('Model tidak mengirim respons.');
        }

        $chatResponse = $result['response'];

        /** ================= SAVE ================= */
        $this->db->table('messages')->insert([
            'conversation_id' => $conversation_id,
            'role' => 'user',
            'content' => $prompt,
            'model_name' => $model,
            'params' => '{}',
            'tokens_input' => 0,
            'tokens_output' => 0,
            'latency_ms' => 0,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $this->db->table('messages')->insert([
            'conversation_id' => $conversation_id,
            'role' => 'assistant',
            'content' => $chatResponse,
            'model_name' => $model,
            'params' => json_encode(['temperature' => $model]),
            'tokens_input' => $result['prompt_eval_count'] ?? 0,
            'tokens_output' => $result['eval_count'] ?? 0,
            'latency_ms' => $latency_ms,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return $this->response->setJSON([
            'status' => 'success',
            'response' => $chatResponse,
            'context' => $contextText,
            'prompt' => $finalPrompt,
            'conversation_id' => $conversation_id,
            'model' => $model,
        ]);
    }

    private function respondError(string $msg)
    {
        return $this->response->setJSON(['error' => $msg]);
    }
}
