<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Msds extends Model
{
    protected $fillable = [
        'departement_id',
        'chemical_common_name',
        'trade_name',
        'hsno_class',
        'sds_issue_date',
        'expired_date',
        'un_number',
        'cas_number',
        'chemical_supplier',
        'quantity_volume',
        'concentration',
        'packaging_size',
        'type_of_container',
        'location_of_chemical',
        'bulk_storage_tank',
        'signage_in_place',
        'bund_capacity',
        'bunding_material',
        'comments_other',
        'path_pdf',
        'signage_doc',
        'active_status'
    ];
}
