<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\CommentResource;
class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       $resource = $this->resource;
        return [
            'id'=>$resource->id,
            'body'=>$resource->body,
            'user_id'=>$resource->user_id,
            'comments' => CommentResource::collection($resource->comments),
           
        ];
    }
}
