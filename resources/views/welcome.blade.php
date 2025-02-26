
<x-guest-layout>
    @if (Route::has('login'))
        <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
            @auth
                <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>
                @if (Route::has('register'))
                <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
            @endif
            @endauth
        </div>
    @endif


    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-[1.2rem]">
        <a href="{{ route('agenda-saksi-perdata') }}" class="border px-2 py-4 btn font-bold btn btn-success">
            Agenda saksi perdata
        </a>
        <a href="{{ route('agenda-biasa') }}" class="border px-2 py-4 btn font-bold btn btn-success">
            Agenda biasa
        </a>
    </div>
            

</x-guest-layout>