<?php

namespace App\Http\Controllers\Api\Report\Barcode;

use App\Http\Controllers\Controller;
use App\Http\Requests\Report\Barcode\BarcodePrintRequest;
use App\Models\Acquisition\Item\Item;
use TCPDF;

class PrintController extends Controller
{
    public function __invoke(BarcodePrintRequest $request)
    {
        $validated = $request->validated();

        $barcodes = Item::barcodeQuery()->whereIn('i.inv_id', $validated['inventories'])->get()->toArray();

        $pdf = new TCPDF('landscape', PDF_UNIT,
            [81, 49], true, 'UTF-8', false);
        $pdf->setTitle('Barcodes');
        $pdf->setMargins(5, 5, 5);

        $style = [
            'position' => '',
            'align' => 'C',
            'stretch' => false,
            'fitwidth' => true,
            'cellfitalign' => '',
            'border' => false,
            'hpadding' => 'auto',
            'vpadding' => 'auto',
            'fgcolor' => array(0, 0, 0),
            'bgcolor' => false,
            'text' => true,
            'font' => 'helvetica',
            'fontsize' => 8,
            'stretchtext' => 4
        ];

        foreach ($barcodes as $barcode) {
            $title = $barcode['title'];
            $invId = $barcode['id'];
            $barcodeNo = $barcode['barcode'];

            if (strlen($title) > 30) {
                $title = mb_substr($title, 0, 30) . '...';
            }

            $pdf->addPage();
            $pdf->MultiCell(0, 0, $title);
            $pdf->write1DBarcode($barcodeNo, 'C39+', 30, 10, 35, 12, 1, $style, 'N');
            $pdf->Cell(0, 1, $invId);
            $pdf->endPage();
        }

        $pdf->Output('barcodes.pdf', 'D');
    }
}
