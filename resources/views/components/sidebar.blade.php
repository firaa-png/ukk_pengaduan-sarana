<?php /**
 * Generic sidebar component. Prefer admin sidebar when the authenticated user
 * is an admin (auth()->check()), otherwise fall back to siswa sidebar.
 * This lets existing <x-sidebar /> usages keep working while we keep role
 * specific sidebars in their own folders.
 */ ?>

@if(auth()->check())
    {{-- If admin is logged in, include the admin sidebar if it exists --}}
    @if(View::exists('admin.components.sidebar'))
        @include('admin.components.sidebar')
    @else
        {{-- Fallback to siswa sidebar if admin-specific not found --}}
        @includeWhen(View::exists('siswa.components.sidebar'), 'siswa.components.sidebar')
    @endif
@else
    {{-- Not an authenticated admin user: use siswa sidebar when available --}}
    @includeWhen(View::exists('siswa.components.sidebar'), 'siswa.components.sidebar')
@endif
