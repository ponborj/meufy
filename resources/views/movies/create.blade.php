<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-center text-gray-800 leading-tight">
            {{ __('🎬 Meus Filmes') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 p-6" x-data="movieSearch()">
            <div class="mb-6">
                <h1 class="text-2xl font-bold">Adicionar um novo filme</h1>
            </div>

            <div class="bg-white p-4 rounded shadow items-center">
                <form action="{{ route('movies.store') }}" method="POST" class="space-y-8 -mt-8">
                    @csrf

                    <!-- CAMPO DE BUSCA -->
                    <div class="relative">
                        <label class="block text-sm font-medium">Buscar Filme</label>
                        <input type="text" x-model="query" @input.debounce.400ms="searchMovies"
                            class="mt-1 p-2 w-full border rounded" placeholder="Digite o nome do filme...">

                        <!-- LISTA DE RESULTADOS -->
                        <ul x-show="results.length > 0"
                            class="absolute z-10 bg-white border mt-1 w-full rounded shadow">
                            <template x-for="movie in results" :key="movie.id">
                                <li @click="selectMovie(movie)"
                                    class="flex items-center space-x-3 p-2 hover:bg-gray-100 cursor-pointer">
                                    <img :src="`https://image.tmdb.org/t/p/w45${movie.poster_path}`"
                                        class="w-10 rounded" alt="">
                                    <span
                                        x-text="`${movie.title} (${movie.release_date?.slice(0, 4) || '??'}) - ${movie.original_title}`"></span>

                                </li>
                            </template>
                        </ul>
                    </div>

                    <!-- CAMPOS ESCONDIDOS QUE SERÃO PREENCHIDOS AO SELECIONAR O FILME -->
                    <input type="hidden" name="tmdb_id" :value="selected.tmdb_id">
                    <input type="hidden" name="title" :value="selected.title">
                    <input type="hidden" name="poster_path" :value="selected.poster_path">

                    <template x-if="selected.title">
                        <div class="flex items-center space-x-4">
                            <img :src="`https://image.tmdb.org/t/p/w92${selected.poster_path}`" class="w-16 rounded"
                                alt="Poster do filme">
                            <p class="text-lg font-semibold" x-text="selected.title"></p>
                        </div>
                    </template>

                    <!-- DATA E NOTA -->
                    <div class="grid grid-cols-2 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Data Assistido</label>
                            <input type="date" name="watched_at" required
                                class="w-full border border rounded px-3 py-2">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Nota (0 a 5)</label>
                            <input type="number" name="rating" step="0.1" min="0" max="5" required
                                class="w-full border border rounded px-3 py-2">
                        </div>
                    </div>

                    <!-- BOTÕES -->
                    <div class="flex gap-3 mt-4">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                            Salvar
                        </button>
                        <a href="/movies" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
                            Voltar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
        function movieSearch() {
            return {
                query: '',
                results: [],
                selected: {
                    tmdb_id: '',
                    title: '',
                    poster_path: ''
                },
                searchMovies() {
                    if (this.query.length < 2) return;

                    fetch(`/tmdb/search?q=${this.query}`)
                        .then(res => res.json())
                        .then(data => {
                            this.results = data.results.filter(m => m.poster_path);
                        });
                },
                selectMovie(movie) {
                    this.selected = {
                        tmdb_id: movie.id,
                        title: movie.title,
                        poster_path: movie.poster_path
                    };
                    this.results = [];
                    this.query = movie.title;
                }
            };
        }
    </script>
</x-app-layout>
