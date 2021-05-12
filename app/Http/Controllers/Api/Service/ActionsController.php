<?php

namespace App\Http\Controllers\Api\Service;

use App\Common\Helpers\Controller\LoanProcedure;
use App\Exceptions\ReturnResponseException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Service\ActionRequest;
use App\Models\User\WebLog;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ActionsController extends Controller
{
    public function backMaterial(ActionRequest $request): JsonResponse
    {
        $validated = $this->processInput($request);
        $result = LoanProcedure::backMaterial($validated);

        if (!$result['pRes']) {
            throw new ReturnResponseException('Process error', 100);
        }

        return response()->json([
            'res' => [
                'message' => 'success',
                'result' => (bool)$result['pRes'],
            ]
        ]);
    }

    public function giveMaterial(ActionRequest $request): JsonResponse
    {
        $validated = $this->processInput($request);
        $result = LoanProcedure::giveMaterial($validated);

        if (!$result['pRes']) {
            throw new ReturnResponseException('Process error', 100);
        }

        return response()->json([
            'res' => [
                'message' => 'success',
                'result' => (bool)$result['pRes'],
            ]
        ]);
    }

    private function processInput(ActionRequest $request): array
    {
        $validated = $request->validated();

        $userCID = $request->user()->user_cid;
        $webLog = WebLog::where('user_id', $userCID)->orderBy('log_date', 'desc')->first()->log_id;

        $validated['web_log_id'] = $webLog;

        $duration = DB::table('lib_cfg as lc')->select('lc.data')
            ->leftJoin('user_groups as ug', 'ug.group_id', '=', 'lc.group_id')
            ->where('lc.cfg_key', '=', 'BORROW_PERIOD')
            ->where('ug.user_cid', '=', $validated['user_cid'])
            ->orderBy('data', 'desc')
            ->first();

        $validated['due_date'] = Carbon::now()->addDays((int) $duration->data)->toDateString();

        return $validated;
    }
}
