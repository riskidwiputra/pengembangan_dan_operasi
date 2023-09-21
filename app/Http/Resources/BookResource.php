<?php

namespace App\Http\Resources;

use App\Helpers\General as HelpersGeneral;
use General;
use Illuminate\Http\Resources\Json\JsonResource;
use Ramsey\Uuid\Type\Decimal;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return  [
                'id' => $this->id,
                'isbn' => $this->isbn,
                'title' => $this->title,
                'description' => $this->description,
                'published_year' => $this->published_year,
                'authors' => $this->authors,
                'book_contents' => $this->bookContents,
                'price' => $this->price,
                'price_rupiah' => usd_to_rupiah_format($this->price),
                'review' => [
                    'avg' =>  $this->reviews?->avg('review') ?? 0,
                    'count' => $this->reviews_count ?? 0
                ]
        ];
    }
}
