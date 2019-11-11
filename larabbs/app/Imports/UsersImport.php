<?php

namespace App\Imports;

use App\Models\user;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new user([
            'name' => $row[1],
            'email' => $row[3],
            'password' => $row[4],
        ]);
    }
}
