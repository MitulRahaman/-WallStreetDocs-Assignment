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
        View::share('sub_menu', 'Branches');
    }

    public function create()
    {
        dd(1);
        return \view('backend.pages.branch.create');
    }
    public function display()
    {
        dd(1);
        return \view('backend.pages.branch.create');
    }
    public function delete()
    {
        dd(1);
        return \view('backend.pages.branch.create');
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
    public function search()
    {
        dd(1);
        return \view('backend.pages.branch.create');
    }

    public function store(BranchAddRequest $request)
    {
        try {
            if(!is_object($this->branchService->storeBranch($request)))
                return redirect('branch')->with('error', 'Failed to add branch');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
        return redirect('branch')->with('success', 'Branch added successfully');
    }

    public function edit($id)
    {
        dd(1);
        try {
            $data = $this->branchService->editBranch($id);
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
        return \view('backend.pages.branch.edit', compact('data'));
    }

    public function update(BranchUpdateRequest $request, $id)
    {
        dd(1);
        try {
            if(!$this->branchService->updateBranch($request, $id))
                return redirect('branch')->with('error', 'Failed to update branch');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
        return redirect('/branch')->with('success', 'Branch updated successfully');
    }

    public function status($id)
    {
        try {
            $this->branchService->updateStatus($id);
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'You need to restore the branch first');
        }
        return redirect()->back()->with('success', 'Status has been changed');
    }

    public function destroy($id)
    {
        try {
            $this->branchService->destroyBranch($id);
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
        return redirect()->back()->with('success', 'Branch deleted successfully');
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
