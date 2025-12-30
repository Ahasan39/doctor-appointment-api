# Contributing to Doctor Appointment API

First off, thank you for considering contributing to Doctor Appointment API! It's people like you that make this project better.

## 📋 Table of Contents

- [Code of Conduct](#code-of-conduct)
- [Getting Started](#getting-started)
- [How Can I Contribute?](#how-can-i-contribute)
- [Development Process](#development-process)
- [Coding Standards](#coding-standards)
- [Commit Messages](#commit-messages)
- [Pull Request Process](#pull-request-process)

---

## 📜 Code of Conduct

This project and everyone participating in it is governed by our Code of Conduct. By participating, you are expected to uphold this code.

### Our Standards

- Be respectful and inclusive
- Accept constructive criticism gracefully
- Focus on what is best for the community
- Show empathy towards other community members

---

## 🚀 Getting Started

### Prerequisites

Before you begin, ensure you have:
- PHP 8.2 or higher
- Composer
- MySQL 5.7 or higher
- Git
- A code editor (VS Code, PHPStorm, etc.)

### Setting Up Development Environment

1. Fork the repository
2. Clone your fork:
   ```bash
   git clone https://github.com/your-username/doctor-appointment-api.git
   cd doctor-appointment-api
   ```

3. Install dependencies:
   ```bash
   composer install
   ```

4. Set up environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. Configure database and run migrations:
   ```bash
   php artisan migrate
   ```

6. Create a new branch:
   ```bash
   git checkout -b feature/your-feature-name
   ```

---

## 🤝 How Can I Contribute?

### Reporting Bugs

Before creating bug reports, please check existing issues. When creating a bug report, include:

- **Clear title and description**
- **Steps to reproduce**
- **Expected behavior**
- **Actual behavior**
- **Screenshots** (if applicable)
- **Environment details** (PHP version, OS, etc.)

**Bug Report Template:**

```markdown
**Description:**
A clear description of the bug.

**Steps to Reproduce:**
1. Go to '...'
2. Click on '...'
3. See error

**Expected Behavior:**
What you expected to happen.

**Actual Behavior:**
What actually happened.

**Environment:**
- PHP Version: 8.2.12
- Laravel Version: 12.x
- MySQL Version: 8.0
- OS: Windows/Linux/Mac
```

### Suggesting Enhancements

Enhancement suggestions are tracked as GitHub issues. When creating an enhancement suggestion, include:

- **Clear title and description**
- **Use case** - Why is this enhancement needed?
- **Proposed solution**
- **Alternative solutions** you've considered
- **Additional context**

### Your First Code Contribution

Unsure where to begin? Look for issues labeled:
- `good first issue` - Simple issues for beginners
- `help wanted` - Issues that need attention

---

## 💻 Development Process

### 1. Create a Feature Branch

```bash
git checkout -b feature/amazing-feature
# or
git checkout -b bugfix/fix-something
# or
git checkout -b docs/update-readme
```

Branch naming conventions:
- `feature/` - New features
- `bugfix/` - Bug fixes
- `hotfix/` - Urgent fixes
- `docs/` - Documentation updates
- `refactor/` - Code refactoring
- `test/` - Adding tests

### 2. Make Your Changes

- Write clean, readable code
- Follow coding standards (see below)
- Add tests for new features
- Update documentation as needed
- Keep commits atomic and focused

### 3. Test Your Changes

```bash
# Run tests
php artisan test

# Check code style
./vendor/bin/pint

# Run static analysis (if configured)
./vendor/bin/phpstan analyse
```

### 4. Commit Your Changes

```bash
git add .
git commit -m "feat: add amazing feature"
```

### 5. Push to Your Fork

```bash
git push origin feature/amazing-feature
```

### 6. Create Pull Request

Go to the original repository and create a pull request from your fork.

---

## 📝 Coding Standards

### PHP Standards

This project follows **PSR-12** coding standards.

#### Key Points:

- Use 4 spaces for indentation (no tabs)
- Opening braces for classes and methods on new line
- Use type hints where possible
- Add PHPDoc blocks for methods
- Keep lines under 120 characters

#### Example:

```php
<?php

namespace App\Http\Controllers\Api;

use App\Models\Appointment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AppointmentController extends ApiController
{
    /**
     * Display a listing of appointments.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $appointments = Appointment::with(['doctor', 'service'])
            ->paginate(15);

        return $this->successResponse($appointments);
    }
}
```

### Laravel Best Practices

- Use Eloquent ORM instead of raw queries
- Use route model binding
- Use form requests for validation
- Use API resources for transforming data
- Use query scopes for reusable queries
- Follow RESTful conventions

### Database

- Use migrations for schema changes
- Never edit existing migrations that have been committed
- Use seeders for sample data
- Add indexes for foreign keys and frequently queried columns

### Testing

- Write tests for new features
- Maintain test coverage above 80%
- Use feature tests for API endpoints
- Use unit tests for business logic

---

## 💬 Commit Messages

We follow the **Conventional Commits** specification.

### Format:

```
<type>(<scope>): <subject>

<body>

<footer>
```

### Types:

- `feat` - New feature
- `fix` - Bug fix
- `docs` - Documentation changes
- `style` - Code style changes (formatting, etc.)
- `refactor` - Code refactoring
- `test` - Adding or updating tests
- `chore` - Maintenance tasks
- `perf` - Performance improvements

### Examples:

```bash
# Feature
git commit -m "feat(appointments): add appointment cancellation"

# Bug fix
git commit -m "fix(auth): resolve token expiration issue"

# Documentation
git commit -m "docs(readme): update installation instructions"

# Refactoring
git commit -m "refactor(services): simplify service query logic"

# Multiple lines
git commit -m "feat(appointments): add email notifications

- Send confirmation email on booking
- Send reminder 24 hours before appointment
- Add email templates

Closes #123"
```

---

## 🔄 Pull Request Process

### Before Submitting

- [ ] Code follows project style guidelines
- [ ] Self-review of code completed
- [ ] Comments added for complex code
- [ ] Documentation updated
- [ ] Tests added/updated
- [ ] All tests passing
- [ ] No merge conflicts

### PR Title Format

Follow the same format as commit messages:

```
feat(appointments): add appointment cancellation feature
```

### PR Description Template

```markdown
## Description
Brief description of changes

## Type of Change
- [ ] Bug fix
- [ ] New feature
- [ ] Breaking change
- [ ] Documentation update

## Changes Made
- Change 1
- Change 2
- Change 3

## Testing
Describe how you tested your changes

## Screenshots (if applicable)
Add screenshots here

## Checklist
- [ ] Code follows style guidelines
- [ ] Self-review completed
- [ ] Comments added
- [ ] Documentation updated
- [ ] Tests added/updated
- [ ] All tests passing
- [ ] No merge conflicts

## Related Issues
Closes #123
```

### Review Process

1. At least one maintainer must review
2. All comments must be addressed
3. All tests must pass
4. No merge conflicts
5. Approved by maintainer

### After Approval

- Squash commits if needed
- Maintainer will merge the PR
- Delete your feature branch

---

## 🧪 Testing Guidelines

### Writing Tests

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Appointment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AppointmentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_an_appointment()
    {
        $data = [
            'name' => 'John Doe',
            'phone' => '+1234567890',
            'message' => 'Need consultation',
            'preferred_date' => '2025-01-15',
        ];

        $response = $this->postJson('/api/v1/appointments', $data);

        $response->assertStatus(201)
                 ->assertJson([
                     'status' => 'success',
                 ]);

        $this->assertDatabaseHas('appointments', [
            'name' => 'John Doe',
        ]);
    }
}
```

### Running Tests

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=AppointmentTest

# Run with coverage
php artisan test --coverage

# Run in parallel
php artisan test --parallel
```

---

## 📚 Documentation

### Code Documentation

- Add PHPDoc blocks for all classes and methods
- Document complex logic with inline comments
- Keep comments up-to-date with code changes

### API Documentation

- Update API documentation for new endpoints
- Include request/response examples
- Document error responses

---

## 🎯 Code Review Checklist

### For Reviewers

- [ ] Code is clean and readable
- [ ] Follows project conventions
- [ ] No unnecessary complexity
- [ ] Tests are adequate
- [ ] Documentation is updated
- [ ] No security vulnerabilities
- [ ] Performance considerations addressed

### For Contributors

- [ ] PR description is clear
- [ ] Changes are focused and atomic
- [ ] Tests are passing
- [ ] Documentation is updated
- [ ] No debug code left
- [ ] No commented-out code

---

## 🐛 Debugging Tips

### Common Issues

**Database Connection Error:**
```bash
# Check .env configuration
# Ensure MySQL is running
# Verify database exists
```

**Migration Error:**
```bash
# Rollback and re-run
php artisan migrate:rollback
php artisan migrate
```

**Cache Issues:**
```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

---

## 📞 Getting Help

- **Documentation:** Check project documentation first
- **Issues:** Search existing issues
- **Discussions:** Use GitHub Discussions for questions
- **Email:** Contact maintainers for sensitive issues

---

## 🏆 Recognition

Contributors will be recognized in:
- README.md contributors section
- Release notes
- Project website (if applicable)

---

## 📄 License

By contributing, you agree that your contributions will be licensed under the MIT License.

---

Thank you for contributing! 🎉
