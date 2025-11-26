<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" class="flex items-center space-x-2 px-3 py-2 text-gray-700 hover:text-gray-900">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
        </svg>
        <span class="uppercase">{{ app()->getLocale() }}</span>
    </button>
    
    <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-32 bg-white rounded-md shadow-lg z-50">
        <a href="{{ route('language.switch', 'en') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ app()->getLocale() === 'en' ? 'bg-gray-100' : '' }}">
            English
        </a>
        <a href="{{ route('language.switch', 'es') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ app()->getLocale() === 'es' ? 'bg-gray-100' : '' }}">
            Español
        </a>
        <a href="{{ route('language.switch', 'fr') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ app()->getLocale() === 'fr' ? 'bg-gray-100' : '' }}">
            Français
        </a>
        <a href="{{ route('language.switch', 'de') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ app()->getLocale() === 'de' ? 'bg-gray-100' : '' }}">
            Deutsch
        </a>
    </div>
</div>

