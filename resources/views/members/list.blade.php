@extends('layouts.app')
@section('title','Members')
<x-navbar/>
@section('content')
<x-sidebar/>

<div class="container mt-3">

    {{-- 🔹 Header (Search + Add Button on Right) --}}
    <div class="d-flex justify-content-end align-items-center mb-3 flex-wrap gap-2">
        <input type="text" name="search" id="searchInput" 
               class="form-control" placeholder="Search name, phone, or email..."
               style="max-width: 250px;">

        @can('create member')
            <a href="{{ route('members.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Add Member
            </a>
        @endcan
    </div>

    @if(session('success')) 
        <div class="alert alert-success">{{ session('success') }}</div> 
    @endif

    {{-- 🔹 Table container for AJAX updates --}}
    <div id="memberTableContainer">
        @include('members.partials.table', ['members' => $members])
    </div>

</div>
@endsection

        

@push('scripts')
    <script>
        $(document).ready(function () {
            // Fetch members dynamically when searching
            $('#searchInput').on('keyup', function () {
                let query = $(this).val();
                fetchMembers(query);
            });

            // Handle pagination clicks via AJAX
            $(document).on('click', '.pagination a', function (e) {
                e.preventDefault();
                let url = $(this).attr('href');
                fetchMembers(null, url);
            });

            // Function to fetch and update the members table
            function fetchMembers(query = '', url = "{{ route('members.index') }}") {
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: { search: query },
                    success: function (response) {
                        $('#memberTableContainer').html(response);
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to load member data.'
                        });
                    }
                });
            }

            // ✅ SweetAlert confirmation for suspend/reactivate/delete buttons
            $(document).on('click', '.suspend-btn, .reactivate-btn, .btn-delete', function (e) {
                e.preventDefault();

                let form = $(this).closest('form');
                let msg, icon, confirmColor;

                if ($(this).hasClass('suspend-btn')) {
                    msg = "Suspend this member?";
                    icon = "warning";
                    confirmColor = "#d33";
                } else if ($(this).hasClass('reactivate-btn')) {
                    msg = "Reactivate this member?";
                    icon = "question";
                    confirmColor = "#28a745";
                } else {
                    msg = "Delete this member permanently?";
                    icon = "error";
                    confirmColor = "#e3342f";
                }

                Swal.fire({
                    title: msg,
                    icon: icon,
                    showCancelButton: true,
                    confirmButtonColor: confirmColor,
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, confirm!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
