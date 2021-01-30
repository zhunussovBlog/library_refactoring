<?php


namespace App\Helpers\ControllerHelpers;


use App\Exceptions\ReturnResponseException;
use Illuminate\Support\Facades\DB;
use ReflectionClass;

class ManageData
{
    public static function create($class, array $createInputs): array
    {
        $response = [];
        $className = (new ReflectionClass($class))->getShortName();
        DB::beginTransaction();
        $data = $class::create($createInputs);

        if (empty($data) && empty($data->getKey())) {
            DB::rollBack();
            throw new ReturnResponseException(__('general.create_failed', ['name' => $className]), 409);
        }

        CacheJobs::cacheCreatedData($data->getKey(), $class::CREATED_ID_NAME);

        $response['res'] = ['message' => __('general.create_success', ['name' => $className]), 'id' => $data->getKey()];
        DB::commit();

        return $response;
    }

    public static function update($class, int $id, array $updateInputs): array
    {
        $response = [];
        $className = (new ReflectionClass($class))->getShortName();
        DB::beginTransaction();
        $data = $class::find($id);
        if (!$data->update($updateInputs)) {
            DB::rollBack();
            throw new ReturnResponseException(__('general.update_failed', ['name' => $className]), 409);
        }

        $response['res'] = ['message' => __('general.update_success', ['name' => $className])];
        DB::commit();
        return $response;
    }

    public static function delete($class, $id): array
    {
        $response = [];
        $className = (new ReflectionClass($class))->getShortName();
        DB::beginTransaction();

        $data = $class::find($id);
        if (!$data->delete()) {
            DB::rollBack();
            throw new ReturnResponseException(__('general.delete_failed', ['name' => $className]), 409);
        }

        $response['res'] = ['message' => __('general.delete_success', ['name' => $className])];
        DB::commit();

        return $response;
    }
}
