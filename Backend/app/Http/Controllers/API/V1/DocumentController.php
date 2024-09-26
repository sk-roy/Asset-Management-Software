<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Services\API\V1\DocumentService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class DocumentController extends Controller
{
    protected $documentService;

    public function __construct(DocumentService $documentService)
    {
        $this->documentService = $documentService;
    }

    public function show(Request $request): JsonResponse
    {
        Log::info('Method [DocumentController.show] Start.', ['request' => request()->all(), 'user' => auth()->user()]);
        $response = [
            'success' => false,
            'data' => [],
            'message' => ''
        ];

        try {
            $documents = $this->documentService->getAll($request->query('asset_id'));

            $response['success'] = true;
            $response['data'] = $documents;
            $response['message'] = 'Documents loaded successfully.';
            Log::info($response['message'], ['response' => $response]);

        } catch (\Exception $e) {
            $response['success'] = false;
            $response['message'] = 'Documents loading failed.';
            
            Log::error('Documents loading failed:', ['error' => $e->getMessage()]);
        }

        Log::info('Method [DocumentController.show] End.', ['response' => $response, 'user' => auth()->user()]);
        return response()->json($response);
    }


    public function store(Request $request) 
    {

        Log::info('Method [DocumentController.store] Start.', ['request' => request()->all(), 'user' => auth()->user()]);
        $response = [
            'success' => false,
            'data' => [],
            'message' => ''
        ];
        try {   
            $request->validate([
                'document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048'
            ]);

            $document = $this->documentService->create($request->input('asset_id'), $request->file('document'));
            
            $response['success'] = true;
            $response['data'] = $document;
            $response['message'] = 'Document created successfully.';
            Log::info($response['message'], ['response' => $response]);

        } catch (Exception $e) {
            $response['success'] = false;
            $response['message'] = 'Documents creation failed.';
            Log::error('Document creation failed:', ['error' => $e->getMessage()]);
        }

        Log::info('Method [DocumentController.store] End.', ['response' => $response, 'user' => auth()->user()]);
        return response()->json($response);
    }


    public function download(Request $request, $id) 
    {

        Log::info('Method [DocumentController.download] Start.', ['request' => request()->all(), 'user' => auth()->user()]);
        $response = [
            'success' => false,
            'data' => [],
            'message' => ''
        ];
        try {   
            $document = $this->documentService->download($id);
            
            $response['success'] = true;
            $response['data'] = $document;
            $response['message'] = 'Document downloaded successfully.';
            Log::info($response['message'], ['response' => $response]);

        } catch (\Exception $e) {
            $response['success'] = false;
            $response['message'] = 'Documents downloading failed.';
            Log::error($response['message'], ['error' => $e->getMessage()]);
        }

        Log::info('Method [DocumentController.download] End.', ['response' => $response, 'user' => auth()->user()]);
        return $document;
    }

    public function delete(Request $request, $id): JsonResponse
    {
        Log::info('Method [DocumentController.delete] Start.', ['request' => request()->all(), 'user' => auth()->user()]);
        $response = [
            'success' => false,
            'message' => ''
        ];
        try {
            $this->documentService->delete($id);

            $response['success'] = true;
            $response['message'] = 'Document deleted successfully.';
            Log::info($response['message'], ['response' => $response]);

        } catch (\Exception $e) {
            $response['success'] = false;
            $response['message'] = 'Document deleting failed.';            
            Log::error($response['message'], ['error' => $e->getMessage()]);
        }

        Log::info('Method [DocumentController.delete] End.', ['response' => $response, 'user' => auth()->user()]);
        return response()->json($response);
    }
}
