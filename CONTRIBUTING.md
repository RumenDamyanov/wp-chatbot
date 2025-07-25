# Contributing to WP Chatbot

We welcome contributions to the WP Chatbot plugin! This document provides guidelines for contributing to the project.

## Table of Contents

- [Code of Conduct](#code-of-conduct)
- [Getting Started](#getting-started)
- [Development Setup](#development-setup)
- [Making Changes](#making-changes)
- [Testing](#testing)
- [Submitting Changes](#submitting-changes)
- [Coding Standards](#coding-standards)
- [Security](#security)

## Code of Conduct

This project follows the [WordPress Community Code of Conduct](https://make.wordpress.org/handbook/community-code-of-conduct/). Please read and follow these guidelines in all your interactions with the project.

## Getting Started

1. Fork the repository on GitHub
2. Clone your fork locally:
   ```bash
   git clone https://github.com/YOUR-USERNAME/wp-chatbot.git
   cd wp-chatbot
   ```
3. Add the upstream repository:
   ```bash
   git remote add upstream https://github.com/RumenDamyanov/wp-chatbot.git
   ```

## Development Setup

### Prerequisites

- PHP 7.4 or higher
- Composer
- Node.js and npm
- WordPress development environment

### Installation

1. Install PHP dependencies:
   ```bash
   composer install
   ```

2. Install JavaScript dependencies:
   ```bash
   npm install
   ```

3. Set up the development environment:
   ```bash
   npm run dev
   ```

## Making Changes

### Branching

- Create a new branch for each feature or bug fix
- Use descriptive branch names:
  ```bash
  git checkout -b feature/new-chatbot-feature
  git checkout -b fix/bug-description
  ```

### Commit Messages

Follow the conventional commit format:

- `feat: add new feature`
- `fix: resolve bug issue`
- `docs: update documentation`
- `style: code formatting changes`
- `refactor: code restructuring`
- `test: add or update tests`
- `chore: maintenance tasks`

Example:
```
feat: add dark theme support for chatbot

- Implement dark theme CSS variables
- Add theme switching functionality
- Update admin interface with theme options
```

### Code Organization

- **Main plugin file**: `wp-chatbot.php`
- **Core classes**: `includes/` directory
- **Admin functionality**: `admin/` directory
- **Public functionality**: `public/` directory
- **Tests**: `tests/` directory
- **Assets**: `admin/css/`, `admin/js/`, `public/css/`, `public/js/`

## Testing

### Running Tests

1. Run PHP tests:
   ```bash
   composer test
   ```

2. Run tests with coverage:
   ```bash
   composer test:coverage
   ```

3. Run JavaScript tests:
   ```bash
   npm test
   ```

### Writing Tests

- Write unit tests for all new functionality
- Include both positive and negative test cases
- Mock WordPress functions using Brain/Monkey
- Aim for high test coverage (>80%)

Example test:
```php
public function test_chatbot_shortcode_output()
{
    $public = new WpChatbotPublic('wp-chatbot', '1.0.0');
    $output = $public->chatbot_shortcode(['theme' => 'dark']);

    $this->assertStringContainsString('wp-chatbot-dark', $output);
}
```

## Submitting Changes

1. Ensure all tests pass:
   ```bash
   composer test
   npm test
   ```

2. Check coding standards:
   ```bash
   composer cs
   ```

3. Fix any coding standard issues:
   ```bash
   composer cbf
   ```

4. Commit your changes:
   ```bash
   git add .
   git commit -m "feat: your descriptive commit message"
   ```

5. Push to your fork:
   ```bash
   git push origin your-branch-name
   ```

6. Create a Pull Request on GitHub

### Pull Request Guidelines

- Provide a clear description of the changes
- Reference any related issues
- Include screenshots for UI changes
- Ensure all CI checks pass
- Request review from maintainers

## Coding Standards

### PHP

- Follow WordPress Coding Standards
- Use PSR-4 autoloading
- Document all classes and methods with DocBlocks
- Sanitize all input data
- Escape all output data
- Use WordPress hooks and filters appropriately

### JavaScript

- Follow WordPress JavaScript Coding Standards
- Use modern ES6+ syntax
- Document functions with JSDoc
- Ensure browser compatibility
- Use WordPress's included jQuery

### CSS

- Follow WordPress CSS Coding Standards
- Use CSS custom properties for theming
- Ensure responsive design
- Optimize for performance
- Use meaningful class names

### HTML

- Use semantic HTML elements
- Include proper ARIA attributes
- Ensure accessibility compliance
- Validate markup

## Security

### Security Guidelines

- Sanitize all user input
- Escape all output
- Use WordPress nonces for form submissions
- Validate and verify all AJAX requests
- Follow WordPress security best practices

### Reporting Security Issues

If you discover a security vulnerability, please send an email to [hey@rumenx.com](mailto:hey@rumenx.com) instead of creating a public issue. Security issues will be addressed promptly.

## Documentation

- Update documentation for any new features
- Include code examples in docstrings
- Update README.md if necessary
- Add entries to CHANGELOG.md

## Questions and Support

- Check existing issues before creating new ones
- Use GitHub Discussions for questions
- Join our community discussions
- Contact maintainers at [hey@rumenx.com](mailto:hey@rumenx.com)

## Recognition

Contributors will be recognized in:
- README.md contributors section
- Plugin credits
- Release notes

Thank you for contributing to WP Chatbot!
