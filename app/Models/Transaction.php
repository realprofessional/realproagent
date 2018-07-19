<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

use Kyslik\ColumnSortable\Sortable;

class Transaction extends Model {

    use Sortable;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'transactions';
    

}
