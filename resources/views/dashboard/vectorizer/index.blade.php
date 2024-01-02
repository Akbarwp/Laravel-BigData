@extends('dashboard.layouts.app')

@section('container')
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ $judul }}
        </h2>
    </div>

    <div>
        <section class="mt-10">
            <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                    <div class="flex justify-end items-center d p-4">
                        <div class="flex space-x-3">
                            <div class="flex space-x-3 items-center">
                                <label for="vectorizer_button" class="btn btn-neutral btn-sm text-white dark:text-gray-800 normal-case bg-gray-600 hover:bg-opacity-70 hover:border-opacity-70 dark:bg-gray-300 dark:hover:bg-opacity-90" onclick="return vectorizer_button()">
                                    <i class="ri-command-line"></i>
                                    Vectorizer
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto py-3 px-5 flex gap-x-5">
                        <table id="tabel_data1" class="w-1/2 text-sm text-left text-gray-500 dark:text-gray-400 stripe hover" style="width:100%; padding-top: 1em; padding-bottom: 1em;">
                            <caption class="text-left text-lg font-semibold text-gray-700 dark:text-gray-300">Sentiment Positive</caption>
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3">Word</th>
                                    <th scope="col" class="px-4 py-3">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataPositive as $item)
                                    <tr class="border-b dark:border-gray-700">
                                        <td class="px-4 py-3">{{ $item->word }}</td>
                                        <td class="px-4 py-3">{{ $item->total }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <table id="tabel_data2" class="w-1/2 text-sm text-left text-gray-500 dark:text-gray-400 stripe hover" style="width:100%; padding-top: 1em; padding-bottom: 1em;">
                            <caption class="text-left text-lg font-semibold text-gray-700 dark:text-gray-300">Sentiment Negative</caption>
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3">Word</th>
                                    <th scope="col" class="px-4 py-3">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataNegative as $item)
                                    <tr class="border-b dark:border-gray-700">
                                        <td class="px-4 py-3">{{ $item->word }}</td>
                                        <td class="px-4 py-3">{{ $item->total }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#tabel_data1').DataTable({
                // responsive: true,
                order: [1],
            })
            .columns.adjust()
            .responsive.recalc();

            $('#tabel_data2').DataTable({
                // responsive: true,
                order: [1],
            })
            .columns.adjust()
            .responsive.recalc();
        });

        @if (session()->has('berhasil'))
            Swal.fire({
                title: 'Berhasil',
                text: '{{ session('berhasil') }}',
                icon: 'success',
                confirmButtonColor: '#6419E6',
                confirmButtonText: 'OK',
            });
        @endif

        @if (session()->has('gagal'))
            Swal.fire({
                title: 'Gagal',
                text: '{{ session('gagal') }}',
                icon: 'error',
                confirmButtonColor: '#6419E6',
                confirmButtonText: 'OK',
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                title: 'Gagal',
                text: @foreach ($errors->all() as $error) '{{ $error }}' @endforeach,
                icon: 'error',
                confirmButtonColor: '#6419E6',
                confirmButtonText: 'OK',
            })
        @endif

        function vectorizer_button() {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                html:
                    "<p>Vectorizer untuk:</p>" +
                    "<div class='divider'></div>" +
                    "<b>Pengubahan kumpulan kalimat menjadi vektor jumlah token</b>",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#6419E6',
                cancelButtonColor: '#F87272',
                confirmButtonText: 'Vectorizer',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        icon: "info",
                        title: "Loading",
                        text: "Sedang dilakukan Vectorizer",
                    });
                    $.ajax({
                        type: "post",
                        url: "{{ route('vectorizer.vectorizer') }}",
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            Swal.fire({
                                title: 'Vectorizer berhasil dilakukan!',
                                icon: 'success',
                                confirmButtonColor: '#6419E6',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        },
                        error: function (response) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Vectorizer gagal dilakukan!',
                            })
                        }
                    });
                }
            })
        }
    </script>
@endsection
