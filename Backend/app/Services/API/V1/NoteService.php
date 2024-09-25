<?php

namespace App\Services\API\V1;

use App\Models\Asset;
use App\Models\Category;
use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NoteService
{
    public function get($id)
    {
        Log::info('Method [NoteService.get] Start.', ['id' => $id]);

        try {
            $note = Note::findOrFail($id);
            Log::error('Note loading completed:', ['note' => $note]);

        } catch (Exception $e) {
            Log::error('Note loading failed:', ['error' => $e->getMessage()]);
            throw new Exception('Note loading failed.');
        }
        
        Log::info('Method [NoteService.get] Start.', ['id' => $id, 'note' => $note]);
        return $note;
    }

    public function getAll()
    {
        Log::info('Method [NoteService.getNote] Start.');
        
        try {
            $notes = Note::all();
            Log::info('Note loading completed:', ['notes' => $notes]);

        } catch (Exception $e) {
            Log::error('Notes loading failed:', ['error' => $e->getMessage()]);
            throw new Exception('Notes loading failed.');
        }
        
        Log::info('Method [NoteService.getAll] Start.', ['notes' => $notes]);
        return $notes;
    }

    public function create($userId, $assetId, array $data)
    {
        Log::info('Method [NoteService.create] Start.',['userId' => $userId, 'assetId' => $assetId, 'data' => $data]);

        try {            
            $user = User::findOrFail($userId);
            $asset = Asset::findOrFail($assetId);

            $note = Note::create($data);

            $note->user()->associate($user);
            $note->asset()->associate($asset);
            $note->save();
            Log::error('Note created succesfully:', ['note' => $note, 'user' => $user, 'asset' => $asset]);

        } catch (Exception $e) {
            Log::error('Notes creating failed:', ['error' => $e->getMessage()]);
            throw new Exception("An error occurred while creating the note", 500);
        }
        
        Log::info('Method [NoteService.create] End.', ['userId' => $userId, 'note' => $note]);
        return $note;
    }

    public function update($id, array $data)
    {
        Log::info('Method [NoteService.update] Start.', ['id' => $id, 'data' => $data]);

        try {
            $note = Note::findOrFail($id);
            $note->update($data);
            Log::error('Note updated succesfully:', ['note' => $note]);

        } catch (ModelNotFoundException $e) {            
            Log::error('Notes not found:', ['error' => $e->getMessage()]);
            throw new Exception("Note not found", 404);
        } catch (Exception $e) {            
            Log::error('Notes updating failed:', ['error' => $e->getMessage()]);
            throw new Exception("An error occurred while updating note", 500);
        }
        
        Log::info('Method [NoteService.update] End.', ['note' => $note]);
        return $note;
    }

    public function delete($id)
    {
        Log::info('Method [NoteService.delete] Start.', ['id' => $id]);

        try {
            $note = Note::findOrFail($id);
            $note->delete();
            Log::info('Note deleted succesfully.');

        } catch (ModelNotFoundException $e) {            
            Log::error('Notes not found:', ['error' => $e->getMessage()]);
            throw new Exception("Note not found", 404);
        } catch (Exception $e) {            
            Log::error('Notes deleting failed:', ['error' => $e->getMessage()]);
            throw new Exception("An error occurred while deleting note", 500);
        }

        Log::info('Method [NoteService.delete] End.', ['id' => $id]);
    }
}
