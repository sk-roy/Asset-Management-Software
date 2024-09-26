<?php

namespace App\Services\API\V1;

use App\Models\Asset;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DocumentService
{
    public function getAll($getAll)
    {
        Log::info('Method [DocumentService.getAll] Start.');
        
        try {
            $asset = Asset::findOrFail($assetId);
            $documents = $asset->documents()->get();

            Log::info('Document loading completed:', ['documents' => $documents]);

        } catch (Exception $e) {
            Log::error('Documents loading failed:', ['error' => $e->getMessage()]);
            throw new Exception('Documents loading failed.');
        }
        
        Log::info('Method [DocumentService.getAll] Start.', ['documents' => $documents]);
        return $documents;
    }

    public function create($assetId, $uploadedDocument)
    {
        Log::info('Method [DocumentService.create] Start.',['assetId' => $assetId, 'uploadedDocument' => $uploadedDocument]);

        try { 
            $user = auth()->user();
            $asset = Asset::findOrFail($assetId);

            $documentTitle = $uploadedDocument->getClientOriginalName();
            $documentName = time() . '_' . $documentTitle;
            
            $path = $uploadedDocument->storeAs('uploads', $documentName, 'public');
            $document = Document::create([
                'name'  => $documentName,
                'title' => $documentTitle,
                'path'      => $path,
                'mime_type' => $uploadedDocument->getClientMimeType(),
                'size'      => $uploadedDocument->getSize(),
            ]);

            $document->user()->associate($user);
            $document->asset()->associate($asset);
            $document->save();

            Log::info('Document uploaded successfully.', ['user' => $user, 'document' => $document]);

        } catch (Exception $e) {
            Log::error('Documents creating failed:', ['error' => $e->getMessage()]);
            throw new Exception("An error occurred while creating the document", 500);
        }
        
        Log::info('Method [DocumentService.create] End.', ['user' => $user, 'document' => $document]);
        return $document;
    }

    public function download($id)
    {
        Log::info('Method [DocumentService.download] Start.',['id' => $id]);

        try { 
            $file = Document::where('id', $id)->firstOrFail();            
            $document = Storage::disk('public')->download($file->path, $file->name);
            Log::info('Document downloaded successfully.', ['document' => $document]);
        } catch (Exception $e) {
            Log::error('Documents downloading failed:', ['error' => $e->getMessage()]);
            throw new Exception("An error occurred while downloading the document", 500);
        }
        
        Log::info('Method [DocumentService.download] End.', ['user' => auth()->user()]);
        return $document;
    }

    public function delete($id)
    {
        Log::info('Method [DocumentService.delete] Start.', ['id' => $id]);

        try {
            $file = Document::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
            $file->delete();

            Log::info('Document deleted succesfully.');

        } catch (ModelNotFoundException $e) {            
            Log::error('Documents not found:', ['error' => $e->getMessage()]);
            throw new Exception("Document not found", 404);
        } catch (Exception $e) {            
            Log::error('Documents deleting failed:', ['error' => $e->getMessage()]);
            throw new Exception("An error occurred while deleting document", 500);
        }

        Log::info('Method [DocumentService.delete] End.', ['id' => $id]);
    }

    public function restore($id)
    {
        Log::info('Method [DocumentService.restore] Start.', ['id' => $id]);

        try {
            $document = Document::onlyTrashed()->findOrFail($id);
            $document->restore();
            Log::info('Document deleted succesfully.');
        } catch (ModelNotFoundException $e) {            
            Log::error('Documents not found:', ['error' => $e->getMessage()]);
            throw new Exception("Document not found", 404);
        } catch (Exception $e) {            
            Log::error('Documents restoring failed:', ['error' => $e->getMessage()]);
            throw new Exception("An error occurred while restoring document", 500);
        }

        Log::info('Method [DocumentService.restore] End.', ['id' => $id]);
        return $document;
    }
}
