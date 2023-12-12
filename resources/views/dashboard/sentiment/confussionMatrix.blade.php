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
                    <div class="overflow-x-auto p-3">
                        <table id="tabel_data" class="w-full text-sm text-left text-gray-500 dark:text-gray-400 stripe hover" style="width:100%; padding-top: 1em; padding-bottom: 1em;">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3"></th>
                                    <th scope="col" class="px-4 py-3">Positive</th>
                                    <th scope="col" class="px-4 py-3">Negative</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b dark:border-gray-700">
                                    <td class="px-4 py-3 font-bold uppercase">True</td>
                                    <td class="px-4 py-3">{{ $TP }}</td>
                                    <td class="px-4 py-3">{{ $TN }}</td>
                                </tr>
                                <tr class="border-b dark:border-gray-700">
                                    <td class="px-4 py-3 font-bold uppercase">False</td>
                                    <td class="px-4 py-3">{{ $FP }}</td>
                                    <td class="px-4 py-3">{{ $FN }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="divider"></div>

                        <table id="tabel_data1" class="w-full text-sm text-left text-gray-500 dark:text-gray-400 stripe hover" style="width:100%; padding-top: 1em; padding-bottom: 1em;">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3">Matrix</th>
                                    <th scope="col" class="px-4 py-3">Nilai</th>
                                    <th scope="col" class="px-4 py-3">Persen (%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b dark:border-gray-700">
                                    <td class="px-4 py-3">Accuracy</td>
                                    <td class="px-4 py-3">{{ round($accuracy, 3) }}</td>
                                    <td class="px-4 py-3">{{ round($accuracy * 100, 1) . "%" }}</td>
                                </tr>
                                <tr class="border-b dark:border-gray-700">
                                    <td class="px-4 py-3">Precision</td>
                                    <td class="px-4 py-3">{{ round($precision, 3) }}</td>
                                    <td class="px-4 py-3">{{ round($precision * 100, 1) . "%" }}</td>
                                </tr>
                                <tr class="border-b dark:border-gray-700">
                                    <td class="px-4 py-3">Recall</td>
                                    <td class="px-4 py-3">{{ round($recall, 3) }}</td>
                                    <td class="px-4 py-3">{{ round($recall * 100, 1) . "%" }}</td>
                                </tr>
                                <tr class="border-b dark:border-gray-700">
                                    <td class="px-4 py-3">Specificity</td>
                                    <td class="px-4 py-3">{{ round($specificity, 3) }}</td>
                                    <td class="px-4 py-3">{{ round($specificity * 100, 1) . "%" }}</td>
                                </tr>
                                <tr class="border-b dark:border-gray-700">
                                    <td class="px-4 py-3">F1Score</td>
                                    <td class="px-4 py-3">{{ round($f1Score, 3) }}</td>
                                    <td class="px-4 py-3">{{ round($f1Score * 100, 1) . "%" }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
