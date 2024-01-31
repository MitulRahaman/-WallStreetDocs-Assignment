@extends('backend.layouts.master')
@section('page_action')
    <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-alt">
            <li class="breadcrumb-item"><a class="link-fx" href="{{ url('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a class="link-fx" href="#">Bank</a></li>
            <li class="breadcrumb-item">Withdraw</li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="content">
    @include('backend.layouts.error_msg')
        <div class="block block-rounded block-content col-sm-6 ">
            <div class="block-header">
                <h3 class="block-title">Withdraw Amount</h3>
            </div>

            <form class="js-validation" action="{{ url('bank/updateOnwithdraw') }}" method="POST" id="form">
                @csrf
                @method('patch')
                <div class="block block-rounded">
                    <div class="block-content pb-6">
                        <div class="row items-push">
                            <div class="col-lg-12 col-xl-12">
                                <div class="form-group">
                                    <label for="val-type">Select Your Account<span class="text-danger">*</span></label>
                                    <select class="form-control" id="accountType" name="accountType" style="width: 100%" required>
                                        <option></option>
                                        @forelse ($allAccounts as $account)
                                        <option value="{{ $account->id }}">{{ $account->accountType }} - {{ $account->name }} - {{ $account->account_number }}</option>
                                        @empty
                                        <p> </p>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="val-balance">Current Balance<span class="text-danger">*</span></label>
                                    <input type="balance" class="form-control" id="balance" name="balance" value="" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="val-amount">Amount<span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="amount" name="amount" placeholder="Withdrawn amount.." required>
                                </div>
                            </div>
                        </div>

                        <!-- Withdraw -->
                        <div class="row items-push">
                            <div class="col-lg-6 offset-lg-5">
                                <button type="submit" class="btn btn-alt-primary" id="submit">Withdraw</button>
                            </div>
                        </div>
                        <!-- END Withdraw -->
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js_after')
    <script src="{{ asset('backend/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('backend/js/plugins/jquery-validation/additional-methods.js') }}"></script>
    <script src="{{ asset('backend/js/pages/be_forms_validation.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>

    <script>
        $('#accountType').change(function() {
            let accountType = $('#accountType').val();
            $.ajax({
                type: 'POST',
                async:false,
                url: '{{ url("bank/getBalance") }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    accountType: accountType,
                },
                success: function(response) {
                    $("#balance").val(JSON.stringify(response.balance));
                },
            });
        });
    </script>
@endsection
