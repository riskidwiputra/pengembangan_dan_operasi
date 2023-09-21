<?php

namespace App\Modules\Reviews\Interfaces;
interface ReviewsServiceInterface
{
    public function create($id,$request);
    public function destroy($book,$review);
}
