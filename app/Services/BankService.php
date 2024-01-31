<?php

namespace App\Services;

use App\Repositories\BankRepository;
use Illuminate\Support\Facades\Config;

class BankService
{
    private $branchRepository;

    public function __construct(BankRepository $bankRepository)
    {
        $this->bankRepository = $bankRepository;
    }

    public function store($data)
    {
        return $this->bankRepository->setaccountType($data['accountType'])
            ->setName($data['name'])
            ->setNumber($data['number'])
            ->setdate($data['date'])
            ->setBalance($data['balance'])
            ->setCreatedAt(date('Y-m-d H:i:s'))
            ->store();
    }

    public function edit($id)
    {
        return $this->bankRepository->setId($id)->edit();
    }

    public function update($data, $id)
    {
        return $this->bankRepository->setId($id)
            ->setName($data['name'])
            ->setUpdatedAt(date('Y-m-d H:i:s'))
            ->update();
    }

    public function updateOnDeposit($data)
    {
        $currentBalance = $this->bankRepository->setId($data['accountType'])->getBalance();
        $depositedBalance = (int)$data['amount'];
        $total = $currentBalance->balance + $depositedBalance;

        return $this->bankRepository->setId($data['accountType'])
            ->setBalance($total)
            ->setUpdatedAt(date('Y-m-d H:i:s'))
            ->updateOnDeposit();
    }

    public function updateOnWithdraw($data)
    {
        $currentBalance = $this->bankRepository->setId($data['accountType'])->getBalance();
        $withdrawnBalance = (int)$data['amount'];
        $total = $currentBalance->balance - $withdrawnBalance;
        if($total < 100) {
            return false;
        } else {
            return $this->bankRepository->setId($data['accountType'])
                ->setBalance($total)
                ->setUpdatedAt(date('Y-m-d H:i:s'))
                ->updateOnWithdraw();
        }
    }

    public function delete($id)
    {
        return $this->bankRepository->setId($id)->delete();
    }

    public function allAccounts()
    {
        return $this->bankRepository->allAccounts();
    }

    public function getBalance($data)
    {
        return $this->bankRepository->setId($data['accountType'])->getBalance();
    }

    public function getTableData()
    {
        $result = $this->bankRepository->getTableData();
        if ($result->count() > 0) {
            $data = array();
            foreach ($result as $key=>$row) {
                $id = $row->id;
                $accountType = $row->accountType;
                $name = $row->name;
                $account_number = $row->account_number;
                $date = date("d-m-Y", strtotime($row->date));
                $balance = $row->balance;

                $edit_url = url('bank/'.$id.'/edit');
                $edit_btn = "<li><a class=\"dropdown-item\" href=\"$edit_url\">Edit</a></li>";
                $delete_btn = "<li><a class=\"dropdown-item\" href=\"javascript:void(0)\" onclick='show_delete_modal(\"$id\", \"$name\")'>Delete</a></li>";
                $action_btn = "<div class=\"col-sm-6 col-xl-4\">
                <div class=\"dropdown\">
                    <button type=\"button\" class=\"btn btn-secondary dropdown-toggle\" id=\"dropdown-default-secondary\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                        Action
                    </button>
                    <div class=\"dropdown-menu font-size-sm\" aria-labelledby=\"dropdown-default-secondary\">
                    <ul style=\"max-height: 100px; overflow-x:hidden\">";
                $action_btn .="$edit_btn $delete_btn";
                $action_btn .= "</ul>
                                </div>
                            </div>
                        </div>";

                $temp = array();
                array_push($temp, $key+1);
                array_push($temp, $accountType);
                array_push($temp, $name);
                array_push($temp, $account_number);
                array_push($temp, $date);
                array_push($temp, $balance);
                array_push($temp, $action_btn);
                array_push($data, $temp);
            }
            return json_encode(array('data'=>$data));
        } else {
            return '{
                "sEcho": 1,
                "iTotalRecords": "0",
                "iTotalDisplayRecords": "0",
                "aaData": []
            }';
        }
    }

}
