<?php


namespace App\Common\Fields\Service;

use App\Common\Constants\SearchFieldConstants;
use App\Common\Interfaces\Fields\FieldInterface;

class UserSearchFields extends FieldInterface
{
    protected static array $sortFields = [
        ['key' => 'faculty', 'title' => 'Faculty'],
        ['key' => 'full_name', 'title' => 'Name']
    ];

    protected static array $searchFields = [
        ['key' => 'full_name', 'title' => 'Name', 'method' => SearchFieldConstants::LIKE],
        ['key' => 'username', 'title' => 'Username|ID', 'method' => SearchFieldConstants::LIKE],
        ['key' => 'all', 'title' => 'All', 'method' => SearchFieldConstants::LIKE],
    ];
}
