<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreShortUrlApiRequest;
use App\Http\Resources\ShortUrlResource;
use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShortUrlController extends Controller
{
    public function index(Request $request)
    {
        $shortUrls = ShortUrl::visibleTo($request->user())->latest()->paginate(15);

        return response()->json(
            ShortUrlResource::collection($shortUrls)->response()->getData(true)
        );
    }


    public function store(StoreShortUrlApiRequest $request)
    {
        $this->authorize("create", ShortUrl::class);

        $shortUrl = ShortUrl::create([
            "code" => $this->generateUniqueCode(),
            "original_url" => $request->validated()["original_url"],
            "user_id" => $request->user()->id,
            "company_id" => $request->user()->company_id,
        ]);

        return (new ShortUrlResource($shortUrl))->response()->setStatusCode(201);
    }


    private function generateUniqueCode(): string
    {
        do {
            $code = Str::random(7);
        } while (ShortUrl::where("code", $code)->exists());

        return $code;
    }
}
