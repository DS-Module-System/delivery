# Delivery Module - Installation Guide

This comprehensive guide covers the complete installation and configuration of the ERP Delivery Module.

## Table of Contents

1. [Prerequisites](#prerequisites)
2. [Installation Steps](#installation-steps)
3. [Configuration](#configuration)
4. [Database Setup](#database-setup)
5. [Menu Integration](#menu-integration)
6. [Security Configuration](#security-configuration)
7. [Testing](#testing)
8. [Troubleshooting](#troubleshooting)

## Prerequisites

### System Requirements
- **PHP**: 8.0 or higher
- **Symfony**: 6.0 or higher
- **Database**: MySQL 8.0 or higher
- **Composer**: Latest version
- **Web Server**: Apache/Nginx

### Required Extensions
- PHP PDO extension
- PHP Doctrine extensions
- PHP XML extension
- PHP JSON extension

### Dependencies
- ERP Core Module System
- Symfony Form component
- Doctrine ORM
- Twig templating engine

## Installation Steps

### Step 1: Verify Core System

Ensure the ERP Core Module System is properly installed:

```bash
# Check if core system is working
php bin/console about
```

### Step 2: Database Migration

Generate and run the database migration for the Delivery entity:

```bash
# Generate migration
php bin/console make:migration

# Review the generated migration file
# It should be in migrations/ directory

# Run the migration
php bin/console doctrine:migrations:migrate
```

### Step 3: Clear Cache

Clear the application cache to ensure new routes and configurations are loaded:

```bash
# Clear cache
php bin/console cache:clear

# Clear cache in production (if applicable)
php bin/console cache:clear --env=prod
```

### Step 4: Verify Installation

Test the module installation:

```bash
# Check if routes are registered
php bin/console debug:router | grep delivery

# Check if entity is recognized
php bin/console debug:container | grep Delivery
```

## Configuration

### Entity Configuration

The Delivery entity is configured with the following fields:

- **deliveryDate**: DateTime field for delivery date and time
- **createdBy**: ManyToOne relationship with BaseUser
- **createdAt**: DateTime field for creation timestamp
- **supplier**: String field for supplier name
- **finalPrice**: Decimal field for final price (precision: 10, scale: 2)

### Form Configuration

The module includes two form types:

1. **DeliveryForm**: Main form for creating/editing deliveries
2. **DeliverySearchForm**: Search form for filtering deliveries

### Repository Configuration

The DeliveryRepository extends ServiceEntityRepository and provides:

- Basic CRUD operations
- Pagination support
- Search functionality
- Multi-language support (if configured)

## Database Setup

### Table Structure

The delivery table includes:

```sql
CREATE TABLE delivery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    delivery_date DATETIME NOT NULL,
    created_by_id INT NOT NULL,
    created_at DATETIME NOT NULL,
    supplier VARCHAR(255) NOT NULL,
    final_price DECIMAL(10,2) DEFAULT NULL,
    FOREIGN KEY (created_by_id) REFERENCES base_user(id)
);
```

### Indexes

Recommended indexes for performance:

```sql
CREATE INDEX idx_delivery_date ON delivery(delivery_date);
CREATE INDEX idx_delivery_supplier ON delivery(supplier);
CREATE INDEX idx_delivery_created_at ON delivery(created_at);
```

## Menu Integration

### Automatic Integration

The delivery module automatically integrates with the menu system through:

- Route configuration in DeliveryController
- Translation keys for menu items
- Role-based access control

### Manual Menu Configuration

If manual configuration is needed, add to your menu configuration:

```yaml
# config/packages/menu.yaml
delivery_menu:
    label: 'delivery.leftMenu.deliveries'
    route: 'delivery_list'
    icon: 'fas fa-truck'
    roles: ['ROLE_DELIVERY_VIEW']
```

## Security Configuration

### Role Configuration

The module includes predefined roles in `config/roles/delivery.yaml`:

```yaml
parameters:
    delivery_roles:
        "ROLE_DELIVERY_VIEW": "Can view delivery information"
        "ROLE_DELIVERY_CREATE": "Can create new deliveries"
        "ROLE_DELIVERY_EDIT": "Can edit delivery information"
        "ROLE_DELIVERY_DELETE": "Can delete deliveries"
        "ROLE_DELIVERY_APPROVE": "Can approve delivery changes"
```

### Access Control

Configure access control in your security configuration:

```yaml
# config/packages/security.yaml
security:
    access_control:
        - { path: ^/deliveries, roles: ROLE_DELIVERY_VIEW }
```

## Testing

### Functional Testing

Test the module functionality:

1. **Access Control**: Verify users can access based on roles
2. **CRUD Operations**: Test create, read, update, delete operations
3. **Search Functionality**: Test search by supplier
4. **Form Validation**: Test form validation and error handling
5. **Pagination**: Test pagination on large datasets

### Unit Testing

Create unit tests for the module:

```bash
# Generate test skeleton
php bin/console make:test DeliveryControllerTest

# Run tests
php bin/phpunit tests/Controller/Delivery/DeliveryControllerTest.php
```

## Troubleshooting

### Common Issues

#### Migration Errors

**Problem**: Migration fails with foreign key errors
```bash
# Solution: Check if BaseUser table exists
php bin/console doctrine:schema:validate

# If needed, create missing tables
php bin/console doctrine:schema:update --force
```

#### Route Not Found

**Problem**: `/deliveries` route returns 404
```bash
# Solution: Clear cache and check routes
php bin/console cache:clear
php bin/console debug:router | grep delivery
```

#### Form Validation Errors

**Problem**: Form submission fails with validation errors
```bash
# Solution: Check form configuration
php bin/console debug:container | grep DeliveryForm
```

#### Permission Denied

**Problem**: Users cannot access delivery module
```bash
# Solution: Check user roles and security configuration
php bin/console debug:container | grep security
```

### Performance Issues

#### Slow Queries

**Problem**: Delivery list loads slowly
```bash
# Solution: Add database indexes
php bin/console doctrine:query:sql "CREATE INDEX idx_delivery_date ON delivery(delivery_date)"
```

#### Memory Issues

**Problem**: High memory usage with large datasets
```bash
# Solution: Implement pagination and optimize queries
# Check repository getPaginatedQuery method
```

### Debug Commands

Useful debug commands for troubleshooting:

```bash
# Debug routes
php bin/console debug:router

# Debug services
php bin/console debug:container | grep delivery

# Debug database schema
php bin/console doctrine:schema:validate

# Debug cache
php bin/console cache:clear
```

## Support

For additional support:

- **Documentation**: Check the [README.md](README.md) and [Quick Start Guide](quick-start.md)
- **Issues**: Report issues through the project issue tracker
- **Contact**: support@devscale.bg

## Version History

- **v1.0.0**: Initial release with basic CRUD functionality
- **Future**: Planned features include delivery status tracking and integration with other modules 