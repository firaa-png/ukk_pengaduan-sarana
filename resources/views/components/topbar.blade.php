<?php /**
 * Generic topbar component. Delegates to admin topbar when an admin user is
 * authenticated and that view exists, otherwise includes the siswa topbar.
 */ ?>

@if(auth()->check())
    @if(View::exists('admin.components.topbar'))
        @include('admin.components.topbar')
    @else
        @includeWhen(View::exists('siswa.components.topbar'), 'siswa.components.topbar')
    @endif
@else
    @includeWhen(View::exists('siswa.components.topbar'), 'siswa.components.topbar')
@endif
