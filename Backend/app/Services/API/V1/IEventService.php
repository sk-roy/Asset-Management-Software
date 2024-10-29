<?php

namespace App\Services\API\V1;

interface IEventService
{
    public function loadSortedEventsOfUser($userId, $sortKey = 'created_at', $sortOrder = 'asc');
    public function loadSortedEventsOfAsset($assetId, $sortKey = 'created_at', $sortOrder = 'asc');
    public function get($id);
    public function create(array $data, $assetId, $categoryId);
    public function update($eventId, array $data);
    public function delete($eventId);
    public function deleteList(array $list);
}
