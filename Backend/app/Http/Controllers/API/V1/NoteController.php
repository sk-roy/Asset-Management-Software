<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Services\API\V1\NoteService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class NoteController extends Controller
{
    protected $noteService;

    public function __construct(NoteService $noteService)
    {
        $this->noteService = $noteService;
    }

    public function get(Request $request, $id): JsonResponse
    {
        Log::info('Method [NoteController.get] Start.', ['request' => request()->all(), 'user' => auth()->user()]);
        $response = [
            'success' => false,
            'data' => [],
            'message' => ''
        ];

        try {
            $note = $this->noteService->get($id);

            $response['success'] = true;
            $response['data'] = $note;
            $response['message'] = 'Note loaded successfully.';
            Log::info($response['message'], ['response' => $response]);

        } catch (\Exception $e) {
            $response['success'] = false;
            $response['message'] = 'Note loading failed.';
            
            Log::error('Notes loading failed:', ['error' => $e->getMessage()]);
        }

        Log::info('Method [NoteController.get] End.', ['response' => $response, 'user' => auth()->user()]);
        return response()->json($response);
    }

    public function getAll(Request $request): JsonResponse
    {
        Log::info('Method [NoteController.get] Start.', ['request' => request()->all(), 'user' => auth()->user()]);
        $response = [
            'success' => false,
            'data' => [],
            'message' => ''
        ];

        try {
            $notes = $this->noteService->getAll();

            $response['success'] = true;
            $response['data'] = $notes;
            $response['message'] = 'Notes loaded successfully.';
            Log::info($response['message'], ['response' => $response]);

        } catch (\Exception $e) {
            $response['success'] = false;
            $response['message'] = 'Notes loading failed.';
            
            Log::error('Notes loading failed:', ['error' => $e->getMessage()]);
        }

        Log::info('Method [NoteController.get] End.', ['response' => $response, 'user' => auth()->user()]);
        return response()->json($response);
    }


    public function store(Request $request) 
    {

        Log::info('Method [NoteController.get] Start.', ['request' => request()->all(), 'user' => auth()->user()]);
        $response = [
            'success' => false,
            'data' => [],
            'message' => ''
        ];
        try {
            $request->validate([
                'title' => 'required|string',
                'description' => 'nullable|string',
            ]);

            $note = $this->noteService->create(
                auth()->id(),
                $request->input('asset_id'),
                $request->only(['title', 'description'])
            );
            
            $response['success'] = true;
            $response['data'] = $note;
            $response['message'] = 'Note created successfully.';
            Log::info($response['message'], ['response' => $response]);

        } catch (\Exception $e) {
            $response['success'] = false;
            $response['message'] = 'Notes creation failed.';
            Log::error('Note creation failed:', ['error' => $e->getMessage()]);
        }

        Log::info('Method [NoteController.get] End.', ['response' => $response, 'user' => auth()->user()]);
        return response()->json($response);
    }

    public function update(Request $request, $id): JsonResponse
    {
        Log::info('Method [NoteController.update] Start.', ['request' => request()->all(), 'user' => auth()->user()]);
        $response = [
            'success' => false,
            'data' => [],
            'message' => ''
        ];
        try {
            $request->validate([
                'title' => 'required|string',
                'description' => 'nullable|string',
            ]);

            $note = $this->noteService->update($id, $request->only(['title', 'description']));

            $response['success'] = true;
            $response['data'] = $note;
            $response['message'] = 'Note updated successfully.';
            Log::info($response['message'], ['response' => $response]);

        } catch (\Exception $e) {
            $response['success'] = false;
            $response['message'] = 'Note updating failed.';            
            Log::error($response['message'], ['error' => $e->getMessage()]);
        }

        Log::info('Method [NoteController.update] End.', ['response' => $response, 'user' => auth()->user()]);
        return response()->json($response);
    }

    public function delete(Request $request, $id): JsonResponse
    {
        Log::info('Method [NoteController.delete] Start.', ['request' => request()->all(), 'user' => auth()->user()]);
        $response = [
            'success' => false,
            'message' => ''
        ];
        try {
            $this->noteService->delete($id);

            $response['success'] = true;
            $response['message'] = 'Note deleted successfully.';
            Log::info($response['message'], ['response' => $response]);

        } catch (\Exception $e) {
            $response['success'] = false;
            $response['message'] = 'Note deleting failed.';            
            Log::error($response['message'], ['error' => $e->getMessage()]);
        }

        Log::info('Method [NoteController.delete] End.', ['response' => $response, 'user' => auth()->user()]);
        return response()->json($response);
    }
}
