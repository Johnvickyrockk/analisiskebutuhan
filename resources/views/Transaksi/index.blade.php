@extends('Layouts_new.index')

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Daftar Transaksi</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Transaksi</h6>
        </div>
        @if (session('error'))
            <div class="alert alert-light-danger alert-dismissible fade show" style="height: 50px" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-light-success alert-dismissible fade show" style="height: 50px" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card-body">
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ url('/dashboard/transaksi/create') }}" class="btn btn-primary" style="margin-right: 5px;">Tambah
                    Transaksi</a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="periodeTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Transaksi</th>
                            <th>Nama Customer</th>
                            <th>Kode Ticket Customer</th>
                            <th>Total Harga</th>
                            <th>Action</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus transaksi ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeModalFooter">Batal</button>
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var dataMaster = $('#periodeTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('transaksi.list') }}',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        _token: '{{ csrf_token() }}'
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'tanggal_transaksi',
                        name: 'tanggal_transaksi',
                    },
                    {
                        data: 'nama_customer',
                        name: 'nama_customer'
                    },
                    {
                        data: 'tracking_number',
                        name: 'tracking_number',
                    },
                    {
                        data: 'total_harga',
                        name: 'total_harga'
                    },
                    {
                        data: 'uuid',
                        name: 'uuid',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            let actionButtons = `
                                <a href="/dashboard/transaksi/show/${data}" class="btn icon btn-sm btn-info" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <button class="btn icon btn-sm btn-danger delete-btn" title="Hapus" data-id="${data}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            `;
                            return actionButtons;
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data, type, row) {
                            if (data === 'downpayment') {
                                return '<span class="badge bg-warning"><i class="fas fa-clock fa-sm"></i></span>';
                            } else if (data === 'paid') {
                                return '<span class="badge bg-success"><i class="fas fa-check-circle fa-sm"></i></span>';
                            } else {
                                return '<span class="badge bg-secondary"><i class="fas fa-question-circle fa-sm"></i></span>';
                            }
                        }
                    }
                ],
                autoWidth: false,
                drawCallback: function(settings) {
                    $('a').tooltip();
                }
            });

            // Handle delete button click
            $('#periodeTable').on('click', '.delete-btn', function() {
                var uuid = $(this).data('id');
                $('#deleteForm').attr('action', `/dashboard/transaksi/delete/${uuid}`);
                $('#deleteConfirmationModal').modal('show');
            });

            // Handle modal close
            $('#closeModalHeader, #closeModalFooter, .close').on('click', function() {
                $('#deleteConfirmationModal').modal('hide');
            });
        });
    </script>
@endsection