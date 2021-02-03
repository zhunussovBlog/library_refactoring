<?php


namespace App\Common\Helpers\Models\Media;


use App\Common\Interfaces\Models\GetModelsInterface;
use App\Models\Media\Book;
use App\Models\Media\Disc;
use App\Models\Media\Journal;
use JetBrains\PhpStorm\Pure;

class GetModels implements GetModelsInterface
{
    #[Pure] public static function getModels(): array
    {
        return [new Book(), new Disc(), new Journal()];
    }
}
