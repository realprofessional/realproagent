<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

use Kyslik\ColumnSortable\Sortable;

class User extends Model {

    use Sortable;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password', 'remember_token');

}
