{{-- filepath: d:\DepDev_NEDA\resources\views\training\profile.blade.php --}}
<x-app-layout>
    <h1 class="text-2xl font-bold mb-4">Training Profile</h1>

    <table class="table-auto w-full border-collapse border border-gray-300">
        <thead>
            <tr>
                <th class="border border-gray-300 px-4 py-2">Title</th>
                <th class="border border-gray-300 px-4 py-2">Competency</th>
                <th class="border border-gray-300 px-4 py-2">Implementation Date</th>
                <th class="border border-gray-300 px-4 py-2">Provider</th>
                <th class="border border-gray-300 px-4 py-2">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($trainings as $training)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $training->title }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $training->competency }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $training->implementation_date }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $training->provider }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $training->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-app-layout>