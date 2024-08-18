<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FeatureResource extends JsonResource
{
    public static $wrap = false;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'image' => $this->image,
            'route_name' => $this->route_name,
            'name' => $this->name,
            'desc' => $this->desc,
            'required_credits' => $this->required_credits,
            'active' => $this->active,
        ];
    }
}