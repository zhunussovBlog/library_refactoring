<?php


namespace App\Http\Controllers\Api\Cataloging;


use App\Common\Helpers\Controller\EditMaterialProcedure;
use App\Exceptions\ReturnResponseException;
use App\Http\Controllers\Api\Cataloging\Handler\MarcFieldsHandler;
use App\Http\Controllers\Api\Cataloging\Handler\MarcFieldsXmlHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cataloging\EditMaterialRequest;
use Illuminate\Http\JsonResponse;

class EditMaterialController extends Controller
{
    /**
     * @throws ReturnResponseException
     */
    public function __invoke(EditMaterialRequest $request, int $id): JsonResponse
    {
        $input = $request->validated()['data'];
        $template = (new MarcFieldsHandler($input))->getTemplate();
        $xml = (new MarcFieldsXmlHandler($template))->getXml();

        /*if ((int)EditMaterialProcedure::edit($this->getEditMaterialProcedureInput($input))['pRes'] !== 1) {
            throw new ReturnResponseException('Process error', 100);
        }*/

        if ((int)EditMaterialProcedure::loadXml([
                'id' => $id,
                'xml' => $xml
            ])['pRes'] !== 1) {
            throw new ReturnResponseException('Process error', 100);
        }

        return response()->json([
            'res' => [
                'message' => 'success',
                'result' => true,
            ],
        ]);
    }

    /**
     * @param array $data
     * @return array
     */
    private function getEditMaterialProcedureInput(array $data): array
    {
        $input = [];
        $input['call_number'] = $this->getFieldData('010.a', $data);
        $input['isbn'] = $this->getFieldData('020.a', $data);
        $input['title'] = $this->getFieldData('245.a', $data);
        $input['publisher'] = $this->getFieldData('260.b', $data);
        $input['year'] = $this->getFieldData('260.c', $data);
        $input['city'] = $this->getFieldData('260.a', $data);
        $input['language'] = $this->getFieldData('546.a', $data);
        $input['main_author'] = '';
        $input['other_author'] = '';
        $input['page_number'] = '';
        $input['parallel_title'] = '';
        $input['title_related_info'] = '';
        $input['type'] = '';

        return $input;
    }

    /**
     * @param string $key
     * @param array $data
     * @return string
     */
    private function getFieldData(string $key, array $data): string
    {
        $index = array_search($key, array_column($data, 'id'));

        if ($index !== false) {
            return $data[$index]['data'];
        }

        return '';
    }
}
