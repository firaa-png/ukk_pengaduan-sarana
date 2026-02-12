<?php /** Generic footer component that delegates to role-specific footers */ ?>

@if(auth()->check())
    @if(View::exists('admin.components.footer'))
        @include('admin.components.footer')
    @else
        @includeWhen(View::exists('siswa.components.footer'), 'siswa.components.footer')
    @endif
@else
    @includeWhen(View::exists('siswa.components.footer'), 'siswa.components.footer')
@endif
