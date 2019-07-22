<?php namespace App\Repositories\Tables;

use App\Repositories\Tables\Table;
/**
 * Eloquent page repository
 *
 * @file PageRepository.php
 * @author Rajdeep Tarat <rajdeep.tarat@costprize.com>
 */
class TableRepository 
{

    /**
     * @var Page Model
     */
    protected $table;

    /**
     * @param Page $page
     */
    function __construct(Table $table)
    {
        $this->table = $table;
    }



    /**
     * Returns a list of all active pages
     *
     * @return mixed
     */
    public function all($search_text = "",$filter_state = "",$outlet_id = "")
    {
        $query = $this->table->where('state', '>','-2');
        if($search_text != ""){
            $query->where('table_name','LIKE','%'.$search_text.'%');

        }
        if($filter_state != ""){
            $query->where('state',$filter_state);

        }
        if($outlet_id != ""){
            $query->where('outlet_id',$outlet_id);

        }
        return $query->paginate(10);
    }

    public function store($data)
    {
        $result = $this->table->create(
            [
                'table_name' => $data['table_name'],
                'no_of_persons' => $data['no_of_persons'],
                'outlet_id' => $data['outlet'],
                'state' => $data['state'],
                'status' => "OPEN"
            ]
        );
        $result->touch();
        $result->save();

        return $result;
    }

    public function getTableDetails($id)
    {
        return $this->table->find($id);
    }

    public function update($data)
    {
        $table = $this->table->find($data['id']);
        $table->table_name = $data['table_name'];
        $table->no_of_persons = $data['no_of_persons'];
        $table->outlet_id = $data['outlet'];
        $table->state = $data['state'];
        $table->touch();
        $table->save();
        return $table;
    }

    public function updateState($id,$state)
    {
        return $this->table->where('id', $id)
                           ->update(['state' => $state]);
    } 

    public function batchDelete($table_ids)
    {
        return $this->table->whereIn('id', $table_ids)
                    ->update(['state' => '-2']);
    }

    public function getTablesInOutlet($outlet_id)
    {
        return $this->table->where('state', '1')
                             ->where('outlet_id',$outlet_id) 
                             ->get();   
    }

    
}
