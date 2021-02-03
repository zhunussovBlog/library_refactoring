<?php


namespace App\Common\Fields\Media;


use App\Common\Constants\SearchFieldConstants;
use App\Common\Interfaces\Fields\FieldInterface;

class MediaFields extends FieldInterface
{
    protected static array $sortFields = [];

    protected static array $searchFields = [
        ['key' => 'authors', 'title' => 'Authors', 'method' => SearchFieldConstants::LIKE],
        ['key' => 'title', 'title' => 'Title', 'method' => SearchFieldConstants::LIKE],
        ['key' => 'publisher', 'title' => 'Publisher', 'method' => SearchFieldConstants::LIKE],
        ['key' => 'isbn', 'title' => 'ISBN', 'method' => SearchFieldConstants::LIKE],
        ['key' => 'call_number', 'Call number' => 'Title', 'method' => SearchFieldConstants::LIKE],
    ];

    protected static array $addSearchFields = [];

    protected static array $filterFields = [
        ['key' => 'year', 'title_key' => 'year', 'title' => 'Year', 'method' => SearchFieldConstants::EQUALS],
        ['key' => 'type_key', 'title_key' => 'type', 'title' => 'Type', 'method' => SearchFieldConstants::IN],
        ['key' => 'language', 'title_key' => 'language', 'title' => 'Language', 'method' => SearchFieldConstants::IN]
    ];
}
