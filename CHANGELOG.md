# Changelog

All notable changes to the Customer Merge module will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.2] - 2025-03-11

### Added
- Comprehensive rollback functionality for all customer data types
- Support for rolling back Profile, Contacts, Notes, Projects, Estimates, Invoices, Expenses, Tasks, Files, Payments, Proposals, Credit Notes, Subscriptions, and Contracts
- Improved primary contact handling during rollback

### Changed
- Enhanced database column detection for better compatibility with different table structures
- Improved error handling in rollback process
- Better handling of payment records during rollback

### Fixed
- Fixed "Unknown column 'clientid' in 'where clause'" error in payment rollback
- Fixed "Unknown column 'datecreated' in 'where clause'" error in various tables
- Fixed issue with contacts not being properly rolled back

### Known Issues
- When rolling back, the primary contact may not be set to active status automatically
- Some custom fields may not be properly transferred during rollback if they have special handling requirements

## [1.0.1] - 2025-03-11

### Added
- Rollback functionality to undo merge operations
- Status indicators in merge history
- Swedish translations for rollback functionality

### Changed
- Updated database schema to track rollback status
- Improved merge history display with status and options columns

### Fixed
- Minor UI improvements in the merge history view

## [1.0.0] - 2025-03-11

### Added
- Initial release
- Customer merging functionality
- Comprehensive data migration
- Selective merging options
- Smart custom fields handling
- Primary contact management
- Merge history tracking
- Permission-based access control
- English and Swedish language support

### Fixed
- SQL syntax errors in the merge_related_records function
- Proper handling of additional WHERE clauses in SQL queries

## [Unreleased]

### Added
- Enhanced custom fields merging with intelligent type-specific handling
- Special handling for select/multiselect fields like "customers_kundtyp"
- Improved logging of merged custom fields
- Better documentation in README.md 