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
                                <label for="preprocessing_button" class="btn btn-neutral btn-sm text-white dark:text-gray-800 normal-case bg-gray-600 hover:bg-opacity-70 hover:border-opacity-70 dark:bg-gray-300 dark:hover:bg-opacity-90" onclick="return sentiment_analysis_button()">
                                    <i class="ri-search-eye-line"></i>
                                    Sentiment Analysis
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto p-3">
                        <table id="tabel_data" class="w-full text-sm text-left text-gray-500 dark:text-gray-400 stripe hover" style="width:100%; padding-top: 1em; padding-bottom: 1em;">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3">No.</th>
                                    <th scope="col" class="px-4 py-3 max-w-xs">Review</th>
                                    <th scope="col" class="px-4 py-3">Positive</th>
                                    {{-- <th scope="col" class="px-4 py-3">Netral</th> --}}
                                    <th scope="col" class="px-4 py-3">Negative</th>
                                    <th scope="col" class="px-4 py-3">Label</th>
                                    <th scope="col" class="px-4 py-3">Sentiment</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $value => $item)
                                    <tr class="border-b dark:border-gray-700">
                                        <td class="px-4 py-3">{{ $value+1 }}</td>
                                        <td class="px-4 py-3">{{ $item->stemming }}</td>
                                        <td class="px-4 py-3">{{ $item->positive }}</td>
                                        {{-- <td class="px-4 py-3">{{ $item->netral }}</td> --}}
                                        <td class="px-4 py-3">{{ $item->negative }}</td>
                                        <td class="px-4 py-3">
                                            @if ($item->label == "positive")
                                                <div class="badge badge-success">{{ $item->label }}</div>
                                            @elseif ($item->label == "negative")
                                                <div class="badge badge-error">{{ $item->label }}</div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            @if ($item->sentiment == "positive")
                                                <div class="badge badge-success">{{ $item->sentiment }}</div>
                                            {{-- @elseif ($item->sentiment == "netral")
                                                <div class="badge badge-neutral">{{ $item->sentiment }}</div> --}}
                                            @elseif ($item->sentiment == "negative")
                                                <div class="badge badge-error">{{ $item->sentiment }}</div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden flex gap-x-5 justify-center items-center mt-10 p-10">
                    <div class="border-black/10 shadow-xl relative z-20 flex w-1/2 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
                        <div class="py-4 pr-1 bg-gradient-to-tl from-gray-900 to-slate-800 rounded-xl">
                            <div>
                                <canvas id="chart-bars" height="170"></canvas>
                            </div>
                        </div>
                        <h6 class="mt-6 mb-0 ml-2">Perbandingan Hasil Sentiment Analysis</h6>
                        <p class="ml-2 leading-normal text-sm flex flex-col">
                            <span class="font-semibold">
                                X <i class="ri-arrow-right-line"></i> Sentiment,
                                Y <i class="ri-arrow-right-line"></i> Jumlah Data
                            </span>
                        </p>
                        <div class="w-full px-6 mx-auto max-w-screen-2xl rounded-xl">
                            <div class="flex flex-wrap mt-0 -mx-3">
                                @foreach ($sentiment as $value => $item)
                                    <div class="flex-none w-1/2 max-w-full py-4 pl-0 pr-3 mt-0">
                                        <div class="flex mb-2">
                                            <div class="flex items-center justify-center w-5 h-5 mr-2 text-center bg-center rounded fill-current shadow-soft-2xl bg-gradient-to-tl from-purple-700 to-pink-500 text-neutral-900">
                                                <i class="ri-table-fill text-white text-sm"></i>
                                            </div>
                                            <div class="flex flex-col">
                                                <p class="mt-1 mb-0 leading-tight text-xs">Sentiment
                                                    @if ($value == "positive")
                                                        <span class="font-bold text-success">{{ $value }}</span>:
                                                    {{-- @elseif ($value == "netral")
                                                        <span class="font-bold text-neutral">{{ $value }}</span>: --}}
                                                    @elseif ($value == "negative")
                                                        <span class="font-bold text-error">{{ $value }}</span>:
                                                    @endif
                                                    <span class="font-semibold">{{ $item }}</span>
                                                    data
                                                </p>
                                                <p class="mt-1 mb-0 leading-tight text-xs">Persentase:
                                                    @if ($value == "positive")
                                                        <span class="font-semibold">{{ $persentase['positive'] }}</span>
                                                    @elseif ($value == "negative")
                                                        <span class="font-semibold">{{ $persentase['negative'] }}</span>
                                                    @endif
                                                    (%)
                                                </p>
                                            </div>
                                        </div>
                                        <h4 class="font-bold">{{ $item }}</h4>
                                        <div class="text-xs h-0.75 flex w-3/4 overflow-visible rounded-lg bg-gray-200">
                                            <progress class="progress progress-secondary w-56" value="{{ $item }}" max="{{ $data->count() }}"></progress>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="border-black/10 w-1/2 shadow-xl relative z-20 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
                        <div class="p-7">
                            <canvas id="chart-pie"></canvas>
                        </div>
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

        function sentiment_analysis_button() {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                html:
                    "<p>Sentiment Analysis menghasilkan:</p>" +
                    "<div class='divider'></div>" +
                    "<b>Positif, Netral, Negatif, Sentiment</b>",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#6419E6',
                cancelButtonColor: '#F87272',
                confirmButtonText: 'Analysis',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        icon: "info",
                        title: "Loading",
                        text: "Sedang dilakukan Analisis",
                    });
                    $.ajax({
                        type: "post",
                        url: "{{ route('sentimentAnalysis.sentimentAnalysis') }}",
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            Swal.fire({
                                title: 'Sentiment Analysis berhasil dilakukan!',
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
                                title: 'Sentiment Analysis gagal dilakukan!',
                            })
                        }
                    });
                }
            })
        }
    </script>

    <script>
        let ctx = document.getElementById("chart-bars").getContext("2d");
        new Chart(ctx, {
            type: "bar",
            data: {
                // labels: ["Positive", "Netral", "Negative"],
                labels: ["Positive", "Negative"],
                datasets: [
                    {
                        label: "Jumlah Data",
                        tension: 0.4,
                        borderWidth: 0,
                        borderRadius: 4,
                        borderSkipped: false,
                        backgroundColor: [
                            '#36D399',
                            // '#FFFFFF',
                            '#F87272'
                        ],
                        data: [{{ $sentiment['positive'] }}, {{ $sentiment['negative'] }}],
                        // maxBarThickness: 6,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                interaction: {
                    intersect: false,
                    mode: "index",
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                        },
                        ticks: {
                            suggestedMin: 0,
                            suggestedMax: 600,
                            beginAtZero: true,
                            padding: 15,
                            font: {
                                size: 14,
                                family: "Open Sans",
                                style: "normal",
                                lineHeight: 2,
                            },
                            color: "#fff",
                        },
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                        },
                            ticks: {
                            display: false,
                        },
                    },
                },
            },
        });

        let ctx2 = document.getElementById('chart-pie');
        new Chart(ctx2, {
            type: "pie",
            data: {
                // labels: ["Positive", "Netral", "Negative"],
                labels: ["Positive", "Negative"],
                datasets: [
                    {
                        label: "Jumlah Sentiment",
                        tension: 0.4,
                        borderWidth: 0,
                        borderRadius: 4,
                        borderSkipped: false,
                        backgroundColor: [
                            '#36D399',
                            // '#2A303C',
                            '#F87272'
                        ],
                        data: [{{ $sentiment['positive'] }}, {{ $sentiment['negative'] }}],
                        maxBarThickness: 6,
                    },
                    {
                        label: "Persentase (%)",
                        data: [{{ $persentase['positive'] }}, {{ $persentase['negative'] }}],
                        backgroundColor: [
                            '#36D399',
                            // '#2A303C',
                            '#F87272'
                        ],
                        borderWidth: 0,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: 'top',
                    },
                },
                interaction: {
                    intersect: false,
                    mode: "index",
                },
            },
        });
    </script>
@endsection
