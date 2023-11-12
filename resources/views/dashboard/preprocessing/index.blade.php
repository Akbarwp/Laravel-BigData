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
                                <label for="preprocessing_button" class="btn btn-neutral btn-sm text-white dark:text-gray-800 normal-case bg-gray-600 hover:bg-opacity-70 hover:border-opacity-70 dark:bg-gray-300 dark:hover:bg-opacity-90" onclick="return preprocessing_button()">
                                    <i class="ri-code-fill"></i>
                                    Preprocessing
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto p-3">
                        <table id="tabel_data" class="w-full text-sm text-left text-gray-500 dark:text-gray-400 stripe hover" style="width:100%; padding-top: 1em; padding-bottom: 1em;">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3">No.</th>
                                    <th scope="col" class="px-4 py-3 max-w-xs">Case Folding</th>
                                    <th scope="col" class="px-4 py-3 max-w-xs">Tokenize</th>
                                    <th scope="col" class="px-4 py-3 max-w-xs">Stemming</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $value => $item)
                                    <tr class="border-b dark:border-gray-700">
                                        <td class="px-4 py-3">{{ $value+1 }}</td>
                                        <td class="px-4 py-3">{{ $item->case_folding }}</td>
                                        <td class="px-4 py-3">{{ $item->tokenize }}</td>
                                        <td class="px-4 py-3">{{ $item->stemming }}</td>
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
            $('#tabel_data').DataTable({
                // responsive: true,
                order: [],
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

        function preprocessing_button() {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                html:
                    "<p>Prepocessing meliputi:</p>" +
                    "<div class='divider'></div>" +
                    "<b>Case Folding, Tokenize, Stemming</b>",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#6419E6',
                cancelButtonColor: '#F87272',
                confirmButtonText: 'Prepocessing',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "post",
                        url: "{{ route('preprocessing.preprocessing') }}",
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            Swal.fire({
                                title: 'Prepocessing berhasil dilakukan!',
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
                                title: 'Prepocessing gagal dilakukan!',
                            })
                        }
                    });
                }
            })
        }
    </script>
@endsection
