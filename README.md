# laravel-app-schema
___

This package creates an export file with a collection of all models of your project. 
Each model is a collection which contains all attributes and relationships. 
The file will be created when the ``` php artisan serve ``` command is executed.

## Installation

### composer
```
composer require 'nicolasalexandre9/laravel-app-schema'
```

### Publish config file
```
php artisan vendor:publish --provider="Nicolasalexandre9\LaravelAppSchema\LaravelAppSchemaServiceProvider" --tag="config"
```

### configuration
```
[
    'models_directory_path' => app_path('Models'),
    'schema_file_path'      => base_path('.forestadmin-schema.json'),
]
```
It is possible to set 2 paths in “config/schema.php”:
- ```models_directory_path```, the models’ path. Default path: “app/Models”.
- ```schema_file_path```, the directory path where the json file is generated. Default path: root directory.

:warning: the file format is only .json

---

## Requirements

- Laravel >= 8.0
- PHP >= 8.0

---

## Example of schema file content:

```
[
    {
        "class": "App\\Models\\Album",
        "table": "albums",
        "attributes": {
            "id": {
                "autoIncrement": true,
                "type": "bigint",
                "nullable": false,
                "length": null
            },
            "file_id": {
                "autoIncrement": false,
                "type": "bigint",
                "nullable": true,
                "length": null
            },
            "label": {
                "autoIncrement": false,
                "type": "string",
                "nullable": false,
                "length": 255
            },
            ...
        },
        "relationships": [
            {
                "type": "BelongsTo",
                "method": "file",
                "class": "App\\Models\\File"
            }
        ]
    },
    ...
]
```

---

## Future features

This list presents the possible features which can be added to the package:

- Generate the json file as needed with a laravel command.
- Multi-tenant database support.
- Database type to PHP type casting.
- Personalise the collection with protected fields similar to laravel’s models logic ($cast, $attributes, $fillable).


___

## Testing

```
composer test
```
---

## License

This package is licenced under the [MIT License](https://opensource.org/licenses/MIT ).
