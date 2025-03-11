# Contributing to Customer Merge Module

Thank you for considering contributing to the Customer Merge Module for Perfex CRM! This document outlines the process for contributing to this project.

## Code of Conduct

By participating in this project, you agree to maintain a respectful and inclusive environment for everyone.

## How Can I Contribute?

### Reporting Bugs

- Check if the bug has already been reported in the [Issues](https://github.com/owgit/customer_merge/issues)
- If not, create a new issue with a clear title and description
- Include steps to reproduce the bug
- Add information about your environment (Perfex CRM version, PHP version, etc.)
- If possible, include screenshots or code snippets

### Suggesting Enhancements

- Check if the enhancement has already been suggested in the [Issues](https://github.com/owgit/customer_merge/issues)
- If not, create a new issue with a clear title and description
- Explain why this enhancement would be useful to most users
- Provide examples of how the enhancement would work

### Pull Requests

1. Fork the repository
2. Create a new branch (`git checkout -b feature/amazing-feature`)
3. Make your changes
4. Test your changes thoroughly
5. Commit your changes (`git commit -m 'Add some amazing feature'`)
6. Push to the branch (`git push origin feature/amazing-feature`)
7. Open a Pull Request

## Development Guidelines

### Coding Standards

- Follow the Perfex CRM coding standards
- Use meaningful variable and function names
- Add comments to explain complex logic
- Write unit tests for new features when possible

### Commit Messages

- Use clear and meaningful commit messages
- Reference issue numbers when applicable
- Keep commits focused on a single change

### Pull Request Process

1. Update the README.md with details of changes if needed
2. Update the CHANGELOG.md with details of changes
3. The PR will be merged once it has been reviewed and approved

## Setting Up Development Environment

1. Clone the repository to your local Perfex CRM modules directory
2. Make your changes
3. Test thoroughly before submitting a pull request

## Language Translations

If you're adding a new language:

1. Create a new directory in `modules/customer_merge/language/` with the language name (e.g., `french`)
2. Copy the `customer_merge_lang.php` file from the `english` directory to your new language directory
3. Translate all strings in the file
4. The module will automatically detect and use the new language file

## Questions?

If you have any questions about contributing, please feel free to contact me at [info@uygarduzgun.com](mailto:info@uygarduzgun.com).

Thank you for your contributions! 