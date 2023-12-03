<?php

namespace App\Console\Commands;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;
use Illuminate\Console\Command;
use Exception;

/**
 * Class CreateCrudClassesCommand
 * @package App\Console\Commands
 */
class CreateCrudClassesCommand extends Command
{
    /** @var string */
    protected $description = 'Create a new CRUD classes based on the model name';

    /** @var string */
    protected $signature = 'make:crud-classes {model} {--table=} {--filter}';

    /** @var string */
    protected $help = 'Make sure you write the Model class name in command argument';

    /** @var bool */
    protected $hidden = true;

    /**
     * Handle Command Line logic
     *
     * @return void
     */
    public function handle()
    {
        // Get the specified model class from command line.
        $model_name = ucfirst(strtolower($this->argument('model')));
        // Get the specified option value from command line.
        $table_name = strtolower($this->option('table'));
        // Get the specified option name from command line.
        $has_filters = $this->option('filter');

        try {
            // Create all required CRUD classes.
            $this->createCrudClasses($model_name);

            // Fill all defined attributes in the model and controller classes
            // by the migration file associated to the given table name.
            if ($table_name != null && $has_filters) {
                $this->fillObjectAttributes($model_name, $table_name, $has_filters);
            }

        } catch (Exception $exception) {
            $class_name = get_class($this);
            $this->error("Error while handle: {$class_name}\nError Line: " . $exception->getLine() . "\nError message: " . $exception->getMessage());
        }
    }

    /**
     * Create all required CRUD classes by the given model
     *
     * @param $modelName
     * @return void
     */
    protected function createCrudClasses($modelName): void
    {
        // Create Model class extended from BaseModel.
        $this->createModelClass($modelName);
        // Create Request class extended from MainRequest.
        $this->createRequestClass($modelName);
        // Create Repository Interface class.
        $this->createRepositoryInterfaceClass($modelName);
        // Create Repository class extended from BaseRepository.
        $this->createRepositoryClass($modelName);
        // Create Service class extended from BaseService.
        $this->createServiceClass($modelName);
        // Create Controller class extended from BaseCrudController.
        $this->createCrudControllerClass($modelName);
    }

    /**
     * Create controller class extended from BaseCrudController class
     *
     * @param $modelName
     * @return void
     */
    protected function createCrudControllerClass($modelName): void
    {
        $template = $this->getDefaultTemplate("Controller", $modelName);

        $file = app_path("Http/Controllers/Api/{$modelName}CrudController.php");

        $this->createFileWithContent($file, $template, $modelName . " Crud Controller");
    }

    /**
     * Get default template page based on the given behavior
     *
     * @param $behavior
     * @param $modelName
     * @param null $payload
     * @return string
     */
    protected function getDefaultTemplate($behavior, $modelName, $payload = null): string
    {
        switch ($behavior) {
            case 'Model':
                $template = "<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

/**
 * App\Models\\$modelName
 *
 * @property int \$id
 * @property Carbon|null \$created_at
 * @property Carbon|null \$updated_at
 * @method static Builder|$modelName newModelQuery()
 * @method static Builder|$modelName newQuery()
 * @method static Builder|$modelName query()
 * @method static Builder|$modelName whereId(\$value)
 * @method static Builder|$modelName whereCreatedAt(\$value)
 * @method static Builder|$modelName whereUpdatedAt(\$value)
 */
class $modelName extends BaseModel
{
    use HasFactory;
}
";
                break;

            case 'Request':
                $route = strtolower($modelName);
                $template = "<?php

namespace App\Http\Requests;

use App\Models\\{$modelName};

class {$modelName}Request extends MainRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        \$model = $modelName::where('id', \$this->route('{$route}'))->first();
        if (\$model)
            switch (\$this->method()) {
                case 'GET':
                case 'POST':
                case 'PUT':
                case 'PATCH':
                case 'DELETE':
                    break;
            }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch (\$this->method()) {
            case 'GET':
            case 'PATCH':
            case 'DELETE':
            case 'PUT':
            case 'POST':
            default:
                break;
        }
        return [];
    }
}
";
                break;

            case 'Controller':
                $template = "<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseCrudController;
use App\Http\Requests\\{$modelName}Request;
use App\Services\\{$modelName}Service;

class {$modelName}CrudController extends BaseCrudController
{
    /** @var string */
    protected string \$request = {$modelName}Request::class;

    /**
     * {$modelName}CrudController constructor.
     * @param {$modelName}Service \$service
     */
    public function __construct({$modelName}Service \$service)
    {
        parent::__construct(\$service);
    }
}";
                break;

            case 'RepositoryInterface':
                $template = "<?php

namespace App\Repositories;

interface {$modelName}RepositoryInterface
{
}
";
                break;

