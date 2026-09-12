<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShortUrlResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "code" => $this->code,
            "short_url" => url("/s/" . $this->code),
            "original_url" => $this->original_url,
            "clicks" => $this->clicks,
            "created_by" => $this->user->name,
            "company" => $this->company->name,
            "created_at" => $this->created_at->toIso8601String(),
        ];
    }
}
