# Changelog

All notable changes to the Customer Merge Module will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2025-03-11

### Added
- Initial release of the Customer Merge Module
- Comprehensive data migration for all customer-related records
- Intuitive user interface for merging customers
- Selective merging options for different data types
- Primary contact handling with smart management
- Merge history tracking for audit purposes
- Permission-based access control
- English language support
- Swedish language support
- Enhanced custom fields merging with special handling for "customers_kundtyp"

### Fixed
- SQL syntax errors in the merge_related_records function
- Proper handling of additional WHERE clauses in SQL queries

## [Unreleased]

### Added
- Enhanced custom fields merging with intelligent type-specific handling
- Special handling for select/multiselect fields like "customers_kundtyp"
- Improved logging of merged custom fields
- Better documentation in README.md 
