<tbody class="bg-white divide-y divide-gray-200 divide-solid">
    @forelse($results as $result)
        <tr @class([
            'bg-green-50' => $result instanceof App\Models\Post,
            'bg-indigo-50' => $result instanceof App\Models\Video,
            'bg-amber-50' => $result instanceof App\Models\Course,
        ])>
            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                {{ $result->title }}
            </td>
            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                {{ $result->created_at }}
            </td>
        </tr>
    @empty
        No results found.
    @endforelse
</tbody>