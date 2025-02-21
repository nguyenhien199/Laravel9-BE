<?php

namespace App\Http\Resources\Core\Transformers;

use Illuminate\Support\Arr;
use Spatie\LaravelData\Transformers\DataCollectableTransformer as SpatieDataCollectableTransformer;

/**
 * Class DataCollectableTransformer
 *
 * @package App\Http\Resources\Core\Transformers
 */
class DataCollectableTransformer extends SpatieDataCollectableTransformer
{
    /**
     * Wrap Paginate to Array.
     *
     * @override
     * @param array $paginated <p>Paginated array</p>
     * @return array
     */
    protected function wrapPaginatedArray(array $paginated): array
    {
        $wrapKey = $this->wrap->getKey() ?? 'data';
        $wrapKey = config('data.paginator_wrap') ?? $wrapKey;
        $metaKey = config('data.paginator_meta') ?? 'meta';
        $linkEnabled = (bool)config('data.paginator_links_enabled', false);

        $items = $paginated['data'] ?? [];
        $links = $paginated['links'] ?? [];
        $meta = Arr::except($paginated, ['data', 'links']);

        $firstPageUrl = $meta['first_page_url'] ?? '';
        $pageName = (str_contains($firstPageUrl, '?') && str_contains($firstPageUrl, '=') && strpos($firstPageUrl, '?') <= strpos($firstPageUrl, '='))
            ? substr($firstPageUrl, (strpos($firstPageUrl, '?') + 1), (strpos($firstPageUrl, '=') - strpos($firstPageUrl, '?') - 1))
            : '';

        $wrapPaginatedArray = [
            $wrapKey => $items,
            $metaKey => array_merge(
                Arr::only($meta, ['current_page', 'last_page', 'per_page', 'from', 'to', 'total', 'path']),
                ['page_name' => $pageName]
            ),
        ];
        if ($linkEnabled) {
            $wrapPaginatedArray = array_merge(
                $wrapPaginatedArray,
                [
                    'links' => $links,
                    $metaKey => array_merge(
                        $wrapPaginatedArray[$metaKey],
                        Arr::only($meta, ['first_page_url', 'last_page_url', 'prev_page_url', 'next_page_url'])
                    ),
                ]
            );
        }
        ksort($wrapPaginatedArray[$metaKey]);
        ksort($wrapPaginatedArray);

        return $wrapPaginatedArray;
    }
}
