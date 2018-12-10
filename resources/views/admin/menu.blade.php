<div class="px-16 py-2 shadow bg-primary border-tertiary border-t-4">
  <nav class="flex items-center justify-between flex-wrap">
    <a class="no-underline flex items-center text-soft-black" href="/admin">
      <img src="{{ asset('images/favicon.png') }}" class="fill-current h-16 w-16 mr-2" alt="Logo">
      <span class="font-semibold font-sans text-xl">Dashboard</span>
    </a>

    <div class="block w-full flex-grow sm:flex sm:items-center sm:w-auto">
      <div class="text-sm sm:flex-grow"></div>
      <div class="sm:inline-flex sm:items-center">
        <a href="/admin/categorias" class="mx-2 no-underline font-sans text-grey-darker border-b-2 border-transparent hover:border-tertiary hover:text-black">
          Categorías
        </a>
        <a href="/admin/productos" class="mx-2 no-underline font-sans text-grey-darker border-b-2 border-transparent hover:border-tertiary hover:text-black">
          Productos
        </a>

        @guest
            <a href="{{ route('login') }}" class="mx-2 no-underline font-sans text-grey-darker border-b-2 border-transparent hover:border-tertiary hover:text-black">
                {{ __('Iniciar Sesión') }}
            </a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="mx-2 no-underline font-sans text-grey-darker border-b-2 border-transparent hover:border-tertiary hover:text-black">
                    {{ __('Regístrarse') }}
                </a>
            @endif
        @else

            <div class="dropdown">
                <div class="leading-none bg-secondary-lighter hover:shadow-md hover:border-grey-darker border p-1 rounded border-soft-black">
                    <div class="inline-flex">
                        <img class="inline-block w-8 h-8" src="{{ Auth::user()->url_foto }}" alt="Avatar de {{ Auth::user()->name }}">
                        <div class="block flex items-center ml-2">
                            <span class="mr-1 font-semibold text-sm text-black">{{ Auth::user()->name }}</span>
                            <div>
                                <svg class="fill-current text-black h-4 w-4 block opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M4.516 7.548c.436-.446 1.043-.481 1.576 0L10 11.295l3.908-3.747c.533-.481 1.141-.446 1.574 0 .436.445.408 1.197 0 1.615-.406.418-4.695 4.502-4.695 4.502a1.095 1.095 0 0 1-1.576 0S4.924 9.581 4.516 9.163c-.409-.418-.436-1.17 0-1.615z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dropdown-content bg-secondary-lighter rounded-b">
                    <a href="{{ route('logout') }}" class="rounded-b hover:bg-secondary px-4 py-2"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out-alt mr-2"></i>Cerrar sesión
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        @endguest

      </div>
    </div>

  </nav>
</div>
