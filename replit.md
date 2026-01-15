# ERP Mini (Laravel) + Marketplace API Simulation

## Overview
A lightweight Laravel-based Mini ERP application that demonstrates core ERP workflows - product management, inventory movements, order processing, and simulated marketplace integration.

## Tech Stack
- **Backend**: Laravel 11 (PHP 8.2)
- **Database**: SQLite
- **Frontend**: Blade templates with Tailwind CSS and Alpine.js
- **Server**: PHP built-in server on port 5000

## Features
1. **Products** - CRUD operations with SKU-based identification
2. **Inventory Management** - Stock In/Out transactions with automatic stock calculation
3. **Orders** - Order creation with product snapshot and status workflow (new → packed → shipped → done)
4. **Marketplace Sync (Mock)** - Import orders from local JSON file, simulated status push logs

## Project Structure
```
/app
  /Http
    /Controllers - DashboardController, ProductController, InventoryController, OrderController, MarketplaceController
    /Requests - ProductRequest, InventoryMovementRequest, OrderRequest
  /Models - Product, InventoryMovement, Order, OrderItem, MarketplacePushLog
/database
  /migrations - Database schema
  /seeders - Initial data (8 products with stock)
/resources/views
  /layouts - Main app layout
  /products, /inventory, /orders, /marketplace - Feature views
/routes/web.php - All routes
/storage/app/mock/marketplace_orders.json - Mock marketplace data
```

## Database Tables
- products - Product master data
- inventory_movements - Stock in/out history
- orders - Order headers and status
- order_items - Product details per order
- marketplace_push_logs - Simulated API status updates

## Running the Application
The application runs on port 5000 using Laravel's built-in server.

## Recent Changes
- January 15, 2026: Initial project setup with all features implemented
