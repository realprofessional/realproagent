<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;



class Board extends Model{

	//use  RemindableTrait, SortableTrait;
         
    use  Sortable;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'boards';


}
