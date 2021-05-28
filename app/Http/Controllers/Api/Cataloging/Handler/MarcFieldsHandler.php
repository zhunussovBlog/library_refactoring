<?php


namespace App\Http\Controllers\Api\Cataloging\Handler;

use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\ArrayShape;
use stdClass;

/**
 * Class MarcFieldsHandler
 */
final class MarcFieldsHandler
{
    private const MARC_FIELDS_COLUMNS = [
        'ID',
        'PID',
        'FIELD_CODE',
        'IND1',
        'IND2',
        'TITLE',
        'DATA',
        'ADD',
        'DELETE',
        'REPEATABLE'
    ];

    /**
     * @var array
     */
    private array $template;

    /**
     * MarcFieldsHandler constructor.
     * @param array $template
     * @param array $input
     */
    public function __construct(array $template = [], array $input = [])
    {
        $this->template = $this->generateTemplate($template, $input);
    }

    /**
     * @return array
     */
    public function getTemplate(): array
    {
        return $this->template;
    }

    /**
     * @param array $template
     * @param array $input
     * @return array
     */
    #[ArrayShape(['Columns' => "mixed", 'Nodes' => "mixed"])]
    private function generateTemplate(array $template = [], array $input = []): array
    {
        $marcFields = !empty($template) ? $template : self::getMarcFields();

        return [
            'Columns' => $this->generateColumns(),
            'Nodes' => $this->generateNodes($marcFields, $input),
        ];
    }

    /**
     * @return array
     */
    private function generateColumns(): array
    {
        $columns = [];
        foreach (self::MARC_FIELDS_COLUMNS as $i => $column) {
            $columns["__custom:Column:$i"] = [
                'ColumnName' => $column,
                'ColumnType' => 'Bound'
            ];
        }

        return $columns;
    }

    /**
     * @param array $template
     * @param array $input
     * @return array
     */
    private function generateNodes(array $template, array $input = []): array
    {
        $nodes = [];
        $id = -1;
        $lastParentId = -1;

        foreach ($template as $field) {
            $id++;

            if ($field instanceof stdClass)  {
                $field = json_decode(json_encode($field), true);
            }

            $lastParentId = $field['pid'] ? $lastParentId === -1 ? ($id - 1) : $lastParentId : -1;

            $fieldData = $field['data'];
            $index = array_search($field['id'], array_column($input, 'id'));

            if ($index !== false) {
                if ($input[$index] instanceof stdClass)  {
                    $input[$index] = json_decode(json_encode($input[$index]), true);
                }

                $fieldData = $input[$index]['data'];
            }

            $cells = [
                $this->generateCell($field['id']),
                $this->generateCell($field['pid'], 2),
                $this->generateCell($field['field_code'], 3),
                $this->generateCell($field['ind1'], 4),
                $this->generateCell($field['ind2'], 5),
                $this->generateCell($field['title'], 6),
                $this->generateCell($fieldData, 7),
                $this->generateCell(null, 8),
                $this->generateCell(null, 9),
                $this->generateCell($field['repeatable'], 10, true),
            ];

            $nodeData = [];

            foreach ($cells as $cell) {
                $nodeData[$cell['key']] = $cell['value'];
            }

            $count = $id + 1;

            $nodes["__custom:Node:$count"] = [
                '_attributes' => [
                    'Id' => $id,
                    'ParentId' => $lastParentId
                ],
                'NodeData' => $nodeData
            ];
        }

        return $nodes;
    }

    /**
     * @param string|null $value
     * @param int $count
     * @param bool $isNumeric
     * @return array
     */
    private function generateCell(?string $value, int $count = 1, bool $isNumeric = false): array
    {
        $cell = [];
        $cell['key'] = "__custom:Cell:$count";

        if ($isNumeric || !empty($value)) {
            if ($isNumeric) {
                $cell['value'] = [
                    '_attributes' => [
                        'xsi:type' => 'decimal'
                    ],
                    '_value' => $value
                ];
            } else {
                $cell['value'] = [
                    '_attributes' => [
                        'xsi:type' => 'string'
                    ],
                    '_value' => $value
                ];
            }

            return $cell;
        }

        $cell['value'] = [
            '_attributes' => [
                'xsi:nil' => 'true'
            ],
            '_value' => ''
        ];

        return $cell;
    }

    /**
     * @return array
     */
    private static function getMarcFields(): array
    {
        return DB::table('marc_fields')->select()->get()->toArray();
    }

    /**
     * @param array $input
     * @return array
     */
    public static function generateArray(array $input = []): array
    {
        $marcFields = self::getMarcFields();

        foreach ($marcFields as &$field) {
            $field = json_decode(json_encode($field), true);
            $index = array_search($field['id'], array_column($input, 'id'));
            if ($index !== false) {
                if ($input[$index] instanceof stdClass)  {
                    $input[$index] = json_decode(json_encode($input[$index]), true);
                }
                $field['data'] = $input[$index]['data'];
            }
        }

        return $marcFields;
    }
}
