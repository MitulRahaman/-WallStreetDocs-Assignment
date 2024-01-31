<?php

namespace App\Http\Controllers\Bank;

use Validator;
use App\Models\Bank;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccountAddRequest;
use App\Http\Requests\AccountUpdateRequest;
use App\Services\BankService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class BankController extends Controller
{
    private $bankService;

    public function __construct(BankService $bankService)
    {
        $this->bankService = $bankService;
        View::share('main_menu', 'System Settings');
    }

    public function getTableData()
    {
        try {
            return $this->bankService->getTableData();
        } catch (Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function display()
    {
        View::share('sub_menu', 'Display');
        return view('backend.pages.bank.index');
    }

    public function create()
    {
        View::share('sub_menu', 'Create');
        return view('backend.pages.bank.create');
    }

    public function store(AccountAddRequest $request)
    {
        try {
            if(is_object($this->bankService->store($request)))
            return redirect('bank/display')->with('success', 'Account created successfully');
        } catch (Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function edit($id)
    {
        View::share('sub_menu', 'Create');
        $account = $this->bankService->edit($id);
        return view('backend.pages.bank.edit', compact('account'));
    }

    public function update(AccountUpdateRequest $request, $id)
    {
        try {
            $this->bankService->update($request, $id);
            return redirect('bank/display')->with('success', 'Account updated successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function deposit()
    {
        $allAccounts = $this->bankService->allAccounts();
        View::share('sub_menu', 'Deposit');
        return view('backend.pages.bank.deposite', compact('allAccounts'));
    }

    public function updateOnDeposit(Request $request)
    {
        try {
            $this->bankService->updateOnDeposit($request);
            return redirect('bank/display')->with('success', 'Deposited successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function withdraw()
    {
        $allAccounts = $this->bankService->allAccounts();
        View::share('sub_menu', 'Withdraw');
        return view('backend.pages.bank.withdraw', compact('allAccounts'));
    }

    public function updateOnWithdraw(Request $request)
    {
        try {
            if(!$this->bankService->updateOnWithdraw($request)) {
                return redirect()->back()->with('error', 'Need to keep minimum account balance tk 100 for withdrawing');
            }
            return redirect('bank/display')->with('success', 'Withdrawn successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function getBalance(Request $request)
    {
        return $this->bankService->getBalance($request);
    }

    public function delete($id)
    {
        try{
            if($this->bankService->delete($id))
                return redirect('bank/display')->with('success', 'Account deleted successfully');
        } catch (Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
