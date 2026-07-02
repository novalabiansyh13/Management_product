# Agent Instructions for management_product

This file provides guidelines for agentic coding agents operating in this repository.

## Project Overview

- **Framework**: CodeIgniter 4 (PHP 8.1+)
- **Application Type**: Product management system with categories, file uploads, Excel import/export, and PDF generation
- **Database**: MySQL/MariaDB (configured in app/Config/Database.php)
- **Testing**: PHPUnit 10.x

## Build/Lint/Test Commands

### Running Tests
```bash
# Run all tests
composer test
# OR
phpunit

# Run a single test file
phpunit tests/unit/HealthTest.php

# Run a specific test by name
phpunit --filter testIsDefinedAppPath

# Run tests with coverage
phpunit --coverage-html build/logs/html
```

### Code Quality
```bash
# PHP syntax check (available in CI4)
php spark lang

# Custom linting may be added; check composer.json scripts
```

## Code Style Guidelines

### General Principles
- Follow CodeIgniter 4 coding conventions
- Use PHP 8.1+ features when appropriate
- Keep controllers thin; delegate business logic to Models
- Use database transactions for multi-table operations

### Naming Conventions
| Element | Convention | Example |
|---------|------------|---------|
| Controllers | PascalCase, singular | `ProductController.php` |
| Models | PascalCase, singular with Model suffix | `ProductModel.php` |
| Views | snake_case directories | `product/index.php` |
| Methods | camelCase | `getProductById()` |
| Database tables | snake_case, plural | `products`, `categories` |
| Database columns | snake_case | `created_at`, `category_id` |
| Variables | camelCase | `$productModel`, `$filter` |
| Constants | UPPER_SNAKE_CASE | `DEFAULT_LIMIT` |

### File Structure
```
app/
├── Controllers/
│   ├── BaseController.php
│   ├── Product.php
│   ├── Category.php
│   ├── auth/
│   │   └── LoginController.php
├── Models/
│   ├── ProductModel.php
│   ├── CategoryModel.php
│   └── UserModel.php
├── Views/
│   ├── product/
│   │   ├── index.php
│   │   └── form.php
│   └── template/
│       ├── v_header.php
│       └── v_sidebar.php
└── Config/
    ├── Routes.php
    └── Database.php
```

### Imports and Namespaces
- Use explicit imports for external libraries
- Group imports logically within files
- Use fully qualified class names for built-in CodeIgniter classes when beneficial

```php
// Good
use App\Models\ProductModel;
use App\Models\CategoryModel;
use Hermawan\DataTables\DataTable;

// Use built-in classes directly
$db = \Config\Database::connect();
```

### Formatting and Indentation
- Use 4 spaces for indentation (no tabs)
- Opening brace on same line for classes/functions
- One blank line between method definitions
- Maximum line length: 120 characters (soft limit)

### Type Declarations
- Use return type declarations where clear
- Use nullable types with `?` prefix
- Use union types for multiple acceptable types

```php
public function getProduct(int $id): ?array
public function datatable(array $filter = [], ?int $limit = null, ?int $offset = null): object
```

### Controller Guidelines
- Extend `BaseController` (which extends `CodeIgniter\Controller`)
- Inject dependencies in constructor or initController
- Use dependency injection over service locator where possible

```php
class Product extends BaseController
{
    protected $productModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }
}
```

### Model Guidelines
- Extend `CodeIgniter\Model`
- Define `$table`, `$primaryKey`, `$allowedFields`
- Keep database queries in models
- Return formatted data from models, not raw query results

### Error Handling
- Use try-catch for operations that may fail
- Log errors with `log_message('error', ...)`
- Return meaningful error messages in JSON responses

```php
try {
    $result = $this->productModel->addData($data);
    return $this->response->setJSON(['status' => 'success']);
} catch (\Exception $e) {
    log_message('error', 'Add Product Error: ' . $e->getMessage());
    return $this->response->setJSON([
        'status' => 'error',
        'message' => 'Gagal menambah data'
    ]);
}
```

### Database Transactions
- Use transactions for multi-step operations
- Always check transStatus() after operations

```php
$this->db->transBegin();

$result = $this->productModel->addData($data);

if ($this->db->transStatus() === false) {
    $this->db->transRollback();
    return $this->response->setJSON(['status' => 'error']);
}
$this->db->transCommit();
```

### JSON Responses
- Use consistent response format
- Always include status field

```php
return $this->response->setJSON([
    'status' => 'success',
    'message' => 'Data berhasil disimpan'
]);
// OR
return $this->response->setJSON([
    'status' => 'error',
    'message' => 'Validasi gagal'
]);
```

### Validation
- Validate input before processing
- Check required fields explicitly or use CI4 Validation

### View Guidelines
- Use snake_case for view filenames
- Separate layouts (header/sidebar) into template/ directory
- Use CodeIgniter's view data format

```php
return view('product/index', [
    'title' => 'Data Produk',
    'products' => $products
]);
```

### Request/Response
- Use `$this->request->getPost()` for POST data
- Use `$this->request->getGet()` for GET data
- Use `$this->request->getFile('field')` for uploaded files
- Use `$this->response->setJSON()` for JSON responses
- Use `$this->response->setHeader()` for custom headers

### Routes
- Define routes in app/Config/Routes.php
- Use lowercase URI segments
- Group related routes

```php
$routes->group('products', function($routes) {
    $routes->get('', 'Product::index');
    $routes->post('add', 'Product::add');
    $routes->post('update/(:any)', 'Product::update/$1');
});
```

### Testing Guidelines
- Place tests in tests/ directory following CI4 structure
- Use `CodeIgniter\Test\CIUnitTestCase` as base class
- Name test files with Test.php suffix
- Use descriptive test method names

```php
use CodeIgniter\Test\CIUnitTestCase;

final class ProductModelTest extends CIUnitTestCase
{
    public function testAddProduct(): void
    {
        $model = new ProductModel();
        $result = $model->addData(['name' => 'Test', 'price' => 100]);
        $this->assertTrue($result > 0);
    }
}
```

### Security
- Never commit secrets, API keys, or credentials
- Use .env for configuration, not hardcoded values
- Use CSRF protection for forms (csrf_hash(), csrf_token())
- Sanitize user input before database queries
- Use parameterized queries (CodeIgniter handles this by default)

### Common Patterns

#### Datatable Response (for DataTables library)
```php
return DataTable::of($builder)
    ->setSearchableColumns(false)
    ->edit('created_at', function ($row) {
        return date('d F Y H:i:s', strtotime($row->created_at));
    })
    ->addNumbering('no', false)
    ->add('aksi', function ($row) {
        return '<button>Action</button>';
    })
    ->toJson(true);
```

#### File Upload
```php
$file = $this->request->getFile('file');
if ($file->isValid()) {
    $newName = $file->getRandomName();
    $file->move($path, $newName);
}
```

## Common Tasks

### Adding a New Feature
1. Create Model method in app/Models/
2. Add Controller method in app/Controllers/
3. Add Route in app/Config/Routes.php
4. Create View in app/Views/
5. Add test in tests/

### Database Migration
- Use CodeIgniter's migration system
- Place migrations in app/Database/Migrations/

### Adding a New Library
```bash
composer require vendor/package
```

## Environment Configuration

- Copy `env` to `.env` for local configuration
- Key settings in .env:
  - `app.baseURL`
  - `database.default.hostname`
  - `database.default.database`

## References

- [CodeIgniter 4 User Guide](https://codeigniter.com/user_guide/)
- [CodeIgniter 4 Forums](https://forum.codeigniter.com/)
- PHPUnit Documentation