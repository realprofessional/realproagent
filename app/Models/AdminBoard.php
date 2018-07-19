<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;



class AdminBoard extends Model{

	//use  RemindableTrait, SortableTrait;
         
    use  Sortable;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'adminboards';
        
        
//        public function admintasks()
//    {
//        return $this->hasMany('AdminTask');
//    }


}
