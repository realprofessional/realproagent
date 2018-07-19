<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;



class Project extends Model{

	//use  RemindableTrait, SortableTrait;
         
    use  Sortable;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'projects';        
        
//        public function users()
//    {
//        return $this->belongsTo('User');
//    }


}
