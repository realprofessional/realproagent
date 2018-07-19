<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

use Kyslik\ColumnSortable\Sortable;

class Notification extends Model {

    use Sortable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notifications';
    
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
}
