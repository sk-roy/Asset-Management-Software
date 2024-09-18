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
        try {
            $userId = auth()->id();
            $sortKey = $request->input('sort_key', 'created_at');
            $sortOrder = $request->input('sort_order', 'asc');

            $events = $this->eventService->loadSortedEventsOfUser($userId, $sortKey, $sortOrder);

            return response()->json([
                'events'=> $events,
                'message'=> 'Events loaded succesfully',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Events loading failed:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Events loading failed'], 500);
        }
    }

    public function loadSortedEventsOfAsset(Request $request, $id)
    {
        try {
            $sortKey = $request->input('sort_key', 'created_at');
            $sortOrder = $request->input('sort_order', 'asc');

            $events = $this->eventService->loadSortedEventsOfAsset($id, $sortKey, $sortOrder);

            return response()->json([
                'events'=> $events,
                'message'=> 'Events loaded succesfully',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Events loading failed:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Events loading failed'], 500);
        }
    }
}
