<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

/**
 * Class BaseModel
 * @package App\Models
 *
 * @property int $id
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Query\Builder|BaseModel whereId($value)
 * @method static Builder|BaseModel whereCreatedAt($value)
 * @method static Builder|BaseModel whereUpdatedAt($value)
 * @method static Builder|BaseModel whereDeletedAt($value)
 * @method static Builder|BaseModel withoutTrashed()
 * @method static Builder|BaseModel OnlyTrashed()
 * @method static Builder|BaseModel withTrashed()
 *
 * @mixin Builder
 */
class BaseModel extends Model
{
    /** @var string|null */
    public string|null $relatedToCurrentUser = null;

    /** @var array */
    protected array $searchableAttributes = [];

    /** @var array */
    protected array $manyToManyRelations = [];

    /** @var array */
    public array $appendsAttributes = [];

    /** @var array */
    public array $translatedAttributes = [];

    /** @var array */
    protected array $filters = [];

    /** @return array */
    public function getManyToManyRelations()
    {
        return $this->manyToManyRelations;
    }

    /**
     * @param $column
     * @return bool
     */
    public function hasColumn($column)
    {
        return $this
            ->getConnection()
            ->getSchemaBuilder()
            ->hasColumn($this->getTable(), $column);
    }

    /** @return array */
    public function getSearchableAttributes()
    {
        return $this->searchableAttributes;
    }

    /** @return array */
    public function getTableColumns()
    {
        return Schema::getColumnListing($this->getTable());
    }

    /**
     * Apply filter query
     *
     * @param Builder $builder
     * @param $filters
     */
    public function applyFilters(Builder &$builder, $filters)
    {
        // Loop on defined model filterable array.
        foreach ($this->filters as $filterClass) {
            //Resolving Filter.
            $filterClass = resolve($filterClass);
            //Applying Filter Functionality.
            $filterClass->apply($builder, $filters);
        }
    }
}
