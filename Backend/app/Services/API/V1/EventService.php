<?php

namespace App\Services\API\V1;

use App\Models\Asset;
use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EventService implements IEventService
{
    public function loadSortedEventsOfUser($userId, $sortKey = 'created_at', $sortOrder = 'asc', $active = 'All')
    {
        try {
            $validSortOrder = ['asc', 'desc'];
            if (!in_array(strtolower($sortOrder), $validSortOrder)) {
                $sortOrder = 'asc'; 
            }

            $events = auth()->user()->events()->orderBy($sortKey, $sortOrder)->get();

            return $events;
        } catch (\Exception $e) {
            Log::error('Events loading failed:', ['error' => $e->getMessage()]);
            throw new \Exception('Events loading failed.');
        }
    }
    
    public function loadSortedEventsOfAsset($assetId, $sortKey = 'created_at', $sortOrder = 'asc')
    {
        try {
            $validSortOrder = ['asc', 'desc'];
            if (!in_array(strtolower($sortOrder), $validSortOrder)) {
                $sortOrder = 'asc'; 
            }

            $asset = Asset::findOrFail($assetId);
            $events = $asset->events()->orderBy($sortKey, $sortOrder)->get();

            return $events;
        } catch (\Exception $e) {
            Log::error('Events loading failed:', ['error' => $e->getMessage()]);
            throw new \Exception('Events loading failed.');
        }
    } 
    
    public function getLiveDeadEvents($isActive)
    {
        Log::info('Method [EventService.getLiveDeadEvents] Start.', ['isActive' => $isActive]);
        try {
            $events = auth()->user()->events()->where('active_mode', $isActive)->get();

            return $events;
        } catch (\Exception $e) {
            Log::error('Events loading failed:', ['error' => $e->getMessage()]);
            throw new \Exception('Events loading failed.');
        }
        Log::info('Method [EventService.getLiveDeadEvents] Start.', ['events' => $events]);
    }

    public function get($id)
    {
        Log::info('Method [EventService.get] Start.', ['id' => $id]);
        
        try {
            $event = Event::findOrFail($id);

            if (!$event) {
                Log::error('Event not found:', ['error' => $e->getMessage()]);
                throw new \Exception('Event not found.');
            }

            Log::info('Event loading completed:', ['event' => $event]);

        } catch (Exception $e) {
            Log::error('Events loading failed:', ['error' => $e->getMessage()]);
            throw new \Exception('Events loading failed.');
        }
        
        Log::info('Method [EventService.get] End.', ['event' => $event]);
        return $event;
    }   

    public function create(array $data, $assetId, $categoryId)
    {
        Log::info('Method [EventService.create] Start.', ['user' => auth()->user(), 'data' => $data]);

        try {            
            $user = auth()->user();
            $asset = Asset::findOrFail($assetId);
            $category = Category::findOrFail($categoryId);

            $event = Event::create($data);

            $event->user()->associate($user);
            $event->asset()->associate($asset);
            $event->category()->associate($category);
            $event->save();

            Log::error('Event created succesfully:', ['event' => $event]);

        } catch (Exception $e) {
            Log::error('Event creating failed:', ['error' => $e->getMessage()]);
            throw new Exception("An error occurred while creating the event", 500);
        }
        
        Log::info('Method [EventService.create] End.', ['user' => auth()->user(), 'event' => $event]);
        return $event;
    }

    public function update($eventId, array $data)
    {
        Log::info('Method [EventService.update] Start.', ['eventId' => $eventId, 'data' => $data]);

        try {
            $event = Event::findOrFail($eventId);
            $event->update($data);
            Log::error('Event updated succesfully:', ['event' => $event]);

        } catch (ModelNotFoundException $e) {            
            Log::error('Events not found:', ['error' => $e->getMessage()]);
            throw new Exception("Event not found", 404);
        } catch (Exception $e) {            
            Log::error('Events updating failed:', ['error' => $e->getMessage()]);
            throw new Exception("An error occurred while updating event", 500);
        }
        
        Log::info('Method [EventService.update] End.', ['event' => $event]);
        return $event;
    }

    public function delete($eventId)
    {
        Log::info('Method [EventService.delete] Start.', ['eventId' => $eventId]);

        try {
            $event = Event::find($eventId);
            $event->delete();
            Log::info('Event deleted succesfully.');

        } catch (ModelNotFoundException $e) {            
            Log::error('Events not found:', ['error' => $e->getMessage()]);
            throw new Exception("Event not found", 404);
        } catch (Exception $e) {            
            Log::error('Events deleting failed:', ['error' => $e->getMessage()]);
            throw new Exception("An error occurred while deleting event", 500);
        }

        Log::info('Method [EventService.delete] End.', ['eventId' => $eventId]);
    }

    public function deleteList(array $list)
    {
        Log::info('Method [EventService.deleteList] Start.', ['list' => $list]);

        try {
            Event::whereIn('id', $list)->delete();            
            Log::info('Events deleted succesfully.');

        } catch (ModelNotFoundException $e) {            
            Log::error('Events not found:', ['error' => $e->getMessage()]);
            throw new Exception("Events not found", 404);
        } catch (Exception $e) {            
            Log::error('Events deleting failed:', ['error' => $e->getMessage()]);
            throw new Exception("An error occurred while deleting events", 500);
        }

        Log::info('Method [EventService.deleteList] End.', ['list' => $list]);
    }
}
