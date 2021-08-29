<?php

namespace App\Services\Traits;

use Closure;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;

/**
 * This is just to provide IDE support for Builder methods on eloquent models
 *
 * @method static static create(array $attributes = [])
 * @method static static firstOrCreate(array $attributes, array $values = [])
 * @method static static updateOrCreate(array $attributes, array $values = [])
 * @method static static|null first($columns = ['*'])
 * @method static static|null find(int|string $id, $columns = ['*'])
 * @method static static[]|EloquentCollection get($columns = ['*'])
 * @method static Builder|static where(Closure|string|array $column, string $operator = null, string $value = null, string $boolean = 'and')
 * @method static Builder|static latest(string $column = null)
 * @method static Builder|static whereIn(string $column, array|Arrayable $values, string $boolean = 'and')
 * @method static Builder|static whereNotIn(string $column, array $values, string $boolean = 'and')
 * @method static Builder|static whereNull(string $columns, string $boolean = 'and', bool $not = false)
 * @method static Builder|static whereNotNull(string $columns, string $boolean = 'and')
 * @method static Builder|static whereHas(string $relation, Closure $callback = null, string $operator = '>=', int $count = 1)
 * @method static Builder|static whereDoesntHave(string $relation, Closure $callback = null)
 * @method static Builder|static doesntHave(string $relation, string $boolean = 'and', Closure $callback = null)
 * @method static Builder|static has(string $relation, string $operator = '>=', int $count = 1, string $boolean = 'and', Closure $callback = null)
 * @method static Builder|static whereJsonContains(string $column, string $value, string $boolean = 'and', bool $not = false)
 * @method static Builder|static whereBetween(string $column, array|Arrayable $values, string $boolean = 'and', bool $not = false)
 * @method static Builder|static inRandomOrder($seed = '')
 * @method static Builder|static newModelQuery()
 * @method static Builder|static newQuery()
 * @method static Builder|static query()
 * @method static Collection pluck(string $column, string $key = null)
 * @method static LazyCollection|static[] cursor()
 * @method static Builder|static select(string|array ...$columns)
 * @method static Builder|static orderBy(string $column, string $direction = 'asc')
 * @method static Builder|static join(string $table, string|Closure $first, string $operator = null, string $second = null, string $type = 'inner', bool $where = false)
 */
trait EloquentBuilderMixin
{
}
