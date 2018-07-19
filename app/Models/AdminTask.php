<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class AdminTask extends Model{

//use  RemindableTrait, SortableTrait;

use Sortable;
/**
 * The database table used by the model.
 *
 * @var string
 */
protected $table = 'admintasks';

//public function adminboard() {
//    return $this->belongsTo('AdminBoard');
//}

}