            case 'Repository':
                $template = "<?php

namespace App\Repositories\Eloquent;

use App\Repositories\\{$modelName}RepositoryInterface;
use App\Models\\$modelName;

class {$modelName}Repository extends BaseRepository implements {$modelName}RepositoryInterface
{
    /**
     * {$modelName}Repository constructor.
     * @param $modelName \$model
     */
    public function __construct($modelName \$model)
    {
        parent::__construct(\$model);
    }
}
";
                break;

            case 'Service':
                $template = "<?php

namespace App\Services;

use App\Repositories\Eloquent\\{$modelName}Repository;

class {$modelName}Service extends BaseService
{
    /**
     * {$modelName}Service constructor.
     * @param {$modelName}Repository \$repository
     */
    public function __construct({$modelName}Repository \$repository)
    {
        parent::__construct(\$repository);
    }
}";
                break;

            case 'Filter':
                $filter_name_cap = $payload['filter_name_cap'];
                $filter_name_kebab = $payload['filter_name_kebab'];
                $from_filter = $payload['from_filter'];
                $template = "<?php

namespace App\Filters\\{$modelName}s;

use App\Filters\Types\\$from_filter;

class {$filter_name_cap}Filter extends $from_filter
{
    public function __construct()
    {
        parent::__construct('$filter_name_kebab');
    }
}
";
                break;

