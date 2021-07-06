<?php

namespace App\Imports;

use App\Models\Client;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ClientsImport implements ToModel, WithValidation, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Client([
            'client_id' => $row['nomor_pelanggan'],
            'name' => $row['nama'],
            'rt' => $row['rt'],
            'rw' => $row['rw']
        ]);
    }

    public function rules(): array
    {
        return [
            'nomor_pelanggan' => ['required', Rule::unique('clients', 'client_id')],
            'nama' => ['required'],
            'rt' => ['required'],
            'rw' => ['required'],
        ];
    }
}
