@extends('layouts.app')
@section('title','Notices')
<x-navbar/>
@section('content')
<x-sidebar/>

<div class="container mt-4 mb-5">

    {{-- 🔹 Page Header and Controls --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        {{-- LEFT SIDE: Title --}}
        <div class="mb-3 mb-md-0">
            <h3 class="fw-bolder text-dark mb-1">
                <i class="bi bi-megaphone-fill text-primary me-2"></i> System Notices
            </h3>
            <p class="text-muted small mb-0">Manage and review all operational announcements and their targeted scope.</p>
        </div>


        {{-- RIGHT SIDE: Search and Action Buttons --}}
        <div class="d-flex gap-3 align-items-center flex-wrap">
            
            {{-- 🔹 Enhanced Search Bar --}}
            <div class="input-group" style="max-width: 250px;">
                <span class="input-group-text bg-white border-end-0 text-muted" style="border-radius: 20px 0 0 20px;">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" id="searchNotice" class="form-control shadow-sm border-start-0" 
                    placeholder="Search by title..." 
                    style="border-radius: 0 20px 20px 0;">
            </div>

            {{-- 🔹 Create Button --}}
            <a href="{{ route('notices.create') }}" class="btn btn-primary shadow fw-bold rounded-pill px-3">
                <i class="bi bi-plus-lg me-1"></i> Create Notice
            </a>
        </div>
    </div>
    
    {{-- 🔹 Success Alert --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3 border-0" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- 🔹 Notices Table --}}
    <div id="noticeTable">
        @include('notices.partials.table', ['notices' => $notices])
    </div>


</div>

{{-- 🔹 Simple Scope Toggle Script --}}
@push('scripts')
<script>
$(document).ready(function () {

    /** 🔹 Scope Toggle (Show more / Show less) **/
    $(document).on('click', '.toggle-scope', function (e) {
        e.preventDefault();
        const wrapper = $(this).closest('.scope-wrapper');
        const hidden = wrapper.find('.scope-hidden');

        if (hidden.hasClass('d-none')) {
            hidden.removeClass('d-none');
            $(this).html('Show less <i class="bi bi-chevron-up"></i>');
        } else {
            hidden.addClass('d-none');
            $(this).html('Show more <i class="bi bi-chevron-down"></i>');
        }
    });

    /** 🔍 Live Search (by Title) **/
    $('#searchNotice').on('keyup', function () {
        const search = $(this).val();

        $.ajax({
            url: "{{ route('notices.index') }}",
            data: { search },
            beforeSend: function () {
                $('#noticeTable').html(
                    '<div class="text-center py-5 text-muted">' +
                    '<i class="bi bi-hourglass-split me-2"></i>Loading...' +
                    '</div>'
                );
            },
            success: function (data) {
                $('#noticeTable').html(data);
            },
            error: function () {
                $('#noticeTable').html(
                    '<div class="alert alert-danger text-center">' +
                    '<i class="bi bi-exclamation-triangle me-2"></i>Error loading data.' +
                    '</div>'
                );
            }
        });
    });

    /** 🔄 AJAX Pagination **/
    $(document).on('click', '#noticeTable .pagination a', function (e) {
        e.preventDefault();
        const url = $(this).attr('href');
        const search = $('#searchNotice').val();

        $.get(url, { search }, function (data) {
            $('#noticeTable').html(data);
        });
    });
});
</script>
@endpush

@endsection
