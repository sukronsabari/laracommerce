@extends('layouts.base')

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900">
    <x-navigation.index />

    <!-- Page Content -->
    <main {{ $attributes->merge(["class" => "max-w-screen-xl px-2 sm:px-4 mx-auto pt-24 pb-14"]) }}>
        {{ $slot }}
    </main>
    <x-footer />
</div>
@endsection
