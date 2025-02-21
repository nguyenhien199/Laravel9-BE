<?php

namespace App\Repositories\Core\Contracts;

use App\Exceptions\DatabaseException;
use Closure;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as ILengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Interface IBaseRepo
 *
 * @package App\Repositories\Core\Contracts
 */
interface IBaseRepo
{
    /**
     * Get Model instance.
     *
     * @return Model <p>The model being queried.</p>
     */
    public function getModel(): Model;

    /**
     * Get Auto Increment number.
     * (next the Primary value number)
     *
     * @return int|null Auto Increment number. <br/>
     *         Int: This is an Auto increment. <br/>
     *         null: The table has no Auto_increment definition.
     * @throws DatabaseException Thrown if the query has an error.
     */
    public function getAutoIncrement(): ?int;

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
    public function checkExistOnRelationship(int|string $id, array $tables): bool;

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
    public function find(int|string $id, array $columns = ['*'], array $withs = [], bool|null $inTrash = false): ?Model;

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
    public function findOrFail(int|string $id, array $columns = ['*'], array $withs = [], bool|null $inTrash = false): Model;

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
    public function getFirst(array|Closure $where = [], array $options = [], array $withs = [], bool|null $inTrash = false): ?Model;

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
    public function getFirstOrFail(array|Closure $where = [], array $options = [], array $withs = [], bool|null $inTrash = false): Model;

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
    public function findMany(int|string|array $ids, array $columns = ['*'], array $withs = [], bool|null $inTrash = false): EloquentCollection;

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
    public function getAll(array|Closure $where = [], array $options = [], array $withs = [], bool|null $inTrash = false): EloquentCollection;

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
    public function getLimit(array|Closure $where = [], array $options = [], array $withs = [], bool|null $inTrash = false): EloquentCollection;

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
    public function paginate(array|Closure $where = [], array $options = [], array $withs = [], bool|null $inTrash = false): ILengthAwarePaginator;

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
    public function count(array|Closure $where = [], bool|null $inTrash = false): int;

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
    public function create(array $attributes, bool $quietly = false): Model;

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
    public function createMany(array $attributes, bool $quietly = false): int;

    /**
     * Insert multiple new Model records in the database.
     * (use Model's Insert new record function)
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
    public function insertMany(array $attributes): bool;

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
    public function update(int|string|Model $target, array $attributes, bool $quietly = false, bool|null $inTrash = false): bool;

    /**
     * Update the specified Model records in the database.
     * (find by input conditions)
     * (CAUTION: This function updates multiple records)
     *
     * @param array|Closure $where      <p>The conditions to search in the query. <b>IF EMPTY, WILL UPDATE ALL RECORDS</b>.</p>
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
    public function updateMany(array|Closure $where, array $attributes, bool $quietly = false, bool|null $inTrash = false): int;

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
    public function delete(int|string|Model $target, bool $quietly = false, bool|null $inTrash = false): bool;

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
    public function deleteMany(array|Closure $where, bool $quietly = false, bool|null $inTrash = false): int;

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
    public function forceDelete(int|string|Model $target, bool $quietly = false): bool;

    /**
     * Destroy the specified model records in the database.
     * (CAUTION: This function destroy multiple records)
     *
     * @param int|string|Model|array $target <p>The Model instance or primary key values.</p>
     * @return int Number of Models destroyed
     * @throws DatabaseException Thrown if the query has an error.
     */
    public function destroy(int|string|Model|array $target): int;
}
