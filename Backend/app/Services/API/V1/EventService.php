<?php

namespace App\Services\API\V1;

use App\Models\Event;
use App\Models\Asset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EventService
{
    public function loadSortedEventsOfUser($userId, $sortKey = 'created_at', $sortOrder = 'asc')
    {
        try {
            $validSortOrder = ['asc', 'desc'];
            if (!in_array(strtolower($sortOrder), $validSortOrder)) {
                $sortOrder = 'asc'; 
            }

            $user = User::findOrFail($userId);
            $events = $user->events()->orderBy($sortKey, $sortOrder)->get();

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
}
