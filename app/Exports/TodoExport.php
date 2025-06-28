<?php

namespace App\Exports;

use App\Models\Catatan;
use Maatwebsite\Excel\Concerns\FromCollection;

class CatatanExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Catatan::all();
    }
}