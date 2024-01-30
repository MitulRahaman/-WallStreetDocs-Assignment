@extends('backend.layouts.master')
@section('page_action')
    <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-alt">
            <li class="breadcrumb-item"><a class="link-fx" href="{{ url('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a class="link-fx" href="#">Bank</a></li>
            <li class="breadcrumb-item">Add</li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="content">
    @include('backend.layouts.error_msg')
        <div class="block block-rounded block-content col-sm-6 ">
            <div class="block-header">
                <h3 class="block-title">Create a new Account</h3>
            </div>

            <form class="js-validation" action="{{ url('bank/store') }}" method="POST" id="form">
                @csrf
                <div class="block block-rounded">
                    <div class="block-content pb-6">
                        <div class="row items-push">
                            <div class="col-lg-12 col-xl-12">
                                <div class="form-group">
                                    <label for="val-type">Select Account Type<span class="text-danger">*</span></label>
                                    <select class="form-control" id="accountType" name="accountType" style="width: 100%" required>
                                        <option>current account</option>
                                        <option>saving account</option>
                                        <option>salary account</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="val-name">Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name.." required>
                                </div>
                                <div class="form-group">
                                    <label for="val-number">Account Number<span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="number" name="number" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="val-date">Creation Date<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="date" name="date" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="val-balance">Balance<span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="balance" name="balance" min="500" placeholder="Min Balance 500.." required>
                                </div>
                            </div>
                        </div>

                        <!-- Save -->
                        <div class="row items-push">
                            <div class="col-lg-6 offset-lg-5">
                                <button type="submit" class="btn btn-alt-primary" id="submit">Save</button>
                            </div>
                        </div>
                        <!-- END Save -->
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js_after')
    <script src="{{ asset('backend/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('backend/js/plugins/jquery-validation/additional-methods.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>

    <!-- Page JS Code -->
    <script src="{{ asset('backend/js/pages/be_forms_validation.min.js') }}"></script>
    <script>
        var rand = Math.floor(Math.random()*1000000000);
        document.getElementById('number').setAttribute('value', rand);

        var date = moment().format('D/MM/YYYY');
        document.getElementById('date').setAttribute('value', date);

    </script>
@endsection
