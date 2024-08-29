@extends("layouts.base")

@section('content')
<div class="bg-gray-50 dark:bg-gray-800">
    <x-navigation.index />
    <div class="flex pt-16 overflow-hidden bg-gray-50 dark:bg-gray-900">

        <x-sidebar.index />
        <div class="fixed inset-0 z-10 hidden bg-gray-900/50 dark:bg-gray-900/90" id="sidebarBackdrop"></div>

        <main class="relative w-full h-full min-h-screen overflow-y-auto bg-gray-50 lg:ml-64 dark:bg-gray-900">
            {{ $slot }}
        </main>
    </div>
</div>
@endsection
