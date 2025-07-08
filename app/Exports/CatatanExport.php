<?php
namespace App\Exports;

use App\Models\Catatan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CatatanExport implements FromCollection
{
public function collection()
{
return Catatan::all();
}

}