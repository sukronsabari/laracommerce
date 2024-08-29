@props(['withIcon' => false, 'icon' => '', 'text' => '', 'href'])

@if (!$withIcon)
    <a {{ $attributes->merge(["class" => "text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300
        font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none
        dark:focus:ring-blue-800"]) }} href="{{ $href }}"

    >
        {{ $text ?? $slot }}
    </a>
@else
    <a {{ $attributes->merge(["class" => "text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"]) }} href="{{ $href }}">
        <span class="flex items-center justify-center w-5 h-5 me-2">
            <i class="{{ $icon }}"></i>
        </span>
        {{ $text ?? $slot }}
    </a>
@endif
