@extends('templates.main')

@section('title')
    Edit Reimbursement
@endsection

@section('body')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8">
                <div class="card card-primary mt-4">
                    <div class="card-header" style="background-color: maroon; color: #fff;">
                        <h3 class="card-title mb-0">Edit Reimbursement</h3>
                    </div>
                    <form action="{{ route('reimbursement.update', $reimbursement->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="form-row">
                                <div class="form-group col-12 col-md-6">
                                    <label>Name</label>
                                    <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label>Email</label>
                                    <input type="text" class="form-control" value="{{ Auth::user()->email }}" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Upload Proof</label>
                                <input type="file" name="proof" class="form-control-file" accept=".jpeg,.png,.jpg">
                                @if($reimbursement->proof)
                                    <div class="mt-2">
                                        <a href="{{ asset($reimbursement->proof) }}" data-toggle="lightbox" data-title="Proof"
                                            class="btn btn-sm btn-info">View Current Proof</a>
                                    </div>
                                @endif
                                <small class="form-text text-muted">*Upload proof as image (.jpeg, .png, .jpg). Leave blank
                                    to keep current proof.</small>
                            </div>

                            <div class="form-group">
                                <label>Expense List</label>
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0" id="expenseTable">
                                        <thead>
                                            <tr>
                                                <th style="min-width: 100px;">Date</th>
                                                <th style="min-width: 120px;">Description</th>
                                                <th style="min-width: 90px;">Amount</th>
                                                <th style="width: 40px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($details as $i => $detail)
                                                <tr>
                                                    <td>
                                                        <input type="date" name="expense_date[]" class="form-control"
                                                            value="{{ $detail->date }}" required>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="expense_description[]" class="form-control"
                                                            value="{{ $detail->description }}" required>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="expense_amount[]" class="form-control"
                                                            value="{{ $detail->money }}" required onkeyup="calculateTotal();">
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            onclick="delRow(this)"><i class="fa fa-minus"></i></button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2">
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        onclick="addRow()"><i class="fa fa-plus"></i> Add Row</button>
                                                </td>
                                                <td colspan="2">
                                                    <b>Total: <span id="total"></span></b>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fa fa-check-circle"></i>
                                Update
                            </button>
                            <a href="{{ route('reimbursement.index') }}" class="btn btn-secondary mt-2">
                                <i class="fa fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media (max-width: 576px) {
            .card {
                margin-top: 1rem !important;
            }

            .table-responsive {
                font-size: 13px;
            }

            .btn,
            input,
            select {
                font-size: 14px !important;
            }

            th,
            td {
                padding: 0.25rem !important;
            }

            .card-footer .btn {
                width: 100%;
                margin-bottom: 0.5rem;
            }
        }

        .btn-primary,
        .btn-primary:active,
        .btn-primary:focus,
        .btn-primary:hover {
            background-color: maroon !important;
            border-color: maroon !important;
            color: #fff !important;
        }

        .table thead {
            background-color: maroon !important;
            color: #fff !important;
        }
    </style>

    <script>
        function addRow() {
            var table = document.getElementById("expenseTable").getElementsByTagName('tbody')[0];
            var newRow = table.insertRow(table.rows.length);
            newRow.innerHTML =
                `<td><input type="date" name="expense_date[]" class="form-control" required></td>
                <td><input type="text" name="expense_description[]" class="form-control" required></td>
                <td><input type="number" name="expense_amount[]" class="form-control" required onkeyup="calculateTotal();"></td>
                <td><button type="button" class="btn btn-danger btn-sm" onclick="delRow(this)"><i class="fa fa-minus"></i></button></td>`;
        }

        function delRow(btn) {
            var row = btn.closest('tr');
            var table = row.closest('tbody');
            if (table.rows.length > 1) {
                row.remove();
                calculateTotal();
            }
        }

        function formatCurrency(amount) {
            if (!amount) return '';
            return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function calculateTotal() {
            let elements = document.getElementsByName('expense_amount[]');
            let totalElement = document.getElementById('total');
            let total = 0;
            elements.forEach((v) => {
                if (v.value) total += parseInt(v.value);
            });
            totalElement.innerHTML = formatCurrency(total);
        }

        document.addEventListener('DOMContentLoaded', function () {
            calculateTotal();
        });
    </script>
@endsection