<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-center text-gray-800 leading-tight">
            {{ __('🎬 Meus Filmes') }}
        </h2>
    </x-slot>


    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">Lista</h1>
                    <a href="{{ route('movies.create') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
                        + Adicionar Filme
                    </a>
                </div>

                @if ($movies->isEmpty())
                    <p class="text-gray-600">Você ainda não adicionou nenhum filme.</p>
                @else
                    <ul class="space-y-4">
                        @foreach ($movies as $movie)
                            <li class="bg-white p-4 rounded shadow flex items-center space-x-4">
                                @if ($movie->poster_path)
                                    <img src="https://image.tmdb.org/t/p/w92{{ $movie->poster_path }}"
                                        alt="{{ $movie->title }}" class="w-16 rounded">
                                @endif
                                <div class="flex-1">
                                    <h2 class="text-xl font-semibold">{{ $movie->title }}</h2>
                                    <p class="text-sm text-gray-600">
                                        Nota: <strong>{{ $movie->rating }}</strong> | Assistido em:
                                        {{ \Carbon\Carbon::parse($movie->watched_at)->format('d/m/Y') }}
                                    </p>
                                </div>
                                <form action="{{ route('movies.destroy', $movie) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:underline">Excluir</button>
                                </form>
                                <a href="{{ route('movies.edit', $movie) }}"
                                    class="text-blue-600 hover:underline text-sm mr-2">Editar</a>

                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
