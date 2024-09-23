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
}
