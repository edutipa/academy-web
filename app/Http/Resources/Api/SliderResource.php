<?php

namespace App\Http\Resources\Api;

use App\Models\Course;
use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
{
    public function toArray($request): array
    {
        $image      = getFileLink('305x150', $this->image);

        if ($this->source != 'url')
        {
            $course     = $this->sliderable;
            $image      = getFileLink('402x248', @$course->image);
        }

        $data = [
            'id'        => (int) $this->id,
            'type'      => $this->source,
            'image'     => $image,
        ];

        if ($this->source == 'url')
        {
            $data['url'] = $this->url;
        }
        else{
            $data['course_book_id'] = (int)$this->sliderable_id;
        }

        return $data;
    }
}
