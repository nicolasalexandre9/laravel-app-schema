<?php

namespace Nicolasalexandre9\LaravelAppSchema\Schema;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class AppSchema
 *
 * @category Laravel-app-schema
 * @package  Laravel-app-schema
 * @author   nicolas <nicolasalexandre9@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 */
class AppSchema
{
    /**
     * @var string
     */
    private string $directoryPath;

    /**
     * @var string
     */
    private string $filePath;

    /**
     * AppSchema construct
     */
    public function __construct()
    {
        $this->directoryPath = config('schema.models_directory_path');
        $this->filePath = config('schema.schema_file_path');
    }

    /**
     * @return void
     * @throws \ReflectionException
     * @throws \Doctrine\DBAL\Exception
     */
    public function createSchema(): void
    {
        $models = $this->getModels();
        $schema = collect();
        foreach ($models as $model) {
            $modelSchema = new ModelSchema(app($model));
            $schema->push($modelSchema->createSchema()->getSchema());
        }

        File::put($this->filePath, $schema->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * introspect all files present in path directory
     *
     * @return Collection
     */
    public function getModels(): Collection
    {
        $models = collect(File::allFiles($this->directoryPath))
            ->map(fn (SplFileInfo $file) => self::extractClass(file_get_contents($file->getRealPath())))
            ->filter(fn ($class) => self::isModel($class));

        return $models->values();
    }

    /**
     * @param string $content
     * @return string
     */
    public static function extractClass(string $content): string
    {
        $tokens = token_get_all($content);
        $namespace = '';
        $tokensLength = count($tokens);
        for ($i = 0; $i <= $tokensLength; $i++) {
            if (! isset($tokens[$i][0])) {
                continue;
            }
            if (T_NAMESPACE === $tokens[$i][0]) {
                $i += 2; // Skip namespace keyword and whitespace
                while (isset($tokens[$i]) && is_array($tokens[$i])) {
                    $namespace .= $tokens[$i][1];
                    $i++;
                }
            }
            if (T_CLASS === $tokens[$i][0] && T_WHITESPACE === $tokens[$i + 1][0] && T_STRING === $tokens[$i + 2][0]) {
                $i += 2; // Skip class keyword and whitespace
                $namespace .= '\\'.$tokens[$i][1];
                break;
            }
        }

        return $namespace;
    }

    /**
     * @param string $class
     * @return bool
     */
    public static function isModel(string $class): bool
    {
        if (class_exists($class)) {
            $reflection = new \ReflectionClass($class);

            return $reflection->isSubclassOf(Model::class) &&
                !$reflection->isAbstract();
        }

        return false;
    }
}
