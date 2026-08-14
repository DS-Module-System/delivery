# Delivery Module - Quick Start Guide

This guide provides a quick setup for the ERP Delivery Module.

## Prerequisites

- PHP 8.0 or higher
- Symfony 6.0 or higher
- MySQL 8.0 or higher
- Composer

## Quick Installation

### 1. Database Migration

```bash
# Generate migration for Delivery entity
php bin/console make:migration

# Run the migration
php bin/console doctrine:migrations:migrate
```

### 2. Clear Cache

```bash
# Clear application cache
php bin/console cache:clear
```

### 3. Verify Installation

Access the delivery module at: `/deliveries`

## Module Features

### Core Functionality
- **Create Deliveries**: Add new delivery records with date, supplier, and user tracking
- **Edit Deliveries**: Modify existing delivery information
- **List Deliveries**: View all deliveries with search and pagination
- **Delete Deliveries**: Remove delivery records

### Fields Available
- **Delivery Date**: Date and time of delivery
- **Created By**: User who created the delivery record
- **Created At**: Timestamp when the record was created
- **Supplier**: Name of the delivery supplier
- **Final Price**: Final price of the delivery (BGN)

## Basic Usage

### Creating a Delivery
1. Navigate to `/deliveries`
2. Click "New" button
3. Fill in the required fields:
   - Delivery Date
   - Supplier
   - Created By (user selection)
4. Save the delivery

### Searching Deliveries
1. Use the search form on the delivery list page
2. Search by supplier name
3. Results are paginated for better performance

## Integration

### Menu Integration
The delivery module automatically integrates with the main menu system.

### User Permissions
The module includes role-based access control:
- `ROLE_DELIVERY_VIEW`: View deliveries
- `ROLE_DELIVERY_CREATE`: Create new deliveries
- `ROLE_DELIVERY_EDIT`: Edit existing deliveries
- `ROLE_DELIVERY_DELETE`: Delete deliveries

## Troubleshooting

### Common Issues

**Migration Errors**
```bash
# If migration fails, check database connection
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

**Permission Issues**
```bash
# Clear cache and check permissions
php bin/console cache:clear
chmod -R 777 var/cache
```

**Form Validation Errors**
- Ensure all required fields are filled
- Check date format (YYYY-MM-DD HH:MM:SS)
- Verify user exists in the system

## Next Steps

- Review the [Installation Guide](installation-guide.md) for detailed setup
- Configure additional module integrations
- Set up custom delivery workflows
- Implement delivery status tracking

## Support

For additional support:
- Check the main [README.md](README.md)
- Review the [Installation Guide](installation-guide.md)
- Contact support@devscale.bg 