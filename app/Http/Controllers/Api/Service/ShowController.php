<?php

namespace App\Http\Controllers\Api\Service;

use App\Common\Fields\Service\UserSearchFields;
use App\Common\Helpers\Show\FilterFields;
use App\Common\Helpers\Show\SearchFields;
use App\Common\Helpers\Show\SortFields;
use App\Exceptions\ReturnResponseException;
use App\Http\Controllers\Controller;
use App\Models\Media\Loan;
use App\Models\User\Employee;
use App\Models\User\Image;
use App\Models\User\Student;
use Illuminate\Http\JsonResponse;

class ShowController extends Controller
{
    public function show(string $type, int $id): JsonResponse
    {
        $model = (match ($type) {
            'student' => Student::fullInfo($id),
            'employee' => Employee::fullInfo($id),
            default => throw new ReturnResponseException('Incorrect user type', 400),
        })->first();

        $image = Image::find($id);
        $media = Loan::userHistory($model->user_cid)->get();

        $image = $image ? 'data:image/' . $type . ';base64,' . base64_encode($image->image) : null;

        return response()->json([
            'res' => [
                'info' => $model,
                'photo' => $image,
                'history' => $media->toArray()
            ]
        ]);
    }

    public function types(): JsonResponse
    {
        return response()->json([
            'res' => [
                'types' => [
                    ['key' => 'student', 'title' => 'Student'],
                    ['key' => 'employee', 'title' => 'Staff']
                ]
            ],
        ]);
    }

    public function searchFields(): JsonResponse
    {
        return response()->json([
            'res' => SearchFields::searchFields(new UserSearchFields())
        ]);
    }

    public function sortFields(): JsonResponse
    {
        return response()->json([
            'res' => SortFields::sortFields(new UserSearchFields())
        ]);
    }

    public function filterFields(): JsonResponse
    {
        return response()->json([
            'res' => FilterFields::filterFields(new UserSearchFields())
        ]);
    }
}
