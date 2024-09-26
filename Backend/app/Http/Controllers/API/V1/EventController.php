<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Services\API\V1\EventService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    protected $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function index(Request $request)  // load all events of an user
    {
        Log::info('Event loading [index] started.', ['request' => request()->all()]);
        $response = [
            'success' => false,
            'data' => [],
            'message' => ''
        ];
        try {
            $userId = auth()->id();
            $sortKey = $request->input('sort_key', 'created_at');
            $sortOrder = $request->input('sort_order', 'asc');

            $events = $this->eventService->loadSortedEventsOfUser($userId, $sortKey, $sortOrder);
            
            $response['success'] = true;
            $response['data'] = $events;
            $response['message'] = 'Events loaded succesfully.';
            Log::info($response['message'], ['response' => $response]);
        } catch (\Exception $e) {
            $response['success'] = false;
            $response['message'] = 'Events loading failed.';
            Log::error('Events loading failed:', ['error' => $e->getMessage()]);            
        }

        Log::info('Event loading [index] completed', ['response' => $response]);
        return response()->json($response);
    }

    public function get(Request $request, $id)
    {
        Log::info('Method [EventController.get] Start.', ['request' => request()->all(), 'user' => auth()->user()]);
        $response = [
            'success' => false,
            'data' => [],
            'message' => ''
        ];
        try {
            $event = $this->eventService->get($id);

            $response['success'] = true;
            $response['data'] = $event;
            $response['message'] = 'Event loaded successfully.';
            Log::info($response['message'], ['response' => $response]);

        } catch (\Exception $e) {
            $response['success'] = false;
            $response['message'] = 'Events loading failed.';
            
            Log::error('Events loading failed:', ['error' => $e->getMessage()]);
        }

        Log::info('Method [EventController.get] End.', ['response' => $response, 'user' => auth()->user()]);
        return response()->json($response);
    }

    public function loadSortedEventsOfAsset(Request $request, $id)
    {
        Log::info('Event loading[loadSortedEventsOfAsset] started.', ['request' => request()->all()]);
        $response = [
            'success' => false,
            'data' => [],
            'message' => ''
        ];
        try {
            $sortKey = $request->input('sort_key', 'created_at');
            $sortOrder = $request->input('sort_order', 'asc');

            $events = $this->eventService->loadSortedEventsOfAsset($id, $sortKey, $sortOrder);
            
            $response['success'] = true;
            $response['data'] = $events;
            $response['message'] = 'Events loaded succesfully.';
            Log::info($response['message'], ['response' => $response]);
        } catch (\Exception $e) {
            $response['success'] = false;
            $response['message'] = 'Events loading failed.';
            Log::error('Events loading failed:', ['error' => $e->getMessage()]);            
        }

        Log::info('Event loading[loadSortedEventsOfAsset] completed', ['response' => $response]);
        return response()->json($response);
    }

    public function store(Request $request)
    {
        Log::info('Method [EventController.store] started.', ['request' => request()->all()]);
        $response = [
            'success' => false,
            'data' => [],
            'message' => ''
        ];

        try {
            $data = $this->getAssetData($request);
            $event = $this->eventService->create($data, $request->input('asset_id'), $request->input('category_id'));
            
            $response['success'] = true;
            $response['data'] = $event;
            $response['message'] = 'Event created succesfully.';
            Log::info($response['message'], ['response' => $response]);
        } catch (\Exception $e) {
            $response['success'] = false;
            $response['message'] = 'Events creating failed.';
            Log::error('Events creating failed:', ['error' => $e->getMessage()]);            
        }

        Log::info('Method [EventController.store] ended.', ['response' => $response]);
        return response()->json($response);
    }

    public function update(Request $request, $id)
    {

        Log::info('Method [EventController.update] Start.', ['request' => request()->all(), 'user' => auth()->user()]);
        $response = [
            'success' => false,
            'data' => [],
            'message' => ''
        ];
        try {
            $eventData = $this->getEventData($request);
            $event = $this->eventService->update($id, $eventData);

            $response['success'] = true;
            $response['data'] = $event;
            $response['message'] = 'Event updated successfully.';
            Log::info($response['message'], ['response' => $response]);

        } catch (\Exception $e) {
            $response['success'] = false;
            $response['message'] = 'Event updating failed.';            
            Log::error($response['message'], ['error' => $e->getMessage()]);
        }

        Log::info('Method [EventController.update] End.', ['response' => $response, 'user' => auth()->user()]);
        return response()->json($response);
    }

    public function delete(Request $request, $id)
    {
        Log::info('Method [EventController.delete] Start.', ['request' => request()->all(), 'id' => $id, 'user' => auth()->user()]);
        $response = [
            'success' => false,
            'message' => ''
        ];
        try {
            $this->eventService->delete($id);

            $response['success'] = true;
            $response['message'] = 'Event deleted successfully.';
            Log::info($response['message'], ['response' => $response]);

        } catch (\Exception $e) {
            $response['success'] = false;
            $response['message'] = 'Event deleting failed.';            
            Log::error($response['message'], ['error' => $e->getMessage()]);
        }

        Log::info('Method [EventController.delete] End.', ['response' => $response, 'user' => auth()->user()]);
        return response()->json($response);
    }

    public function deleteList(Request $request)
    {
        Log::info('Method [EventController.deleteList] Start.', ['request' => request()->all(), 'user' => auth()->user()]);
        $response = [
            'success' => false,
            'message' => ''
        ];

        try {
            $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'exists:events,id',
            ]);

            $this->eventService->deleteList($request->ids);

            $response['success'] = true;
            $response['message'] = 'Events deleted successfully.';
            Log::info($response['message'], ['response' => $response]);

        } catch (\Exception $e) {
            $response['message'] = 'Events deleting failed.';            
            Log::error($response['message'], ['error' => $e->getMessage()]);
        }

        Log::info('Method [EventController.deleteList] End.', ['response' => $response, 'user' => auth()->user()]);
        return response()->json($response);
    }


    private function getEventData(Request $request)
    {
        Log::info('Method [EventController.getEventData] Start.', ['request' => $request->all(), 'user' => auth()->user()]);

        $request->validate([
            'title' => 'nullable|string|unique:assets,title', 
            'datetime' => 'nullable|date', 
            'description' => 'nullable|string',
            'charge' => 'nullable|numeric',  
            'active_mode' => 'nullable|boolean',  
            'map_location' => 'nullable|string',
            'asset_id' => 'nullable|exists:assets,id',  
            'category_id' => 'nullable|exists:categories,id',
            'service_provider' => 'nullable|string',
            'service_details' => 'nullable|string',
            'cleaning_service' => 'nullable|string',
            'cleaning_charge' => 'nullable|numeric',
            'replacement_item' => 'nullable|string',
            'replacement_cost' => 'nullable|numeric',
            'visitor_name' => 'nullable|string',
            'visit_purpose' => 'nullable|string',
            'bill_provider' => 'nullable|string',
            'bill_amount' => 'nullable|numeric',
        ]);

        $data = $request->only([
            'title', 
            'datetime', 
            'description', 
            'charge',  
            'active_mode',  
            'map_location',
            'service_provider', 
            'service_details', 
            'cleaning_service', 
            'cleaning_charge', 
            'replacement_item', 
            'replacement_cost', 
            'visitor_name', 
            'visit_purpose', 
            'bill_provider', 
            'bill_amount'
        ]);
        

        Log::info('Method [EventController.getEventData] End.', ['data' => $data, 'user' => auth()->user()]);

        return $data;
    }

}
