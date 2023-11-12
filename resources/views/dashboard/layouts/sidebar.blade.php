<!-- Desktop sidebar -->
<aside class="z-20 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0">
    <div class="py-4 text-gray-500 dark:text-gray-400">
        <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200 font-lato" href="#">
            Sentiment Analysis
        </a>
        <ul class="mt-6">
            <li class="relative px-6 py-3">
                @if (Request::is('dashboard'))
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ Request::is('dashboard') ? 'font-semibold text-purple-600 dark:text-purple-300' : 'text-gray-500 dark:text-gray-100' }} inline-flex items-center w-full text-sm transition-colors duration-150 hover:text-purple-600 dark:hover:text-purple-300" href="{{ route('dashboard') }}">
                    <i class="ri-home-4-line text-lg"></i>
                    <span class="ml-4">Dashboard</span>
                </a>
            </li>
        </ul>
        <ul>
            {{-- Data Master --}}
            <li class="w-full mt-6">
                <h6 class="pl-6 font-bold leading-tight uppercase text-xs opacity-60">Master</h6>
            </li>
            <li class="relative px-6 pt-3">
                @if (Request::is('dashboard/resource'))
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ Request::is('dashboard/resource') ? 'font-semibold text-purple-600 dark:text-purple-300' : 'text-gray-500 dark:text-gray-100' }} inline-flex items-center w-full text-sm transition-colors duration-150 hover:text-purple-600 dark:hover:text-purple-300" href="{{ route('resource.index') }}">
                    <i class="ri-table-line text-lg"></i>
                    <span class="ml-4">Resource</span>
                </a>
            </li>
            <li class="relative px-6 pt-3">
                @if (Request::is('dashboard/preprocessing'))
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ Request::is('dashboard/preprocessing') ? 'font-semibold text-purple-600 dark:text-purple-300' : 'text-gray-500 dark:text-gray-100' }} inline-flex items-center w-full text-sm transition-colors duration-150 hover:text-purple-600 dark:hover:text-purple-300" href="{{ route('preprocessing.index') }}">
                    <i class="ri-code-line text-lg"></i>
                    <span class="ml-4">Preprocessing</span>
                </a>
            </li>
            <li class="relative px-6 pt-3">
                @if (Request::is('dashboard/sentimentAnalysis'))
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ Request::is('dashboard/sentimentAnalysis') ? 'font-semibold text-purple-600 dark:text-purple-300' : 'text-gray-500 dark:text-gray-100' }} inline-flex items-center w-full text-sm transition-colors duration-150 hover:text-purple-600 dark:hover:text-purple-300" href="{{ route('sentimentAnalysis.index') }}">
                    <i class="ri-search-eye-line text-lg"></i>
                    <span class="ml-4">Sentiment Analysis</span>
                </a>
            </li>
            <li class="relative px-6 pt-3">
                @if (Request::is('dashboard/vectorizer'))
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ Request::is('dashboard/vectorizer') ? 'font-semibold text-purple-600 dark:text-purple-300' : 'text-gray-500 dark:text-gray-100' }} inline-flex items-center w-full text-sm transition-colors duration-150 hover:text-purple-600 dark:hover:text-purple-300" href="{{ route('vectorizer.index') }}">
                    <i class="ri-command-line text-lg"></i>
                    <span class="ml-4">Vectorizer</span>
                </a>
            </li>
        </ul>
    </div>
</aside>

<!-- Mobile sidebar -->
<div x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center">
</div>
<aside class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-16 overflow-y-auto bg-white dark:bg-gray-800 md:hidden" x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150" x-transition:enter-start="opacity-0 transform -translate-x-20" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 transform -translate-x-20" @click.away="closeSideMenu" @keydown.escape="closeSideMenu">
    <div class="py-4 text-gray-500 dark:text-gray-400">
        <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200 font-lato" href="{{ route('dashboard') }}">
            Sentiment Analysis
        </a>
        <ul class="mt-6">
            <li class="relative px-6 py-3">
                @if (Request::is('dashboard'))
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ Request::is('dashboard') ? 'font-semibold text-purple-600 dark:text-purple-300' : 'text-gray-500 dark:text-gray-100' }} inline-flex items-center w-full text-sm transition-colors duration-150 hover:text-purple-600 dark:hover:text-purple-300" href="{{ route('dashboard') }}">
                    <i class="ri-home-4-line text-lg"></i>
                    <span class="ml-4">Dashboard</span>
                </a>
            </li>
        </ul>
        <ul>
            {{-- Data Master --}}
            <li class="w-full mt-6">
                <h6 class="pl-6 font-bold leading-tight uppercase text-xs opacity-60">Master</h6>
            </li>
            <li class="relative px-6 pt-3">
                @if (Request::is('dashboard/resource'))
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ Request::is('dashboard/resource') ? 'font-semibold text-purple-600 dark:text-purple-300' : 'text-gray-500 dark:text-gray-100' }} inline-flex items-center w-full text-sm transition-colors duration-150 hover:text-purple-600 dark:hover:text-purple-300" href="{{ route('resource.index') }}">
                    <i class="ri-table-line text-lg"></i>
                    <span class="ml-4">Resource</span>
                </a>
            </li>
            <li class="relative px-6 pt-3">
                @if (Request::is('dashboard/preprocessing'))
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ Request::is('dashboard/preprocessing') ? 'font-semibold text-purple-600 dark:text-purple-300' : 'text-gray-500 dark:text-gray-100' }} inline-flex items-center w-full text-sm transition-colors duration-150 hover:text-purple-600 dark:hover:text-purple-300" href="{{ route('preprocessing.index') }}">
                    <i class="ri-code-line text-lg"></i>
                    <span class="ml-4">Preprocessing</span>
                </a>
            </li>
            <li class="relative px-6 pt-3">
                @if (Request::is('dashboard/sentimentAnalysis'))
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ Request::is('dashboard/sentimentAnalysis') ? 'font-semibold text-purple-600 dark:text-purple-300' : 'text-gray-500 dark:text-gray-100' }} inline-flex items-center w-full text-sm transition-colors duration-150 hover:text-purple-600 dark:hover:text-purple-300" href="{{ route('sentimentAnalysis.index') }}">
                    <i class="ri-search-eye-line text-lg"></i>
                    <span class="ml-4">Sentiment Analysis</span>
                </a>
            </li>
            <li class="relative px-6 pt-3">
                @if (Request::is('dashboard/vectorizer'))
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ Request::is('dashboard/vectorizer') ? 'font-semibold text-purple-600 dark:text-purple-300' : 'text-gray-500 dark:text-gray-100' }} inline-flex items-center w-full text-sm transition-colors duration-150 hover:text-purple-600 dark:hover:text-purple-300" href="{{ route('vectorizer.index') }}">
                    <i class="ri-command-line text-lg"></i>
                    <span class="ml-4">Vectorizer</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
