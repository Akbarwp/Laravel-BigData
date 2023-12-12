@extends('dashboard.layouts.app')

@section('container')
    <div class="h-full flex justify-center items-center px-5">
        <div class="card w-96 bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title">Kalimat:</h2>
                <span class="pl-3 font-semibold text-secondary">"{{ $teks }}"</span>
                <p class="font-semibold">Arah Sentimen:
                    @if ($category == 'positif')
                        <span class="text-success capitalize">{{ $category }}</span>
                    @elseif ($category == 'netral')
                        <span class="text-gray-500 capitalize">{{ $category }}</span>
                    @elseif ($category == 'negatif')
                        <span class="text-error capitalize">{{ $category }}</span>
                    @endif
                </p>
                <p class="font-semibold">Scores: </p>
                <span class="text-success pl-3"><span class="capitalize text-secondary">Positif:</span> {{ $scores['positif'] }}</span>
                {{-- <span class="text-success pl-3"><span class="capitalize text-secondary">Netral:</span> {{ $scores['netral'] }}</span> --}}
                <span class="text-success pl-3"><span class="capitalize text-secondary">Negatif:</span> {{ $scores['negatif'] }}</span>
            </div>
        </div>
    </div>
@endsection
