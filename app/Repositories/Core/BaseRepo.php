<?php

namespace App\Repositories\Core;

use App\Exceptions\DatabaseException;
use App\Traits\ElementTrait;
use Closure;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as ILengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

/**
 * Class BaseRepo
 *
 * @package App\Repositories\Core
 */
abstract class BaseRepo implements Contracts\IBaseRepo
{
    /**
     * Gen Element default data.
     */
    use ElementTrait;

    /**
     * The Model used in Repository.
     *
     * @var Model
     */
    protected Model $model;

    /**
     * BaseRepo Constructor
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;

        /**
         * Enable the query log on the connection.
         */
        DB::enableQueryLog();
    }

    /**
     * Get Model instance.
     *
     * @return Model <p>The model being queried.</p>
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * Get Auto Increment number.
     * (next the Primary value number)
     *
     * @return int|null Auto Increment number. <br/>
     *         Int: This is an Auto increment. <br/>
     *         null: The table has no Auto_increment definition.
     * @throws DatabaseException Thrown if the query has an error.
     */
    public function getAutoIncrement(): ?int
    {
        try {
            $result = DB::select("SHOW TABLE STATUS LIKE '{$this->model->getTable()}'");
            return (isset($result[0]) && !empty($result[0]->Auto_increment))
                ? $result[0]->Auto_increment
                : null;
        }
        catch (Throwable $e) {
            $this->logErrorQuery($e);
            throw new DatabaseException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Check records exist in relationship.
     * (foreach list table in list models and check exists one then return)
     * (find by Model primary Key)
     *
     * @param int|string $id     <p>The Model primary key value.</p>
     * @param array      $tables <p>List of tables to check for the existence of relational data. <br/>
     *                           structure: <br/>
     *                           <b>['table_a' => 'column_a', 'table_b' => [column_b1, column_b2, ... ], ... ]</b>
     *                           </p>
     * @return bool TRUE: exist, FALSE: does not exist.
     * @throws DatabaseException Thrown if the query has an error.
     */
    public function checkExistOnRelationship(int|string $id, array $tables): bool
    {
        try {
            if (count($tables) <= 0) {
                return false;
            }
            foreach ($tables as $table => $columns) {
                if (!empty($columns)) {
                    if (is_array($columns)) {
                        foreach ($columns as $column) {
                            if (DB::table($table)->where($table.'.'.$column, '=', $id)->count() > 0) {
                                return true;
                            }
                        }
                    }
                    elseif (is_string($columns) || is_numeric($columns)) {
                        if (DB::table($table)->where($table.'.'.$columns, '=', $id)->count() > 0) {
                            return true;
                        }
                    }
                }
            }
            return false;
        }
        catch (Throwable $e) {
            $this->logErrorQuery($e);
            throw new DatabaseException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Find a Model by its primary key.
     *
     * @param int|string $id      <p>The Model primary key value.</p>
     * @param array      $columns [optional] <p>Select column list (default: ['*']). <br/>
     *                            column selection: <b>['table_a.column_a', 'table_a.column_b', ... ]</b> <br/>
     *                            or <br/>
     *                            select all column: <b>['*']</b>
     *                            </p>
     * @param array      $withs   [optional] <p>The Relationships need to be loaded.</p>
     * @param bool|null  $inTrash [optional] <p>Use Trashed for Model's query (default: FALSE). <br/>
     *                            <b>FALSE</b>: Get only Models that are not soft-deleted (withoutTrashed). <br/>
     *                            <b>TRUE</b>: Get only Models that have been soft-deleted (onlyTrashed). <br/>
     *                            <b>NULL</b>: Get all Models including soft-deleted (withTrashed).
     *                            </p>
     * @return Model|null The Model instance or NULL if not found.
     * @throws DatabaseException Thrown if the Query has an error.
     */
    public function find(int|string $id, array $columns = ['*'], array $withs = [], bool|null $inTrash = false): ?Model
    {
        try {
            $query = $this->model->newQuery();
            // where / with / inTrash
            $query = $this->setWhere($query, [], $withs, $inTrash);
            // return
            return $query->find($id, $columns);
        }
        catch (Throwable $e) {
            $this->logErrorQuery($e);
            throw new DatabaseException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Find a Model by its primary key or throw an exception if not found.
     *
     * @param int|string $id      <p>The Model primary key value.</p>
     * @param array      $columns [optional] <p>Select column list (default: ['*']). <br/>
     *                            column selection: <b>['table_a.column_a', 'table_a.column_b', ... ]</b> <br/>
     *                            or <br/>
     *                            select all column: <b>['*']</b>
     *                            </p>
     * @param array      $withs   [optional] <p>The Relationships need to be loaded.</p>
     * @param bool|null  $inTrash [optional] <p>Use Trashed for Model's query (default: FALSE). <br/>
     *                            <b>FALSE</b>: Get only Models that are not soft-deleted (withoutTrashed). <br/>
     *                            <b>TRUE</b>: Get only Models that have been soft-deleted (onlyTrashed). <br/>
     *                            <b>NULL</b>: Get all Models including soft-deleted (withTrashed).
     *                            </p>
     * @return Model The Model instance.
     * @throws ModelNotFoundException<Model> Thrown if the Model instance is not found.
     * @throws DatabaseException Thrown if the Query has an error.
     */
    public function findOrFail(int|string $id, array $columns = ['*'], array $withs = [], bool|null $inTrash = false): Model
    {
        try {
            $query = $this->model->newQuery();
            // where / with / inTrash
            $query = $this->setWhere($query, [], $withs, $inTrash);
            // return
            return $query->findOrFail($id, $columns);
        }
        catch (Throwable $e) {
            $this->logErrorQuery($e);
            throw new DatabaseException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Get the first specified Model record from the database.
     * (find by input conditions)
     *
     * @param array|Closure $where   [optional] <p>The conditions to search in the query.</p>
     * @param array         $options [optional] <p>Query extended parameter. <br/>
     *                               <b>['columns' => ['*'], 'sort' => 'id', 'sort_type' => 'asc']</b> <br/>
     *                               Expand: If you want to sort from two or more elements, put in the following list. <br/>
     *                               structure: ['columns' => ['*'], 'sorts' => ['column_key' => 'sort_type', ...]] <br/>
     *                               example: <b>['columns' => ['*'], 'sorts' => ['column_a' => 'asc', 'column_b' => 'desc']]</b> <br/>
     *                               <b>NOTE: when 'sorts' is specified, 'sort' and 'sort_type' are not used.</b>
     *                               </p>
     * @param array         $withs   [optional] <p>The Relationships need to be loaded.</p>
     * @param bool|null     $inTrash [optional] <p>Use Trashed for Model's query (default: FALSE). <br/>
     *                               <b>FALSE</b>: Get only Models that are not soft-deleted (withoutTrashed). <br/>
     *                               <b>TRUE</b>: Get only Models that have been soft-deleted (onlyTrashed). <br/>
     *                               <b>NULL</b>: Get all Models including soft-deleted (withTrashed).
     *                               </p>
     * @return Model|null The Model instance or NULL if not found.
     * @throws DatabaseException Thrown if the query has an error.
     */
    public function getFirst(array|Closure $where = [], array $options = [], array $withs = [], bool|null $inTrash = false): ?Model
    {
        $columns = $this->getElementData($options, 'columns');
        try {
            $query = $this->model->newQuery();
            // where / with / inTrash
            $query = $this->setWhere($query, $where, $withs, $inTrash);
            // orderBy
            $query = $this->setOrderBy($query, $options);
            // return
            return $query->first($columns);
        }
        catch (Throwable $e) {
            $this->logErrorQuery($e);
            throw new DatabaseException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Get the first specified Model record from the database or throw an exception if not found.
     * (find by input conditions)
     *
     * @param array|Closure $where   [optional] <p>The conditions to search in the query.</p>
     * @param array         $options [optional] <p>Query extended parameter. <br/>
     *                               <b>['columns' => ['*'], 'sort' => 'id', 'sort_type' => 'asc']</b> <br/>
     *                               Expand: If you want to sort from two or more elements, put in the following list. <br/>
     *                               structure: ['columns' => ['*'], 'sorts' => ['column_key' => 'sort_type', ...]] <br/>
     *                               example: <b>['columns' => ['*'], 'sorts' => ['column_a' => 'asc', 'column_b' => 'desc']]</b> <br/>
     *                               <b>NOTE: when 'sorts' is specified, 'sort' and 'sort_type' are not used.</b>
     *                               </p>
     * @param array         $withs   [optional] <p>The Relationships need to be loaded.</p>
     * @param bool|null     $inTrash [optional] <p>Use Trashed for Model's query (default: FALSE). <br/>
     *                               <b>FALSE</b>: Get only Models that are not soft-deleted (withoutTrashed). <br/>
     *                               <b>TRUE</b>: Get only Models that have been soft-deleted (onlyTrashed). <br/>
     *                               <b>NULL</b>: Get all Models including soft-deleted (withTrashed).
     *                               </p>
     * @return Model The Model instance.
     * @throws ModelNotFoundException<Model> Thrown if the Model instance is not found.
     * @throws DatabaseException Thrown if the query has an error.
     */
    public function getFirstOrFail(array|Closure $where = [], array $options = [], array $withs = [], bool|null $inTrash = false): Model
    {
        $columns = $this->getElementData($options, 'columns');
        try {
            $query = $this->model->newQuery();
            // where / with / inTrash
            $query = $this->setWhere($query, $where, $withs, $inTrash);
            // orderBy
            $query = $this->setOrderBy($query, $options);
            // return
            return $query->firstOrFail($columns);
        }
        catch (Throwable $e) {
            $this->logErrorQuery($e);
            throw new DatabaseException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Find multiple Models by their primary keys.
     *
     * @param int|string|array $ids     <p>The Model primary key values.</p>
     * @param array            $columns [optional] <p>Select column list (default: ['*']). <br/>
     *                                  column selection: <b>['table_a.column_a', 'table_a.column_b', ... ]</b> <br/>
     *                                  or <br/>
     *                                  select all column: <b>['*']</b>
     *                                  </p>
     * @param array            $withs   [optional] <p>The Relationships need to be loaded.</p>
     * @param bool|null        $inTrash [optional] <p>Use Trashed for Model's query (default: FALSE). <br/>
     *                                  <b>FALSE</b>: Get only Models that are not soft-deleted (withoutTrashed). <br/>
     *                                  <b>TRUE</b>: Get only Models that have been soft-deleted (onlyTrashed). <br/>
     *                                  <b>NULL</b>: Get all Models including soft-deleted (withTrashed).
     *                                  </p>
     * @return EloquentCollection Collection of Models.
     * @throws DatabaseException Thrown if the Query has an error.
     */
    public function findMany(int|string|array $ids, array $columns = ['*'], array $withs = [], bool|null $inTrash = false): EloquentCollection
    {
        $ids = is_array($ids) ? $ids : Arr::wrap($ids);
        try {
            $query = $this->model->newQuery();
            // where / with / inTrash
            $query = $this->setWhere($query, [], $withs, $inTrash);
            // return
            return $query->findMany($ids, $columns);
        }
        catch (Throwable $e) {
            $this->logErrorQuery($e);
            throw new DatabaseException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Get list of all Model records in database.
     * (find by input conditions)
     *
     * @param array|Closure $where   [optional] <p>The conditions to search in the query.</p>
     * @param array         $options [optional] <p>Query extended parameter. <br/>
     *                               <b>['columns' => ['*'], 'sort' => 'id', 'sort_type' => 'asc']</b> <br/>
     *                               Expand: If you want to sort from two or more elements, put in the following list. <br/>
     *                               structure: ['columns' => ['*'], 'sorts' => ['column_key' => 'sort_type', ...]] <br/>
     *                               example: <b>['columns' => ['*'], 'sorts' => ['column_a' => 'asc', 'column_b' => 'desc']]</b> <br/>
     *                               <b>NOTE: when 'sorts' is specified, 'sort' and 'sort_type' are not used.</b>
     *                               </p>
     * @param array         $withs   [optional] <p>The Relationships need to be loaded.</p>
     * @param bool|null     $inTrash [optional] <p>Use Trashed for Model's query (default: FALSE). <br/>
     *                               <b>FALSE</b>: Get only Models that are not soft-deleted (withoutTrashed). <br/>
     *                               <b>TRUE</b>: Get only Models that have been soft-deleted (onlyTrashed). <br/>
     *                               <b>NULL</b>: Get all Models including soft-deleted (withTrashed).
     *                               </p>
     * @return EloquentCollection Collection of Models.
     * @throws DatabaseException Thrown if the query has an error.
     */
    public function getAll(array|Closure $where = [], array $options = [], array $withs = [], bool|null $inTrash = false): EloquentCollection
    {
        $columns = $this->getElementData($options, 'columns');
        try {
            $query = $this->model->newQuery();
            // where / with / inTrash
            $query = $this->setWhere($query, $where, $withs, $inTrash);
            // orderBy
            $query = $this->setOrderBy($query, $options);
            // return
            return $query->get($columns);
        }
        catch (Throwable $e) {
            $this->logErrorQuery($e);
            throw new DatabaseException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Get a list of Model records in the database.
     * (find by input conditions and with limit - offset)
     *
     * @param array|Closure $where   [optional] <p>The conditions to search in the query.</p>
     * @param array         $options [optional] <p>Query extended parameter. <br/>
     *                               <b>['columns' => ['*'], 'sort' => 'id', 'sort_type' => 'asc', 'offset' => 0, 'limit' => 20]</b> <br/>
     *                               Expand: If you want to sort from two or more elements, put in the following list. <br/>
     *                               structure: ['columns' => ['*'], ... , 'sorts' => ['column_key' => 'sort_type', ...]] <br/>
     *                               example: <b>['columns' => ['*'], ... , 'sorts' => ['column_a' => 'asc', 'column_b' => 'desc']]</b> <br/>
     *                               <b>NOTE: when 'sorts' is specified, 'sort' and 'sort_type' are not used.</b>
     *                               </p>
     * @param array         $withs   [optional] <p>The Relationships need to be loaded.</p>
     * @param bool|null     $inTrash [optional] <p>Use Trashed for Model's query (default: FALSE). <br/>
     *                               <b>FALSE</b>: Get only Models that are not soft-deleted (withoutTrashed). <br/>
     *                               <b>TRUE</b>: Get only Models that have been soft-deleted (onlyTrashed). <br/>
     *                               <b>NULL</b>: Get all Models including soft-deleted (withTrashed).
     *                               </p>
     * @return EloquentCollection Collection of Models.
     * @throws DatabaseException Thrown if the query has an error.
     */
    public function getLimit(array|Closure $where = [], array $options = [], array $withs = [], bool|null $inTrash = false): EloquentCollection
    {
        $columns = $this->getElementData($options, 'columns');
        $offset = $this->getElementData($options, 'offset');
        $limit = $this->getElementData($options, 'limit');
        try {
            $query = $this->model->newQuery();
            // where / with / inTrash
            $query = $this->setWhere($query, $where, $withs, $inTrash);
            // orderBy
            $query = $this->setOrderBy($query, $options);
            // offset / limit
            $query->offset($offset)->limit($limit);
            // return
            return $query->get($columns);
        }
        catch (Throwable $e) {
            $this->logErrorQuery($e);
            throw new DatabaseException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Paginate the specified Model record from the database.
     * (find by input conditions)
     *
     * @param array|Closure $where   [optional] <p>The conditions to search in the query.</p>
     * @param array         $options [optional] <p>Query extended parameter. <br/>
     *                               <b>['columns' => ['*'], 'sort' => 'id', 'sort_type' => 'asc', 'page' => 1, 'per_page' => 20]</b> <br/>
     *                               Expand: If you want to sort from two or more elements, put in the following list. <br/>
     *                               structure: ['columns' => ['*'], ... , 'sorts' => ['column_key' => 'sort_type', ...]] <br/>
     *                               example: <b>['columns' => ['*'], ... , 'sorts' => ['column_a' => 'asc', 'column_b' => 'desc']]</b> <br/>
     *                               <b>NOTE: when 'sorts' is specified, 'sort' and 'sort_type' are not used.</b>
     *                               </p>
     * @param array         $withs   [optional] <p>The Relationships need to be loaded.</p>
     * @param bool|null     $inTrash [optional] <p>Use Trashed for Model's query (default: FALSE). <br/>
     *                               <b>FALSE</b>: Get only Models that are not soft-deleted (withoutTrashed). <br/>
     *                               <b>TRUE</b>: Get only Models that have been soft-deleted (onlyTrashed). <br/>
     *                               <b>NULL</b>: Get all Models including soft-deleted (withTrashed).
     *                               </p>
     * @return ILengthAwarePaginator The Paginator instance. <br/>
     *                               {
     *                               current_page: int,
     *                               data: array({}, {}),
     *                               first_page_url: url_string,
     *                               from: int,
     *                               last_page: int,
     *                               last_page_url: url_string,
     *                               links: array({url: null|url_string, label: string, active: bool}),
     *                               next_page_url: null|url_string,
     *                               path: url_string,
     *                               per_page: int,
     *                               prev_page_url: null|url_string,
     *                               to: int,
     *                               total: int
     *                               }
     * @throws DatabaseException Thrown if the query has an error.
     */
    public function paginate(array|Closure $where = [], array $options = [], array $withs = [], bool|null $inTrash = false): ILengthAwarePaginator
    {
        $columns = $this->getElementData($options, 'columns');
        $perPage = $this->getElementData($options, 'per_page');
        $pageName = $this->getElementData($options, 'page_name');
        $page = $this->getElementData($options, 'page');
        try {
            $query = $this->model->newQuery();
            // where / with / inTrash
            $query = $this->setWhere($query, $where, $withs, $inTrash);
            // orderBy
            $query = $this->setOrderBy($query, $options);
            // return
            return $query->paginate($perPage, $columns, $pageName, $page);
        }
        catch (Throwable $e) {
            $this->logErrorQuery($e);
            throw new DatabaseException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Count the number of specified Model records in the database.
     * (find by input conditions)
     *
     * @param array|Closure $where   [optional] <p>The conditions to search in the query. If empty, will count all records.</p>
     * @param bool|null     $inTrash [optional] <p>Use Trashed for Model's query (default: FALSE). <br/>
     *                               <b>FALSE</b>: Get only Models that are not soft-deleted (withoutTrashed). <br/>
     *                               <b>TRUE</b>: Get only Models that have been soft-deleted (onlyTrashed). <br/>
     *                               <b>NULL</b>: Get all Models including soft-deleted (withTrashed).
     *                               </p>
     * @return int Number of Models.
     * @throws DatabaseException Thrown if the query has an error.
     */
    public function count(array|Closure $where = [], bool|null $inTrash = false): int
    {
        try {
            $query = $this->model->newQuery();
            // where / with / inTrash
            $query = $this->setWhere($query, $where, [], $inTrash);
            // return
            return $query->count();
        }
        catch (Throwable $e) {
            $this->logErrorQuery($e);
            throw new DatabaseException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Create a new Model record in the database and return the Model instance.
     *
     * @param array $attributes <p>This Model attributes. <br/>
     *                          <b>['column_a' => 'A', 'column_b' => 20, ...]</b>
     *                          </p>
     * @param bool  $quietly    [optional] <p>flag quietly when Models are affected (default: FALSE). <br/>
     *                          Options: <br/>
     *                          <b>FALSE</b>: Save the model and continue with its events. <br/>
     *                          <b>TRUE</b>: Save the model <b>WITHOUT RAISING MODEL EVENTS</b>.
     *                          </p>
     * @return Model The Model instance.
     * @throws DatabaseException Thrown if the query has an error.
     */
    public function create(array $attributes, bool $quietly = false): Model
    {
        try {
            $query = $this->model->newQuery();
            if ($quietly) {
                return method_exists($query, 'createQuietly')
                    ? $query->createQuietly($attributes)
                    : Model::withoutEvents(fn() => $query->create($attributes));
            }
            else {
                return $query->create($attributes);
            }
        }
        catch (Throwable $e) {
            $this->logErrorQuery($e);
            throw new DatabaseException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Create multiple new Model records in the database.
     * (create Models using loop for each element)
     *
     * @param array $attributes <p>Attributes of Model. <br/>
     *                          array attributes: <br/>
     *                          <b>['column_a' => 'A', 'column_b' => 20, ...]</b> <br/>
     *                          or <br/>
     *                          multi array attributes: <br/>
     *                          <b>[['column_a' => 'A', 'column_b' => 20, ...], ['column_a' => 'B', 'column_b' => 30, ...] ...]</b>
     *                          </p>
     * @param bool  $quietly    [optional] <p>flag quietly when Models are affected (default: FALSE). <br/>
     *                          Options: <br/>
     *                          <b>FALSE</b>: Save the model and continue with its events. <br/>
     *                          <b>TRUE</b>: Save the model <b>WITHOUT RAISING MODEL EVENTS</b>.
     *                          </p>
     * @return int Number of Models affected.
     * @throws DatabaseException Thrown if the query has an error.
     */
    public function createMany(array $attributes, bool $quietly = false): int
    {
        try {
            if (empty($attributes)) {
                return 0;
            }

            if (!is_array(reset($attributes))) {
                $attributes = [$attributes];
            }

            $count = 0;
            $query = $this->model->newQuery();
            foreach ($attributes as $attribute) {
                if ($quietly) {
                    if (Model::withoutEvents(fn() => $query->create($attributes))) {
                        $count++;
                    }
                }
                else {
                    if ($query->create($attribute)) {
                        $count++;
                    }
                }
            }

            return $count;
        }
        catch (Throwable $e) {
            $this->logErrorQuery($e);
            throw new DatabaseException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Insert multiple new Model records in the database.
     * (use Model's insert new record function)
     *
     * @param array $attributes <p>Attributes of Model. <br/>
     *                          array attributes: <br/>
     *                          <b>['column_a' => 'A', 'column_b' => 20, ...]</b> <br/>
     *                          or <br/>
     *                          multi array attributes: <br/>
     *                          <b>[['column_a' => 'A', 'column_b' => 20, ...], ['column_a' => 'B', 'column_b' => 30, ...] ...]</b>
     *                          </p>
     * @return bool TRUE: Success, FALSE: failed.
     * @throws DatabaseException Thrown if the query has an error.
     */
    public function insertMany(array $attributes): bool
    {
        try {
            return $this->model->newQuery()->insert($attributes);
        }
        catch (Throwable $e) {
            $this->logErrorQuery($e);
            throw new DatabaseException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Update the specified Model record in the database.
     *
     * @param int|string|Model $target     <p>The Model instance or primary key value.</p>
     * @param array            $attributes <p>Attributes of this Model need modification. <br/>
     *                                     <b>['column_a' => 'A', 'column_b' => 20, ...]</b>
     *                                     </p>
     * @param bool             $quietly    [optional] <p>flag quietly when Models are affected (default: FALSE). <br/>
     *                                     Options: <br/>
     *                                     <b>FALSE</b>: Save the model and continue with its events. <br/>
     *                                     <b>TRUE</b>: Save the model <b>WITHOUT RAISING MODEL EVENTS</b>.
     *                                     </p>
     * @param bool|null        $inTrash    [optional] <p>Use Trashed for Model's query (default: FALSE). <br/>
     *                                     <b>FALSE</b>: Update only Model that are not soft-deleted (withoutTrashed). <br/>
     *                                     <b>TRUE</b>: Update only Model that have been soft-deleted (onlyTrashed). <br/>
     *                                     <b>NULL</b>: Update all Model including soft-deleted (withTrashed).
     *                                     </p>
     * @return bool TRUE: Success, FALSE: failed.
     * @throws DatabaseException Thrown if the query has an error.
     */
    public function update(int|string|Model $target, array $attributes, bool $quietly = false, bool|null $inTrash = false): bool
    {
        try {
            if ($target instanceof Model) {
                $model = $target;
            }
            else {
                $query = $this->model->newQuery();
                $query = $this->setWhere($query, [], [], $inTrash);
                $model = $query->find($target);
            }

            if (!empty($model)) {
                return $quietly
                    ? $model->updateQuietly($attributes)
                    : $model->update($attributes);
            }
            return false;
        }
        catch (Throwable $e) {
            $this->logErrorQuery($e);
            throw new DatabaseException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Update the specified Model records in the database.
     * (find by input conditions)
     * (CAUTION: This function updates multiple records)
     *
     * @param array|Closure $where      <p>The conditions to search in the query. If empty, WILL UPDATE ALL RECORDS.</p>
     * @param array         $attributes <p>Attributes of this Model need modification. <br/>
     *                                  <b>['column_a' => 'A', 'column_b' => 20, ...]</b>
     *                                  </p>
     * @param bool          $quietly    [optional] <p>flag quietly when Models are affected (default: FALSE). <br/>
     *                                  Options: <br/>
     *                                  <b>FALSE</b>: Save the model and continue with its events. <br/>
     *                                  <b>TRUE</b>: Save the model <b>WITHOUT RAISING MODEL EVENTS</b>.
     *                                  </p>
     * @param bool|null     $inTrash    [optional] <p>Use Trashed for Model's query (default: FALSE). <br/>
     *                                  <b>FALSE</b>: Update only Models that are not soft-deleted (withoutTrashed). <br/>
     *                                  <b>TRUE</b>: Update only Models that have been soft-deleted (onlyTrashed). <br/>
     *                                  <b>NULL</b>: Update all Models including soft-deleted (withTrashed).
     *                                  </p>
     * @return int Number of Models affected.
     * @throws DatabaseException Thrown if the query has an error.
     */
    public function updateMany(array|Closure $where, array $attributes, bool $quietly = false, bool|null $inTrash = false): int
    {
        try {
            $query = $this->model->newQuery();
            $query = $this->setWhere($query, $where, [], $inTrash);
            $models = $query->get();

            $count = 0;
            foreach ($models as $model) {
                if ($quietly) {
                    if ($model->updateQuietly($attributes)) {
                        $count++;
                    }
                }
                else {
                    if ($model->update($attributes)) {
                        $count++;
                    }
                }
            }
            return $count;
        }
        catch (Throwable $e) {
            $this->logErrorQuery($e);
            throw new DatabaseException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Delete the specified Model record in the database.
     *
     * @param int|string|Model $target  <p>The Model instance or primary key value.</p>
     * @param bool             $quietly [optional] <p>flag quietly when Models are affected (default: FALSE). <br/>
     *                                  Options: <br/>
     *                                  <b>FALSE</b>: Delete the model and continue with its events. <br/>
     *                                  <b>TRUE</b>: Delete the model <b>WITHOUT RAISING MODEL EVENTS</b>.
     *                                  </p>
     * @param bool|null        $inTrash [optional] <p>Use Trashed for Model's query (default: FALSE). <br/>
     *                                  <b>FALSE</b>: Delete only Model that are not soft-deleted (withoutTrashed). <br/>
     *                                  <b>TRUE</b>: Delete only Model that have been soft-deleted (onlyTrashed). <br/>
     *                                  <b>NULL</b>: Delete all Model including soft-deleted (withTrashed).
     *                                  </p>
     * @return bool TRUE: Success, FALSE: failed.
     * @throws DatabaseException Thrown if the query has an error.
     */
    public function delete(int|string|Model $target, bool $quietly = false, bool|null $inTrash = false): bool
    {
        try {
            if ($target instanceof Model) {
                $model = $target;
            }
            else {
                $query = $this->model->newQuery();
                $query = $this->setWhere($query, [], [], $inTrash);
                $model = $query->find($target);
            }

            if (!empty($model)) {
                $isDeleted = $quietly
                    ? $model->deleteQuietly()
                    : $model->delete();
                return is_null($isDeleted) ? true : $isDeleted;
            }
            return false;
        }
        catch (Throwable $e) {
            $this->logErrorQuery($e);
            throw new DatabaseException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Delete the specified Model records in the database.
     * (find by input conditions)
     * (CAUTION: This function deletes multiple records)
     *
     * @param array|Closure $where   <p>The conditions to search in the query. <br/><b>IF EMPTY, WILL DELETE ALL RECORDS</b>.</p>
     * @param bool          $quietly [optional] <p>flag quietly when Models are affected (default: FALSE). <br/>
     *                               Options: <br/>
     *                               <b>FALSE</b>: Delete the model and continue with its events. <br/>
     *                               <b>TRUE</b>: Delete the model <b>WITHOUT RAISING MODEL EVENTS</b>.
     *                               </p>
     * @param bool|null     $inTrash [optional] <p>Use Trashed for Model's query (default: FALSE). <br/>
     *                               <b>FALSE</b>: Delete only Models that are not soft-deleted (withoutTrashed). <br/>
     *                               <b>TRUE</b>: Delete only Models that have been soft-deleted (onlyTrashed). <br/>
     *                               <b>NULL</b>: Delete all Models including soft-deleted (withTrashed).
     *                               </p>
     * @return int Number of Models deleted.
     * @throws DatabaseException Thrown if the query has an error.
     */
    public function deleteMany(array|Closure $where, bool $quietly = false, bool|null $inTrash = false): int
    {
        try {
            $query = $this->model->newQuery();
            $query = $this->setWhere($query, $where, [], $inTrash);
            $models = $query->get();

            $count = 0;
            foreach ($models as $model) {
                if ($quietly) {
                    if ($model->deleteQuietly()) {
                        $count++;
                    }
                }
                else {
                    if ($model->delete()) {
                        $count++;
                    }
                }
            }
            return $count;
        }
        catch (Throwable $e) {
            $this->logErrorQuery($e);
            throw new DatabaseException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Force a hard delete on a soft deleted Model in the database.
     *
     * @param int|string|Model $target  <p>The Model instance or primary key value.</p>
     * @param bool             $quietly [optional] <p>flag quietly when Models are affected (default: FALSE). <br/>
     *                                  Options: <br/>
     *                                  <b>FALSE</b>: Delete the model and continue with its events. <br/>
     *                                  <b>TRUE</b>: Delete the model <b>WITHOUT RAISING MODEL EVENTS</b>.
     *                                  </p>
     * @return bool TRUE: Success, FALSE: failed.
     * @throws DatabaseException Thrown if the query has an error.
     */
    public function forceDelete(int|string|Model $target, bool $quietly = false): bool
    {
        try {
            if ($target instanceof Model) {
                $model = $target;
            }
            else {
                $query = $this->model->newQuery();
                if ($this->hasSoftDeletes()) {
                    $query->withTrashed();
                }
                $model = $query->find($target);
            }

            if (!empty($model)) {
                $isDeleted = $quietly
                    ? (
                    method_exists($model, 'forceDeleteQuietly')
                        ? $model->forceDeleteQuietly()
                        : Model::withoutEvents(fn() => $model->forceDelete())
                    )
                    : $model->forceDelete();
                return is_null($isDeleted) ? true : $isDeleted;
            }
            return false;
        }
        catch (Throwable $e) {
            $this->logErrorQuery($e);
            throw new DatabaseException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Destroy the specified model records in the database.
     * (CAUTION: This function destroy multiple records)
     *
     * @param int|string|Model|array $target <p>The Model instance or primary key values.</p>
     * @return int Number of Models destroyed
     * @throws DatabaseException Thrown if the query has an error.
     */
    public function destroy(int|string|Model|array $target): int
    {
        try {
            if ($target instanceof Model) {
                $target = $target->{$target->getKeyName()};
            }

            $ids = is_array($target) ? $target : Arr::wrap($target);
            if (count($ids) === 0) {
                return 0;
            }

            return $this->model->destroy($ids);
        }
        catch (Throwable $e) {
            $this->logErrorQuery($e);
            throw new DatabaseException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Check if the Model uses SoftDeletes.
     *
     * @return bool TRUE: exist, FALSE: does not exist.
     */
    protected function hasSoftDeletes(): bool
    {
        return in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses($this->model));
    }

    /**
     * Set Where conditions to Query Builder.
     *
     * @param Model|Builder $query   <p>Query Builder instance.</p>
     * @param Closure|array $where   [optional] <p>The conditions to search in the query. <br/>
     *                               Options: <br/>
     *                               <b>$where = function(){}</b> -> is Closure.<br/>
     *                               <b>$where = [0 => function(){}]</b> -> is Closure in array. <br/>
     *                               <b>$where = ['key' => 'value']</b> -> is normal array. <br/>
     *                               <b>$where = [0 => ['key', '>=', 'value']]</b> -> is array containing the array of conditions. <br/>
     *                               <b>$where = ['key' => ['value1', 'value2', ...]]</b> -> is array contains array of values (equal to <b>whereIn</b>). <br/>
     *                               </p>
     * @param array         $withs   [optional] <p>The Relationships need to be loaded. <br/>
     *                               Options: <br/>
     *                               <b>$withs = ['relationship_name']</b> -> Relationship is string. <br/>
     *                               <b>$withs = [['relationship_name1', 'relationship_name2',...]]</b> -> Relationship is array. <br/>
     *                               <b>$withs = ['relationship_name' => function(){}]</b> -> Relationship is Closure.
     *                               </p>
     * @param bool|null     $inTrash [optional] <p>Use Trashed for Model's query (default: FALSE). <br/>
     *                               <b>FALSE</b>: Get only Models that are not soft-deleted (withoutTrashed). <br/>
     *                               <b>TRUE</b>: Get only Models that have been soft-deleted (onlyTrashed). <br/>
     *                               <b>NULL</b>: Get all Models including soft-deleted (withTrashed).
     *                               </p>
     * @return Model|Builder Builder: Query Builder after applying conditions.
     */
    protected function setWhere(Model|Builder $query, Closure|array $where = [], array $withs = [], bool|null $inTrash = false): Model|Builder
    {
        // where
        if (!empty($where)) {
            // `$where is Closure()
            if ($where instanceof Closure) {
                $query->where($where);
            }
            // $where is array()
            else {
                foreach ($where as $key => $item) {
                    // $item is Closure()
                    if ($item instanceof Closure) {
                        // $where has the form: [0 => Closure()]
                        $query->where($item);
                    }
                    elseif (is_array($item)) {
                        // $key is string
                        if (is_string($key)) {
                            // $where has the form: ['key' => ['value1', 'value2', ...]]
                            $query->whereIn($key, $item);
                        }
                        // $key is integer
                        else {
                            // $where has the form: [['key', '=', 'value']]
                            $query->where([$item]);
                        }
                    }
                    else {
                        // $where has the form: ['key' => 'value']
                        $query->where([$key => $item]);
                    }
                }
            }
        }

        // relationship
        foreach ($withs as $key => $item) {
            if ($item instanceof Closure) {
                $query->with($key, $item);
            }
            else {
                $query->with($item);
            }
        }

        // inTrash
        if ($this->hasSoftDeletes()) {
            if ($inTrash === true) {
                $query->onlyTrashed();
            }
            elseif ($inTrash === false) {
                $query->withoutTrashed();
            }
            else {
                $query->withTrashed();
            }
        }
        else {
            if ($inTrash === true) {
                // tricks: only searching in the Trash but the Model does not use SoftDeletes.
                $query->whereRaw('0 = 1');
            }
        }

        return $query;
    }

    /**
     * Set Order By to Query Builder.
     *
     * @param Builder $query   <p>Query Builder instance.</p>
     * @param array   $options [optional] <p>Query extended parameter. <br/>
     *                         <b>['sort' => 'id', 'sort_type' => 'asc']</b> <br/>
     *                         Expand: If you want to sort from two or more elements, put in the following list. <br/>
     *                         structure: ['sorts' => ['column_key' => 'sort_type', ...]] <br/>
     *                         example: <b>['sorts' => ['column_a' => 'asc', 'column_b' => 'desc']]</b> <br/>
     *                         <b>NOTE: when 'sorts' is specified, 'sort' and 'sort_type' are not used.</b>
     *                         </p>
     * @return Builder Builder: Query builder after applying orderBy.
     */
    protected function setOrderBy(Builder $query, array $options = []): Builder
    {
        $sort = $this->getElementData($options, 'sort');
        $sortType = $this->getElementData($options, 'sort_type');
        $sorts = $this->getElementData($options, 'sorts');

        if (is_array($sorts) && count($sorts)) {
            foreach ($sorts as $column => $type) {
                $query->orderBy($column, $type);
            }
        }
        else {
            $query->orderBy($sort, $sortType);
        }
        return $query;
    }

    /**
     * Log Error Query.
     *
     * @param Throwable $e Exception object.
     */
    protected function logErrorQuery(Throwable $e): void
    {
        $connName = DB::getName();
        if ($e instanceof QueryException) {
            $query = Str::replaceArray('?', $e->getBindings(), $e->getSql());
        }
        else {
            $queries = DB::getQueryLog();
            $query = !empty($queries) ? end($queries) : [];
            $query = !empty($query) ? Str::replaceArray('?', $query['bindings'], $query['query']) : '';
        }

        Log::error("[DB] ERROR QUERY LOGGER ({$connName})", [$query]);
    }
}
