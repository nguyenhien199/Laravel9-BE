<?php

namespace App\Traits;

use App\Constants\PageConst;
use App\Constants\RepositoryConst;
use Illuminate\Database\Eloquent\Model;

/**
 * Trait ElementTrait
 *
 * @package App\Traits
 */
trait ElementTrait
{
    /**
     * Get element default data
     *
     * @param array  $params
     * @param string $element
     * @return mixed
     */
    protected function getElementData(array $params = [], string $element = ''): mixed
    {
        if (empty($element)) {
            return null;
        }

        return match ($element) {
            'offset'    => (!empty($params['offset']) && filter_var($params['offset'], FILTER_VALIDATE_INT) && $params['offset'] > 0)
                ? $params['offset']
                : RepositoryConst::OFFSET_DEFAULT,
            'limit'     => (!empty($params['limit']) && filter_var($params['limit'], FILTER_VALIDATE_INT) && $params['limit'] > 0)
                ? $params['limit']
                : RepositoryConst::LIMIT_DEFAULT,
            'per_page'  => (!empty($params['per_page']) && filter_var($params['per_page'], FILTER_VALIDATE_INT) && $params['per_page'] > 0)
                ? $params['per_page']
                : PageConst::PER_PAGE_DEFAULT,
            'columns'   => (!empty($params['columns']))
                ? $params['columns']
                : RepositoryConst::COLUMNS_DEFAULT,
            'page_name' => PageConst::PAGE_NAME_DEFAULT,
            'page'      => (!empty($params['page']) && filter_var($params['page'], FILTER_VALIDATE_INT) && $params['page'] > 0)
                ? $params['page']
                : PageConst::PAGE_DEFAULT,
            'sort'      => (!empty($params['sort']))
                ? $params['sort']
                : ((!empty($this->model) && $this->model instanceof Model) ? ($this->model->getTable().'.'.$this->model->getKeyName()) : null),
            'sort_type' => (!empty($params['sort_type']) && in_array(strtoupper($params['sort_type']), RepositoryConst::getKeySortTypes()))
                ? strtoupper($params['sort_type'])
                : RepositoryConst::SORT_TYPE_ASC,
            'sorts'     => (!empty($params['sorts']) && is_array($params['sorts']))
                ? $params['sorts']
                : [],
            'year'      => (isset($params['year']) && filter_var($params['year'], FILTER_VALIDATE_INT) && (int)$params['year'] > 0)
                ? (int)$params['year']
                : null,
            'month'     => (isset($params['month']) && filter_var($params['month'], FILTER_VALIDATE_INT) && (int)$params['month'] > 0)
                ? (int)$params['month']
                : null,
            'day'       => (isset($params['day']) && filter_var($params['day'], FILTER_VALIDATE_INT) && (int)$params['day'] > 0)
                ? (int)$params['day']
                : null,
            default     => null,
        };
    }
}