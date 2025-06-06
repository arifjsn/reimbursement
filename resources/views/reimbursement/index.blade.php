@extends('templates.main')

@section('title')
    My Reimbursements
@endsection

@section('body')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8">
                <div class="card mt-4">
                    <div class="card-header" style="background-color: maroon; color: #fff;">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <h3 class="card-title mb-0">My Reimbursements</h3>
                            <div class="ml-auto">
                                <button class="btn btn-primary" style="background-color: maroon; border-color: maroon;"
                                    data-toggle="modal" data-target="#addReimbursementModal">
                                    <i class="fa fa-plus"></i> Add Reimbursement
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead style="background-color: maroon; color: #fff;">
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Proof</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($reimbursements as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                            <td>
                                                <span
                                                    class="badge badge-{{ $item->status == 'requested' ? 'warning' : ($item->status == 'claimed' ? 'success' : 'danger') }}">
                                                    {{ ucfirst($item->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($item->proof)
                                                    <a href="{{ asset($item->proof) }}" data-toggle="lightbox" data-title="Proof"
                                                        class="btn btn-sm btn-info">
                                                        View
                                                    </a>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                Rp {{ number_format($item->details->sum('money'), 0, ',', '.') }}
                                            </td>
                                            <td>
                                                <a href="{{ route('reimbursement.detail', $item->id) }}"
                                                    class="btn btn-sm btn-primary" title="Detail"><i class="fa fa-eye"></i></a>
                                                <a href="{{ route('reimbursement.edit', $item->id) }}"
                                                    class="btn btn-sm btn-warning" title="Edit"><i class="fa fa-edit"></i></a>
                                                <button type="button" class="btn btn-sm btn-danger" title="Delete"
                                                    onclick="confirmDelete({{ $item->id }})"><i
                                                        class="fa fa-trash"></i></button>
                                                <form id="delete-form-{{ $item->id }}"
                                                    action="{{ route('reimbursement.destroy', $item->id) }}" method="POST"
                                                    style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">No reimbursement data.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        {{ $reimbursements->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Reimbursement -->
    <div class="modal fade" id="addReimbursementModal" tabindex="-1" role="dialog"
        aria-labelledby="addReimbursementModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="{{ route('reimbursement.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header" style="background-color: maroon; color: #fff;">
                        <h5 class="modal-title" id="addReimbursementModalLabel">Add Reimbursement</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
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
                            <small class="form-text text-muted">*Upload proof as image (.jpeg, .png, .jpg). Leave blank if
                                not available.</small>
                        </div>
                        <div class="form-group">
                            <label>Expense List</label>
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0" id="modalExpenseTable"
                                    style="border-color: maroon;">
                                    <thead style="background-color: maroon; color: #fff;">
                                        <tr>
                                            <th style="min-width: 100px;">Date</th>
                                            <th style="min-width: 120px;">Description</th>
                                            <th style="min-width: 90px;">Amount</th>
                                            <th style="width: 40px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="date" name="expense_date[]" class="form-control" required>
                                            </td>
                                            <td>
                                                <input type="text" name="expense_description[]" class="form-control"
                                                    required>
                                            </td>
                                            <td>
                                                <input type="number" name="expense_amount[]" class="form-control" required
                                                    onkeyup="calculateModalTotal();">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="delModalRow(this)"><i class="fa fa-minus"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="addModalRow()"><i class="fa fa-plus"></i> Add Row</button>
                                            </td>
                                            <td colspan="2">
                                                <b>Total: <span id="modalTotal"></span></b>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-check-circle"></i> Submit
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fa fa-times"></i> Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
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
        // Modal expense table functions
        function addModalRow() {
            var table = document.getElementById("modalExpenseTable").getElementsByTagName('tbody')[0];
            var newRow = table.insertRow(table.rows.length);
            newRow.innerHTML =
                `<td><input type="date" name="expense_date[]" class="form-control" required></td>
                                        <td><input type="text" name="expense_description[]" class="form-control" required></td>
                                        <td><input type="number" name="expense_amount[]" class="form-control" required onkeyup="calculateModalTotal();"></td>
                                        <td><button type="button" class="btn btn-danger btn-sm" onclick="delModalRow(this)"><i class="fa fa-minus"></i></button></td>`;
        }

        function delModalRow(btn) {
            var row = btn.closest('tr');
            var table = row.closest('tbody');
            if (table.rows.length > 1) {
                row.remove();
                calculateModalTotal();
            }
        }

        function formatCurrency(amount) {
            if (!amount) return '';
            return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function calculateModalTotal() {
            let elements = document.querySelectorAll('#modalExpenseTable input[name="expense_amount[]"]');
            let totalElement = document.getElementById('modalTotal');
            let total = 0;
            elements.forEach((v) => {
                if (v.value) total += parseInt(v.value);
            });
            totalElement.innerHTML = formatCurrency(total);
        }

        // Reset modal form on close
        $('#addReimbursementModal').on('hidden.bs.modal', function () {
            $(this).find('form')[0].reset();
            // Remove extra rows except the first
            let tbody = document.querySelector('#modalExpenseTable tbody');
            while (tbody.rows.length > 1) {
                tbody.deleteRow(1);
            }
            calculateModalTotal();
        });

        document.addEventListener('DOMContentLoaded', function () {
            calculateModalTotal();
        });
    </script>

    @push('scripts')
        <script>
            function confirmDelete(id) {
                Swal.fire({
                    title: 'Delete this reimbursement?',
                    text: "This action cannot be undone.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#aaa',
                    confirmButtonText: 'Yes, Delete',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form-' + id).submit();
                    }
                });
            }

            // Toast for success message
            @if(session('success'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true
                });
            @endif

            // Toast for error message
            @if(session('error'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true
                });
            @endif
        </script>
    @endpush
@endsection