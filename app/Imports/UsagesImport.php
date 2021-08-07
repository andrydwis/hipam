<?php

namespace App\Imports;

use App\Models\Client;
use App\Models\Usage;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UsagesImport implements ToModel, WithValidation, WithHeadingRow
{
    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $client = Client::where('client_id', $row['nomor_pelanggan'])->first();

        if ($client) {
            return new Usage([
                'client_id' => $client->id,
                'meter_cubic' => $row['meter_kubik'],
                'month' => $this->month,
                'year' => $this->year
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'nomor_pelanggan' => ['required'],
            'meter_kubik' => ['required'],
        ];
    }
}