            default:
                $template = "";
                break;
        }

        return $template;
    }

    /**
     * Create Repository Interface class
     *
     * @param $modelName
     * @return void
     */
    protected function createRepositoryInterfaceClass($modelName): void
    {
        $template = $this->getDefaultTemplate('RepositoryInterface', $modelName);

        $file = app_path("Repositories/{$modelName}RepositoryInterface.php");

        $this->createFileWithContent($file, $template, $modelName . " Repository Interface");
    }

    /**
     * Create Repository class extended from BaseRepository class
     *
     * @param $modelName
     * @return void
     */
    protected function createRepositoryClass($modelName): void
    {
        $template = $this->getDefaultTemplate('Repository', $modelName);

        $file = app_path("Repositories/Eloquent/{$modelName}Repository.php");

        $this->createFileWithContent($file, $template, $modelName . " Repository");
    }

    /**
     * Create service class extended from BaseCrudController class
     *
     * @param $modelName
     * @return void
     */
    protected function createServiceClass($modelName): void
    {
        $template = $this->getDefaultTemplate('Service', $modelName);

        $file = app_path("Services/{$modelName}Service.php");

        $this->createFileWithContent($file, $template, $modelName . " Service");
    }

    /**
     * Create request class extended from MainRequest class
     *
     * @param $modelName
     * @return void
     */
    protected function createRequestClass($modelName): void
    {
        $template = $this->getDefaultTemplate('Request', $modelName);

        $file = app_path("Http/Requests/{$modelName}Request.php");

        $this->createFileWithContent($file, $template, $modelName . " Request");
    }

    /**
     * Create a new model class extended from BaseModel
     *
     * @param $modelName
     * @return void
     */
    protected function createModelClass($modelName): void
    {
        $template = $this->getDefaultTemplate('Model', $modelName);

        $file = app_path("Models/{$modelName}.php");

        $this->createFileWithContent($file, $template, $modelName . " Model");
    }

    /**
     * Get attributes from migration file associated to the given table name
     * and fill the suitable attributes for both of model & controller classes.
     *
     * @param $modelName
     * @param $tableName
     * @param $hasFilters
     * @return void
     * @throws FileNotFoundException
     */
    protected function fillObjectAttributes($modelName, $tableName, $hasFilters): void
    {
        if ($hasFilters) {
            // Get defined filter for each column in the migration file.
            $filters = $this->getMigrationAttributes($tableName, 'Filter');

            if ($filters != []) {
                // Create filter class base on column datatype.
                $this->createFilterClass($modelName, $filters);
            } else {
                $this->alert("Attention !!!");
                $this->warn("Make Sure the migration file associated to the given table name is existing\nAnd fill it with your attributes.");
            }
        }
    }

    /**
     * Create new filter class based on the given datatype
     *
     * @param $modelName
     * @param array $filters
     * @return void
     */
    protected function createFilterClass($modelName, array $filters): void
    {
        foreach ($filters as $filterName => $filterDataType) {

            $payload['filter_name_kebab'] = $filterName;
            $payload['filter_name_cap'] = $filterName = kebabToFirstCapitalized($filterName);// (test_class) to (TestClass)
            $payload['from_filter'] = $this->checkNeededDataTypeFilter($filterDataType);

            $template = $this->getDefaultTemplate('Filter', $modelName, $payload);

            $file = app_path("Filters/{$modelName}s/{$filterName}Filter.php");

            $this->createFileWithContent($file, $template, $filterName . "Filter");

            try {
                if (File::exists($file)) {
                    $filterNames[] = $filterName . "Filter";

                    // \App\Filters\Types\BaseFilter::class
                    if (end($filters) === $filterDataType)
                        $this->createFiltersProperty($modelName, $this->defineFiltersArray("{$modelName}s", $filterNames));
                }
            } catch (Exception $exception) {
                $this->error('meow error');
            }
        }
    }

    /**
     * Return array of (keys: columns name) and (values: their datatype)
     *
     * @param $tableName
     * @param string $commentedAttribute
     * @return array
     * @throws FileNotFoundException
     */
    private function getMigrationAttributes($tableName, string $commentedAttribute): array
    {
        $files = File::files(database_path("migrations"));

        foreach ($files as $file) {

            // Read all lines from file.
            $contents = File::get($file);
            // Define search value.
            $search_value = "Schema::create('$tableName";
            // Remove the new line symbol from each line.
            $lines = explode("\n", $contents);

            // Search if the lines in the file has the defined search value.
            $table_existing = (bool)count(array_filter($lines, function ($bool) use ($search_value) {
                return str_contains($bool, $search_value) !== FALSE;
            }));

            if ($table_existing) {
                $comment = '';

                // Check if has the specified given datatype for each line.
                for ($i = 0; $i < count($lines); $i++) {

                    $line = trim($lines[$i]);

                    // First line (comment).
                    if (strpos($line, "/** $commentedAttribute") === 0) {
                        $comment .= substr($line, 2) . " ";

                        // Second line (statement).
                    } else if ($comment != '' && strpos($line, '$table->') === 0) {
                        // Match the datatype for each column.
                        preg_match_all("/table->(bigInteger|boolean|char|date|dateTime|decimal|double|enum|float|integer|longText|mediumText|smallInteger|string|text|time|timestamp|tinyInteger)\('(.*)'\)/", $line, $matches);
                        $column[] = array_combine($matches[2], $matches[1]);
                        $comment = "";

                        $columns = array_reduce($column, function ($carry, $item) {
                            return array_merge($carry, $item);
                        }, []);
                    }
                }
                break; // End file searching.
            }
        }
        return ($columns ?? []);
    }

    /**
     * Return needed filter type for the given datatype
     *
     * @param $dataType
     * @return string
     */
    private function checkNeededDataTypeFilter($dataType): string
    {
        $value_filter_data_types = ['bigInteger', 'tinyInteger', 'smallInteger', 'integer', 'mediumText', 'longText', 'text', 'string', 'char', 'decimal', 'double', 'enum', 'float', 'longText', 'mediumText'];
        $date_filter_data_types = ['date', 'dateTime', 'text', 'time', 'timestamp'];
        $boolean_filter_data_types = ['boolean'];

        if (in_array($dataType, $boolean_filter_data_types))
            $data_type_filter = 'BooleanFilter';

        if (in_array($dataType, $date_filter_data_types))
            $data_type_filter = 'DateFilter';

        if (in_array($dataType, $value_filter_data_types))
            $data_type_filter = 'ValueFilter';

        return $data_type_filter ?? '';
    }

    /**
     * Create file and put the given content into it.
     *
     * @param $file
     * @param string $template
     * @param string $className
     * @return void
     */
    private function createFileWithContent($file, string $template, string $className): void
    {
        if (!file_exists($file)) {

            file_put_contents($file, $template);

            $this->logSuccessInfo($className);
        } else {
            $this->logErrorInfo($className);
        }
    }

    /**
     * Write filter property inside model class
     *
     * @param string $modelName
     * @param string $filterClasses
     * @throws FileNotFoundException
     */
    private function createFiltersProperty(string $modelName, string $filterClasses): void
    {
        // Get the file content as a string.
        $fileContent = File::get(app_path("Models/{$modelName}.php"));

        $property = "
    /** @var array */
    protected array \$filters = [
        $filterClasses
    ];
    ";

        // Check if there's no filter attributes.
        if (!str_contains($fileContent, "protected array \$filters")) {
            $count = 1;
            // Replace the opening brace with the property and opening brace.
            $fileContent = str_replace('{', "{" . $property, $fileContent, $count);

            // Save the file.
            File::put(app_path("Models/{$modelName}.php"), $fileContent);
        }
    }

    /**
     * Return array that contains array of specific path to the filter class
     *
     * @param string $modelName
     * @param array $filterNames
     * @return string
     */
    private function defineFiltersArray(string $modelName, array $filterNames): string
    {
        $filters = '';

        foreach ($filterNames as $filterName) {
            $filters .= "\App\Filters\\$modelName\\$filterName::class,";
            if (end($filterNames) !== $filterName)
                $filters .= "\n";
        }

        return $filters;
    }

    /**
     * Log Success info message on the console window
     *
     * @param $className
     * @return void
     */
    private function logSuccessInfo($className): void
    {
        $this->info("$className class created successfully.");
    }

    /**
     * Log Error info message on the console window
     *
     * @param $className
     * @return void
     */
    private function logErrorInfo($className): void
    {
        $this->error("$className class already exists.");
    }
}
