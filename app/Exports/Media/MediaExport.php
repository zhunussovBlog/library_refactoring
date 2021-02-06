<?php


namespace App\Exports\Media;


use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MediaExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    const FULL_MEDIA_URI = '/full';
    private Collection $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    public function collection(): Collection
    {
        $url = url('/') . self::FULL_MEDIA_URI;
        return $this->data->map(function ($item) use ($url) {
            return ['authors' => $item->authors, 'type' => $item->type, 'title' => $item->title,
                'publisher' => $item->publisher, 'isbn' => $item->isbn, 'call_number' => $item->call_number,
                'url' => $url . "?type={$item->type_key}&id={$item->id}"];
        });
    }

    public function headings(): array
    {
        return [
            'Author(s)',
            'Type',
            'Title',
            'Publisher',
            'ISBN',
            'Call number',
            'URL to description'
        ];
    }
}
