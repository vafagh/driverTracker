<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Transaction extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [ 'table', 'row_id', 'action', 'last_data', 'new_data', 'columns', 'user_id' ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    static public function log($action,$last_data,$new_data){
        $transaction    = new Transaction;
        $transaction->table_name = str_plural(strtolower(class_basename($last_data)));
        ($last_data) ? $transaction->row_id = $last_data->id : $transaction->row_id = $new_data->id;
        $transaction->action    = explode('.',$action)[0];
        $transaction->last_data = $last_data;
        $transaction->new_data  = $new_data;
        // $transaction->columns= $columns;
        $transaction->user_id   = Auth::user()->id;
        $transaction->save();
    }
}
