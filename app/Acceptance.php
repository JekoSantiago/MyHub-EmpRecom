<?php

namespace App;

use App\Helper\MyHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Acceptance extends Model
{
    public static function getPEAAcceptance($data)
    {
        return DB::select('sp_PEA_Acceptance_Get ' . MyHelper::generateQM($data), $data);
    }

    public static function getNPAAcceptance($data)
    {
        return DB::select('sp_NPA_Acceptance_Get ' . MyHelper::generateQM($data), $data);
    }

    public static function getNonRegAcceptance($data)
    {
        return DB::select('sp_NonRegLetter_Acceptance_Get ' . MyHelper::generateQM($data), $data);
    }

    public static function updateNonRegLetter($data)
    {
        return DB::select('sp_NonRegLetter_Approved_Update ' . MyHelper::generateQM($data), $data);
    }
}
