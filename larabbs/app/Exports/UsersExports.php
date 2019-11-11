<?php

namespace App\Exports;

use App\models\user;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExports implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return user::all();
    }
}
