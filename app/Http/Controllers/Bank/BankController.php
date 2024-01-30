<?php

namespace App\Http\Controllers\Bank;

use Validator;
use App\Models\Bank;
use App\Http\Controllers\Controller;
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
        View::share('sub_menu', 'display');
        return view('backend.pages.bank.index');
    }

    public function create()
    {
        View::share('sub_menu', 'create');
        return view('backend.pages.bank.create');
    }

    public function store(Request $request)
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
        View::share('sub_menu', 'create');
        $account = $this->bankService->edit($id);
        return view('backend.pages.bank.edit', compact('account'));
    }

    public function update(Request $request, $id)
    {
        try {
            $this->bankService->update($request, $id);
            return redirect('bank/display')->with('success', 'Account updated successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
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
    public function deposit()
    {
        dd(1);
        return \view('backend.pages.branch.create');
    }
    public function withdraw()
    {
        dd(1);
        return \view('backend.pages.branch.create');
    }





    public function updatedata(Request $request)
    {
        try {
            return $this->branchService->updateInputs($request);
        } catch(\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
