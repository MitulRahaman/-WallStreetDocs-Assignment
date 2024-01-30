<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Bank;

class BankRepository
{
    private $id, $accountType, $name, $number, $date, $balance;

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    public function setaccountType($accountType)
    {
        $this->accountType = $accountType;
        return $this;
    }
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }
    public function setdate($date)
    {
        $this->date = $date;
        return $this;
    }
    public function setBalance($balance)
    {
        $this->balance = $balance;
        return $this;
    }
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
        return $this;
    }
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
        return $this;
    }

    public function store()
    {
        $this->date = str_replace('/', '-', $this->date);
        return Bank::create([
            'accountType' => $this->accountType,
            'name' => $this->name,
            'account_number' => $this->number,
            'date' => date("Y/m/d", strtotime($this->date)),
            'balance' => $this->balance,
            'created_at' => $this->created_at
        ]);
    }

    public function delete()
    {
        return DB::table('banks')->where('id', $this->id)->delete();
    }

    public function getTableData()
    {
        return DB::table('banks')->get();
    }



    // public function editBranch($id)
    // {
    //     return Branch::find($id);
    // }

    // public function updateBranch($data, $id)
    // {
    //     $branch = Branch::find($id);
    //     return $branch->update($data->validated());
    // }




}
