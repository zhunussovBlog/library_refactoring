<?php

namespace App\Http\Controllers\Api\Report\Attendance;

use App\Common\Fields\Report\LoanFields;
use App\Common\Helpers\Controller\CustomPaginate;
use App\Common\Helpers\Controller\Search;
use App\Common\Helpers\Query\QueryHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Models\Media\Loan;
use App\Models\User\WebLog;
use Illuminate\Http\JsonResponse;
use JetBrains\PhpStorm\Pure;

class AttendanceController extends Controller
{
    public function getVirtualAttendance(): JsonResponse
    {
        $byWeek = WebLog::whereByWeek(WebLog::byWeek())->get()->toArray();
        $byMonth = WebLog::whereByMonth(WebLog::byMonths())->get()->toArray();

        $totalOfWeek = WebLog::whereByWeek(WebLog::total())->first()->toArray();
        $totalOfMonth = WebLog::whereByMonth(WebLog::total())->first()->toArray();

        $overallOfWeek = WebLog::whereByWeek(WebLog::overall())->first()->toArray();
        $overallOfMonth = WebLog::whereByMonth(WebLog::overall())->first()->toArray();

        return response()->json([
            'res' => [
                'byWeek' => [
                    'data' => $this->processData($byWeek),
                    'total' => $totalOfWeek,
                    'overall' => $this->calculateOverall($totalOfWeek, $overallOfWeek)
                ],
                'byMonth' => [
                    'data' => $this->processData($byMonth),
                    'total' => $totalOfMonth,
                    'overall' => $this->calculateOverall($totalOfMonth, $overallOfMonth)
                ],
            ]
        ]);
    }

    public function getLibraryAttendance(): JsonResponse
    {
        $byWeek = Loan::whereByWeek(Loan::byWeek())->get()->toArray();
        $byMonth = Loan::whereByMonth(Loan::byMonths())->get()->toArray();

        $totalOfWeek = Loan::whereByWeek(Loan::total())->first()->toArray();
        $totalOfMonth = Loan::whereByMonth(Loan::total())->first()->toArray();

        $overallOfWeek = Loan::whereByWeek(Loan::overall())->first()->toArray();
        $overallOfMonth = Loan::whereByMonth(Loan::overall())->first()->toArray();

        return response()->json([
            'res' => [
                'byWeek' => [
                    'data' => $this->processData($byWeek),
                    'total' => $totalOfWeek,
                    'overall' => $this->calculateOverall($totalOfWeek, $overallOfWeek)
                ],
                'byMonth' => [
                    'data' => $this->processData($byMonth),
                    'total' => $totalOfMonth,
                    'overall' => $this->calculateOverall($totalOfMonth, $overallOfMonth)
                ]
            ]
        ]);
    }

    public function getDepartments(): JsonResponse
    {
        return response()->json([
            'res' => Loan::departments()->get()->toArray()
        ]);
    }

    public function search(SearchRequest $request): JsonResponse
    {
        $perPage = $request->get('per_page') ?? 10;
        $data = Search::search($request, QueryHelper::nestedQuery(new Loan()), new LoanFields());
        return response()->json([
            'res' => CustomPaginate::getPaginate($data, $request, $perPage),
            'all' => $data->pluck('id')->toArray()
        ]);
    }

    private function processData(array $data): object
    {
        $result = [];
        foreach ($data as $item) {
            $result[$item['name']] = $item['count'];
        }

        return (object)$result;
    }

    #[Pure] private function calculateOverall(array $total, array $overall): object
    {
        foreach ($total as $key => $value) {
            $total[$key] = $overall['count'] > 0 ? round(($value * 100) / $overall['count'], '2') : 0;
            $total[$key] .= '%';
        }

        return (object)$total;
    }
}
