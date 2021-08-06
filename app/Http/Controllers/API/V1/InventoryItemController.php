<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Models\InventoryItem;
use App\Http\Controllers\Controller;
use App\Http\Resources\InventoryItem as InventoryItemResource;

class InventoryItemController extends Controller
{
    public function __invoke()
    {
        return InventoryItemResource::collection(InventoryItem::restaurant()->paginate());
    }
}
