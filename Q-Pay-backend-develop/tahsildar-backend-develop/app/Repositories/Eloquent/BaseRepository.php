<?php

namespace App\Repositories\Eloquent;

use App\Services\Facade\TranslationServiceFacade as TranslationService;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Definitions\RelationTypes;
use App\Definitions\JoinTypes;
use App\Models\BaseModel;
use Carbon\Carbon;

class BaseRepository implements RepositoryInterface
{
    /** @var BaseModel */
    protected BaseModel $model;

    /**
     * BaseRepository constructor.
     *
     * @param BaseModel $model
     */
    public function __construct(BaseModel $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $columns
     * @param array $relations
     * @param int $length
     * @param array|string[] $sortKeys
     * @param array|string[] $sortDir
     * @param array $filters
     * @param array $searchableFields
     * @param string|null $search
     * @param bool $searchInRelation
     * @param int $withTrash
     * @param array $joinsArray
     * @param bool $isPaginate
     */
    public function all(
        array $columns = [],
        array $relations = [],
        int $length = 10,
        array $sortKeys = ['id'],
        array $sortDir = ['DESC'],
        array $filters = [],
        array $searchableFields = [],
        string $search = null,
        bool $searchInRelation = false,
        int $withTrash = 0,
        array $joinsArray = [],
        bool $isPaginate = true
    )
    {
        // Prepare basic query instance.
        $query = $this->prepareQuery();

        // Apply filter on model attribute.
        $this->model->applyFilters($query, $filters);

        // Get model column names.
        $modelAttributes = count($columns) ? $columns : $this->model->getTableColumns();

        // Set model attributes prefixed by table name.
        $selectedModelAttributes = $this->prepareSelectedModelAttributes($modelAttributes);

        foreach ($sortKeys as $sortKey) {
            array_push($selectedModelAttributes, $sortKey . " as " . str_replace(".", "_", $sortKey));
        }
        $selectedModelAttributes = array_unique($selectedModelAttributes);

        $this->applySelectWithQuery($query, $selectedModelAttributes, $relations);

        if ($withTrash) {
            $this->applyWithTrashed($query);
        }

        if (count($joinsArray)) {
            $this->joinaTbles($query, $joinsArray);
        }

        if ($search != null) {

            if (isset($searchableFields[class_basename($this->model)])) {

                $searchableAttributes = $searchableFields[class_basename($this->model)];
                unset($searchableFields[class_basename($this->model)]);
                $relations = $searchableFields;

            } else {
                $searchableAttributes = $this->model->getTableColumns();
            }

            if ($searchInRelation) {
                $this->searchByLike($query, $search, $searchableAttributes, $relations);
            } else {
                $this->searchByLike($query, $search, $searchableAttributes);
            }

        }

        // Return paginated result.
        return $this->sortAndPaginate($query, $length, $sortKeys, $sortDir, $joinsArray,$isPaginate);
    }

    /**
     * @param $searchableFields
     * @return array
     */
    protected function prepareSearchableAttributes($searchableFields)
    {
        $searchableAttributes = [];

        foreach ($searchableFields as $model => $attributes) {
            foreach ($attributes as $attribute) {
                $tableName = $this->getTableName($model);
                $searchableAttributes[] = $tableName . "." . $attribute;
            }
        }

        return $searchableAttributes;
    }

    /**
     * Loop on each defines join relations in the CRUD Controller
     * And apply a join on tables.
     *
     * @param $data
     * @param array $joinsArray
     */
    protected function joinTables(&$data, array $joinsArray)
    {
        foreach ($joinsArray as $joinRelation) {

            if (isset($joinRelation['relation_type'])) {

                if ($joinRelation['relation_type'] == RelationTypes::ANOTHER_TO_ANOTHER_MODEL) {

                    $firstAliasTableName = getAliasTableName($joinRelation['first_table']);
                    $secondAliasTableName = getAliasTableName($joinRelation['second_table']);

                    $this->applyJoinQuery(
                        $data,
                        $joinRelation['join_type'],
                        $joinRelation['first_table'],
                        $secondAliasTableName,
                        $firstAliasTableName . '.' . $joinRelation['relation_key'],
                        $secondAliasTableName . '.id'
                    );
                }

            } else {
                $aliasTableName = getAliasTableName($joinRelation['table']);

                $this->applyJoinQuery(
                    $data,
                    $joinRelation['join_type'],
                    $joinRelation['table'],
                    $aliasTableName,
                    $this->model->getTable() . "." . $joinRelation['relation_key'],
                    $aliasTableName . '.id'
                );
            }
        }
    }

    /**
     * @param $data
     * @param string $tableName
     * @param string $joinType
     * @param string $aliasTableName
     * @param string $firstKeyName
     * @param string $secondKeyName
     * @param string $operator
     * @return void
     */
    protected function applyJoinQuery(
        &$data,
        string $joinType,
        string $tableName,
        string $aliasTableName,
        string $firstKeyName,
        string $secondKeyName,
        string $operator = '='
    )
    {
        if (in_array($joinType, JoinTypes::STATUS)) {

            $data = $data->$joinType(
                $tableName . " as " . $aliasTableName, // first alias table name.
                $firstKeyName, // first join key.
                $operator, // operator.
                $secondKeyName // second join key.
            );
        }
    }

    /**
     * @param $column
     * @param $columnValue
     * @param $payload
     * @return mixed
     */
    public function updateBy($column, $columnValue, $payload)
    {
        $model = $this->getBy($column, $columnValue)->first();

        if ($model) {
            $model->update($payload);
        }
        return $model;
    }

    /**
     * @param string $tableName
     * @param string $columnName
     * @param array $columnsValue
     * @param array $payload
     * @return int
     */
    public function updateWhereIn(
        string $tableName,
        string $columnName,
        array $columnsValue,
        array $payload
    )
    {
        return DB::table($tableName)
            ->whereIn($columnName, $columnsValue)
            ->update($payload);
    }

    /**
     * @param $modelAttributes
     * @return string[]
     */
    protected function prepareSelectedModelAttributes($modelAttributes)
    {
        return array_map(function ($element) {
            return $this->model->getTable() . "." . $element;
        }, $modelAttributes);
    }

    /**
     * @param $query
     * @param $selectedModelAttributes
     * @param $relations
     * @return mixed
     */
    protected function applySelectWithQuery(&$query, $selectedModelAttributes, $relations)
    {
        return $query = $query->select($selectedModelAttributes)->with($relations)->distinct();
    }

    /**
     * @return Builder
     */
    protected function prepareQuery(): Builder
    {
        return $this->model->query();
    }

    /**
     * Return table name by the given model name
     *
     * @param $modelName
     * @return string
     */
    private function getTableName($modelName)
    {
        return strtolower($modelName) . "s";
    }

    /**
     * @param $data
     * @return void
     */
    protected function applyWithTrashed(&$data)
    {
        $data = $data->withTrashed()->whereNotNull($this->model->getTable() . '.deleted_at');
    }

    /**
     * Get all trashed models.
     *
     * @return Collection
     */
    public function allTrashed()
    {
        return $this->model->onlyTrashed()->get();
    }

    /**
     * @param int $modelId
     * @param array|string[] $columns
     * @param array $relations
     * @param array $appends
     * @param array $withoutRelations
     * @param bool $noEagerLoading
     * @return BaseModel|null
     */
    public function findById(
        int $modelId,
        array $columns = ['*'],
        array $relations = [],
        array $appends = [],
        array $withoutRelations = [],
        bool $noEagerLoading = false
    ): ?BaseModel
    {
        $model = $this->model->select($columns);
        if ($noEagerLoading)
            $model = $model->setEagerLoads([]);
        return $model->without($withoutRelations)->with($relations)->findOrFail($modelId)->append($appends);
    }

    /**
     * Find trashed model by id.
     *
     * @param int $modelId
     * @return BaseModel|null
     */
    public function findTrashedById(int $modelId): ?BaseModel
    {
        return $this->model->withTrashed()->findOrFail($modelId);
    }

    /**
     * Find only trashed model by id.
     *
     * @param int $modelId
     * @return BaseModel|null
     */
    public function findOnlyTrashedById(int $modelId): ?BaseModel
    {
        return $this->model->onlyTrashed()->findOrFail($modelId);
    }

    /**
     * Create a model.
     *
     * @param array $payload
     * @return BaseModel|null
     */
    public function create(array $payload): ?BaseModel
    {
        $payload = TranslationService::getAllTranslationKey($this->model->translatedAttributes ?? [], $payload);

        //Get Many To Many relations Data from Payload.
        $manyToManyRelationsData = $this->getModelRelations($payload);

        //Extract All Files Data From Payload (ex: images, videos, attachments).
        $files = $this->extractFilesData($payload);

        if (!$this->model->translatedAttributes) {
            unset($payload['en']);
            unset($payload['ar']);
        }
        $relatedToCurrentUser = $this->model->relatedToCurrentUser;
        if ($this->model->relatedToCurrentUser)
            $payload[$relatedToCurrentUser] = auth()->id();

        $model = $this->model->create($payload);

        //Sync every(many to many) relation with its data from payload.
        foreach ($manyToManyRelationsData as $key => $value)
            $model->{$key}()->sync($value);


        //Assign Files Data To Current Model.
        if ($files)
            $this->assignFilesToModel($model, $files);

        return $model->fresh();
    }

    /**
     * @param int $modelId
     * @param array $payload
     * @param array $option
     * @return BaseModel|null
     */
    public function update(int $modelId, array $payload, array $option = [])
    {
        $model = $this->findById($modelId);

        $payload = TranslationService::getAllTranslationKey($this->model->translatedAttributes ?? [], $payload);

        //Get Many To Many relations Data from Payload.
        $manyToManyRelationsData = $this->getModelRelations($payload);

        //Extract All Files Data From Payload (ex: images, videos, attachments).
        $files = $this->extractFilesData($payload);

        if (!$this->model->translatedAttributes) {
            unset($payload['en']);
            unset($payload['ar']);
        }

        $model->update($payload, $option);

        //Sync every(many to many) relation with its data from payload.
        foreach ($manyToManyRelationsData as $key => $value)
            $model->{$key}()->sync($value);

        //Assign Files Data To Current Model.
        if ($files)
            $this->assignFilesToModel($model, $files);

        return $this->findById($modelId, ['*'], [], [], [], false);
    }

    /**
     * Delete model by id.
     *
     * @param int $modelId
     * @return bool
     */
    public function deleteById(int $modelId): bool
    {
        return $this->findById($modelId)->delete();
    }

    /**
     * @param int $modelId
     * @param $relation
     * @param $modelColumnName
     * @return int
     */
    public function detachRelation(int $modelId, $relation, $modelColumnName)
    {
        $tableName = $relation->getTable();
        // delete the relation.
        return DB::table($tableName)->where($modelColumnName, $modelId)->delete();
    }

    /**
     * @param array $modelIds
     * @param $relation
     * @param $modelColumnName
     * @return int
     */
    public function detachRelations(array $modelIds, $relation, $modelColumnName)
    {
        $tableName = $relation->getTable();
        // delete the relation.
        return DB::table($tableName)->whereIn($modelColumnName, $modelIds)->delete();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function applySoftDelete(int $id)
    {
        $model = $this->findById($id);

        $model->deleted_at = Carbon::now();

        return $model->save();
    }

    /**
     * Restore model by id.
     *
     * @param int $modelId
     * @return bool
     */
    public function restoreById(int $modelId): bool
    {
        return $this->findOnlyTrashedById($modelId)->restore();
    }

    /**
     * Permanently delete model by id.
     *
     * @param int $modelId
     * @return bool
     */
    public function permanentlyDeleteById(int $modelId): bool
    {
        return $this->findTrashedById($modelId)->forceDelete();
    }

    /**
     * Count all
     * @return mixed
     */
    public function countAll()
    {
        return $this->model->count();
    }

    /**
     * Count all with trashed rows.
     *
     * @return mixed
     */
    public function countWithTrashed()
    {
        return $this->model->withTrashed()->count();
    }

    /**
     * get all model by custom values
     * @param $column
     * @param $value
     * @return mixed
     */
    public function getBy($column, $value)
    {
        return $this->model->where($column, $value)->get();
    }

    /**
     * @param $column
     * @param $value
     * @return mixed
     */
    public function deleteBy($column, $value)
    {
        return $this->model->where($column, $value)->delete();
    }

    /**
     * get all model by custom values
     * @param $column
     * @param $value
     * @return mixed
     */
    public function getElementBy($column, $value)
    {
        return $this->model->where($column, $value)->first();
    }

    /**
     * Create or update a model.
     *
     * @param array $payload
     * @return BaseModel|null
     */
    public function updateOrCreate(array $payload): ?Model
    {
        $model = $this->model->updateOrCreate($payload);

        return $model->fresh();
    }

    /**
     * @param $data
     * @param int $length
     * @param array|string[] $sortKeys
     * @param array|string[] $sortDir
     * @param array $joinsArray
     * @param bool $isPaginate
     */
    protected function sortAndPaginate(
        $data,
        int $length = 10,
        array $sortKeys = ['id'],
        array $sortDir = ['DESC'],
        array $joinsArray = [],
        bool $isPaginate = true
    )
    {
        $appendsAttributes = $this->model->appendsAttributes;

        //Get Model Attributes.
        $modelAttributes = $this->model->getTableColumns();

        //Get Model Translated Attributes.
        $translatedAttributes = $this->model->translatedAttributes;

        foreach ($sortKeys as $key => $sortKey) {
            if (in_array($sortKey, $modelAttributes)) {
                $data->orderBy($this->model->getTable() . '.' . $sortKey, $sortDir[$key] ?? 'ASC');
            }
            else if (in_array($sortKey, $translatedAttributes)) {
                $data->orderByTranslation($sortKey, $sortDir[$key] ?? 'ASC');
            }
            else {
                foreach ($joinsArray as $relation) {
                    // App\Model\{ModelName}.
                    $relationModel = resolve("App\Models\\" . getModelNameByTable($relation['table']));

                    // Get array of the current model attributes.
                    $relationModelAttributes = $relationModel->getTableColumns();

                    // Add for each of current model attributes a table alias name,
                    // in order to apply a sort on them (deep sort).
                    $relationModelAttributes = array_map(function ($element) use ($relation) {
                        return getAliasTableName($relation['table']) . "." . $element;
                    }, $relationModelAttributes);

                    // Apply sort on all attributes.
                    if (in_array($sortKey, $relationModelAttributes)) {
                        $data->orderBy($sortKey, $sortDir[$key] ?? 'ASC');
                    }
                }
            }
        }
        $sorted = false;
        if (count($appendsAttributes) > 0) {
            foreach ($sortKeys as $key => $sortKey) {
                if (in_array($sortKey, $appendsAttributes)) {
                    if ($sortDir[$key] == 'asc')
                        $data = $data->get()->sortBy($sortKey);
                    else
                        $data = $data->get()->sortByDesc($sortKey);
                    $sorted = true;
                }
            }
        }

        if ($isPaginate) {
            if ($sorted)
                return ['data' => $data->values()->take($length)->all(), 'total' => count($data->values())];
            else
                return $data->paginate($length);
        }
        return $data->get();

    }

    /**
     * @param $query
     * @param $columns
     * @param $keyword
     */
    public function search(&$query, $columns, $keyword)
    {
        // Apply search on columns.
        $query->where($columns[0], "%{$keyword}%");

        // Shifting the first element from the array.
        array_shift($columns);

        // Apply or where on array columns.
        foreach ($columns as $column) {
            $query = $query->orWhere($column, "%{$keyword}%");
        }
    }

    /**
     * @param $payload
     * @return array
     */
    private function getModelRelations(&$payload)
    {
        //Get Model (Many To Many) Relation Names.
        $modelRelations = $this->model->getManyToManyRelations();

        $relations = [];

        foreach ($modelRelations as $relation) {
            if (isset($payload[$relation])) {
                // Assign Relations values from payload.
                $relations[$relation] = $payload[$relation];
                // Unset Payload relations data => No need them in storing the model.
                unset($payload[$relation]);
            }
        }
        return $relations;
    }

    /**
     * @param $payload
     * @return array|mixed
     */
    private function extractFilesData(&$payload)
    {
        $files = $payload['files'] ?? [];

        if (isset($payload['files']))
            unset($payload['files']);

        return $files;
    }

    /**
     * @param BaseModel $model
     * @param $files
     */
    private function assignFilesToModel(BaseModel $model, $files)
    {
        foreach ($model->media as $media) {
            $media->update([
                'model_type' => 'App\Models\TempMedia',
            ]);
        }
        if ($files)
            Media::whereIn('id', $files)->update([
                'model_id' => $model->id,
                'model_type' => get_class($model),
                'collection_name' => 'default'
            ]);
    }

    /**
     * @param $data
     * @param mixed $search
     * @param array $searchableFields
     * @param array $relations
     * @return void
     */
    protected function searchByLike(&$data, $search, array $searchableFields, array $relations = [])
    {
        $thisTableName = $this->model->getTable();
        //Get Model Translated Attributes.
        $translatedAttributes = $this->model->translatedAttributes;


        $data = $data->where(function ($query) use ($search, $searchableFields, $relations, $thisTableName,$translatedAttributes) {

            foreach ($searchableFields as $key => $attribute) {
                if ($key === 0) {
                    if (in_array($attribute, $translatedAttributes))
                        $query->whereHas('translations', function ($query) use ($search, $attribute) {
                            $query->where($attribute, 'LIKE', "%{$search}%");
                        });
                    else
                        $query->where($thisTableName . "." . $attribute, 'LIKE', "%{$search}%");
                }
                else {
                    if (in_array($attribute, $translatedAttributes))
                        $query->whereHas('translations', function ($query) use ($search, $attribute) {
                            $query->orWhere($attribute, 'LIKE', "%{$search}%");
                        });
                    else
                        $query->orWhere($thisTableName . "." . $attribute, 'LIKE', "%{$search}%");
                }
            }

            if ($relations) {
                foreach ($relations as $key => $relationAttribute) {
                    $relation = $relationAttribute['name'];
                    $relationModel = resolve("App\Models\\" . $key);

                    $relationModelSearchableAttributes = $relations[$key]['attributes'] ?? $relationModel->getSearchableAttributes();

                    // Search in relation model attributes
                    if ($relationModelSearchableAttributes) {
                        $query->orWhereHas($relation, function ($query) use ($search, $relationModelSearchableAttributes, $relationModel) {
                            foreach ($relationModelSearchableAttributes as $key => $attribute) {
                                if ($key === 0)
                                    $query->where($relationModel->getTable() . "." . $attribute, 'LIKE', "%{$search}%");
                                else
                                    $query->orWhere($relationModel->getTable() . "." . $attribute, 'LIKE', "%{$search}%");
                            }
                        });
                    }
                }
            }
        });
    }

    /**
     * Sync Relations: delete the old relations in the pivot table and create the new ones.
     *
     * @param int $modelId
     * @param string $relationName
     * @param array $relationsPayload
     * @return void
     */
    public function syncRelations(int $modelId, string $relationName, array $relationsPayload)
    {
        $model = $this->findById($modelId);

        $model->$relationName()->sync($relationsPayload);
    }

    /**
     * Sync Relations: delete the old relations in the pivot table and create the new ones.
     * with the payload if they have.
     *
     * @param int $modelId
     * @param string $relation
     * @param array $relationsPayload
     * @param string $firstKey
     * @param string $secondKey
     * @param string|null $thirdKey
     * @return void
     */
    public function syncRelationsWithPayload(
        int $modelId,
        string $relation,
        array $relationsPayload,
        string $firstKey,
        string $secondKey,
        string $thirdKey = null
    )
    {
        $model = $this->findById($modelId);
        $payload = [];

        foreach ($relationsPayload as $item) {

            if (!$thirdKey) {
                $payload[$item[$firstKey]] = [$secondKey => isset($item[$secondKey]) ? $item[$secondKey] : null];
            } else {
                $payload[$item[$firstKey]] = [
                    $secondKey => isset($item[$secondKey]) ? $item[$secondKey] : null,
                    $thirdKey => isset($item[$thirdKey]) ? $item[$thirdKey] : null,
                ];
            }
        }
        $model->$relation()->sync($payload);
    }

    /**
     * Sync Relations: without delete the old relations in the pivot table and create the new ones.
     *
     * @param int $modelId
     * @param string $relation
     * @param $relationIds
     */
    public function syncRelationsWithoutDetachingByIds(int $modelId, string $relation, $relationIds)
    {
        $model = $this->findById($modelId);

        $model->$relation()->syncWithoutDetaching($relationIds);
    }

    /**
     * Return true if has specified role otherwise return false
     *
     * @param string $role
     * @return bool
     */
    public function checkAuthUserHasRole(string $role): bool
    {
        $authUser = Auth::user();
        if ($authUser->roles->first()->name != $role) {
            return false;
        }
        return true;
    }

    /**
     * Return true if has (deleted_at) column otherwise return false
     *
     * @return bool
     */
    public function checkModelHasSoftDelete()
    {
        if (!$this->model->hasColumn('deleted_at')) {
            return false;
        }
        return true;
    }
}
