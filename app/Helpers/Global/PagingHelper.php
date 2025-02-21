<?php
/**
 * Paging helpers.
 *
 * @author ThuyVu <thuyvv.hn@gmail.com>
 */

if (!function_exists('fn_gen_paging_options')) {
    /**
     * Generate list page number available.
     *
     * @param int    $total   <p>Total page number.</p>
     * @param int    $current <p>Current page number.</p>
     * @param int    $items   <p>Number of elements.</p>
     * @param string $slug    <p>Slug ...</p>
     * @return object The Paging options object. <br/>
     *                        {
     *                        'state': true,
     *                        'pages': [1,2,3],
     *                        'previous': 1,
     *                        'current': 2,
     *                        'next': 3,
     *                        'items': 7,
     *                        'first': 1,
     *                        'last': 3,
     *                        'slug': '...'
     *                        }
     * @author ThuyVu <thuyvv.hn@gmail.com>
     */
    function fn_gen_paging_options(int $total = 1, int $current = 1, int $items = 7, string $slug = '...'): object
    {
        $output = (object)[
            'state'    => false,
            'pages'    => [],
            'previous' => 0,
            'current'  => 0,
            'next'     => 0,
            'items'    => 0,
            'first'    => 0,
            'last'     => 0,
            'slug'     => $slug
        ];

        if ($total <= 0) {
            return $output;
        }
        $output->state = true;
        $output->first = 1;
        $output->last = $total;
        $output->current = $current = (($current <= 0 || $current > $total) ? $output->first : $current);
        $output->previous = ($current == $output->first ? $current : ($current - 1));
        $output->next = ($current == $output->last ? $current : ($current + 1));
        $output->items = $items = (($items <= 0) ? 7 : $items);
        $nip2 = intval($items / 2);

        $slug = str_replace([' '], '', $slug);
        $output->slug = $slug = (empty($slug) ? '...' : $slug);

        if ($total <= $items) {
            for ($page = 1; $page <= $total; $page++) {
                $output->pages[] = $page;
            }
        }
        else {
            /** Slug first */
            if (($current - $nip2) > 1) {
                $output->pages[] = $slug;
            }

            /** List Page number */
            for ($page = 1; $page <= $items; $page++) {
                if ($current > $nip2 && $current < ($total - $nip2)) {
                    $output->pages[] = ($current - ($nip2 + 1) + $page);
                }
                elseif ($current <= $nip2) {
                    $output->pages[] = $page;
                }
                elseif ($current >= ($total - $nip2)) {
                    $output->pages[] = ($total - $items + $page);
                }
            }

            /** Slug last */
            if (($current + $nip2) < $total) {
                $output->pages[] = $slug;
            }
        }

        return $output;
    }
}
