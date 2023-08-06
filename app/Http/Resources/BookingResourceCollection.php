<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BookingResourceCollection extends ResourceCollection
{
    public function toArray(Request $request)
    {
        return parent::toArray($request);
    }
}
