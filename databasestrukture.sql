-- Users table
CREATE TABLE users (
    user_id SERIAL PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    phone VARCHAR(20),
    is_admin BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sotuvchilar (Vendors) jadvali
CREATE TABLE vendors (
    vendor_id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES users(user_id),
    company_name VARCHAR(100) NOT NULL,
    description TEXT,
    logo_url VARCHAR(255),
    website VARCHAR(255),
    contact_email VARCHAR(100) NOT NULL,
    contact_phone VARCHAR(20),
    address TEXT,
    city VARCHAR(100),
    postal_code VARCHAR(20),
    country VARCHAR(100),
    status VARCHAR(20) DEFAULT 'active', -- active, pending, suspended
    commission_rate DECIMAL(5, 2) DEFAULT 10.00, -- platformaning foiz stavkasi
    bank_details TEXT,
    tax_id VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Categories table
CREATE TABLE categories (
    category_id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    parent_id INTEGER REFERENCES categories(category_id),
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Products table
CREATE TABLE products (
    product_id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    discount_price DECIMAL(10, 2),
    category_id INTEGER REFERENCES categories(category_id),
    vendor_id INTEGER REFERENCES vendors(vendor_id),
    stock_quantity INTEGER NOT NULL DEFAULT 0,
    image_url VARCHAR(255),
    is_featured BOOLEAN DEFAULT FALSE,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Product images (multiple images per product)
CREATE TABLE product_images (
    image_id SERIAL PRIMARY KEY,
    product_id INTEGER REFERENCES products(product_id) ON DELETE CASCADE,
    image_url VARCHAR(255) NOT NULL,
    is_primary BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Product attributes (attribute types)
CREATE TABLE attribute_types (
    attribute_type_id SERIAL PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE, -- "Size", "Color", "Memory", "Weight" etc.
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Attribute values
CREATE TABLE attribute_values (
    attribute_value_id SERIAL PRIMARY KEY,
    attribute_type_id INTEGER REFERENCES attribute_types(attribute_type_id) ON DELETE CASCADE,
    value VARCHAR(100) NOT NULL, -- "S", "M", "L", "Red", "Blue", "16GB", "32GB" etc.
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(attribute_type_id, value)
);

-- Product variants
CREATE TABLE product_variants (
    variant_id SERIAL PRIMARY KEY,
    product_id INTEGER REFERENCES products(product_id) ON DELETE CASCADE,
    sku VARCHAR(100) UNIQUE,
    price DECIMAL(10, 2),
    discount_price DECIMAL(10, 2),
    stock_quantity INTEGER NOT NULL DEFAULT 0,
    image_url VARCHAR(255),
    is_default BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Product variant attributes (connects variants with attribute values)
CREATE TABLE variant_attributes (
    variant_attribute_id SERIAL PRIMARY KEY,
    variant_id INTEGER REFERENCES product_variants(variant_id) ON DELETE CASCADE,
    attribute_value_id INTEGER REFERENCES attribute_values(attribute_value_id) ON DELETE CASCADE,
    UNIQUE(variant_id, attribute_value_id)
);

-- Product variant images (har bir variant uchun alohida rasmlar)
CREATE TABLE variant_images (
    image_id SERIAL PRIMARY KEY,
    variant_id INTEGER REFERENCES product_variants(variant_id) ON DELETE CASCADE,
    image_url VARCHAR(255) NOT NULL,
    is_primary BOOLEAN DEFAULT FALSE,
    display_order INTEGER DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Product variant inventory (har bir variantning ombordagi soni)
CREATE TABLE variant_inventory (
    inventory_id SERIAL PRIMARY KEY,
    variant_id INTEGER REFERENCES product_variants(variant_id) ON DELETE CASCADE,
    quantity INTEGER NOT NULL DEFAULT 0,
    reserved_quantity INTEGER NOT NULL DEFAULT 0, -- buyurtma qilingan lekin yetkazib berilmagan
    last_checked TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Product variant location (agar bir necha omborlardan boshqarilsa)
CREATE TABLE inventory_locations (
    location_id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    address TEXT,
    city VARCHAR(100),
    postal_code VARCHAR(20),
    country VARCHAR(100),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Product variant inventory by location (har bir variant qaysi omborda qancha bor)
CREATE TABLE variant_inventory_location (
    id SERIAL PRIMARY KEY,
    variant_id INTEGER REFERENCES product_variants(variant_id) ON DELETE CASCADE,
    location_id INTEGER REFERENCES inventory_locations(location_id) ON DELETE CASCADE,
    quantity INTEGER NOT NULL DEFAULT 0,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(variant_id, location_id)
);

-- Orders table
CREATE TABLE orders (
    order_id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES users(user_id),
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(20) NOT NULL DEFAULT 'pending', -- pending, processing, shipped, delivered, cancelled
    shipping_address TEXT NOT NULL,
    shipping_city VARCHAR(100) NOT NULL,
    shipping_postal_code VARCHAR(20),
    payment_method VARCHAR(50) NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    tracking_number VARCHAR(100),
    notes TEXT
);

-- Order items (connection between orders and products)
CREATE TABLE order_items (
    item_id SERIAL PRIMARY KEY,
    order_id INTEGER REFERENCES orders(order_id) ON DELETE CASCADE,
    product_id INTEGER REFERENCES products(product_id),
    variant_id INTEGER REFERENCES product_variants(variant_id),
    quantity INTEGER NOT NULL,
    price_per_unit DECIMAL(10, 2) NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL
);

-- Cart table
CREATE TABLE carts (
    cart_id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES users(user_id),
    session_id VARCHAR(100), -- For anonymous users
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Cart items
CREATE TABLE cart_items (
    item_id SERIAL PRIMARY KEY,
    cart_id INTEGER REFERENCES carts(cart_id) ON DELETE CASCADE,
    product_id INTEGER REFERENCES products(product_id),
    variant_id INTEGER REFERENCES product_variants(variant_id),
    quantity INTEGER NOT NULL DEFAULT 1,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Reviews table
CREATE TABLE reviews (
    review_id SERIAL PRIMARY KEY,
    product_id INTEGER REFERENCES products(product_id) ON DELETE CASCADE,
    user_id INTEGER REFERENCES users(user_id),
    rating INTEGER NOT NULL CHECK (rating BETWEEN 1 AND 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sotuvchi tomonidan toʻlovlar jadvali
CREATE TABLE vendor_payments (
    payment_id SERIAL PRIMARY KEY,
    vendor_id INTEGER REFERENCES vendors(vendor_id),
    order_item_id INTEGER REFERENCES order_items(item_id),
    amount DECIMAL(10, 2) NOT NULL,
    commission_amount DECIMAL(10, 2) NOT NULL,
    status VARCHAR(20) DEFAULT 'pending', -- pending, paid, failed
    payment_date TIMESTAMP,
    transaction_id VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sotuvchi reytinglari
CREATE TABLE vendor_reviews (
    review_id SERIAL PRIMARY KEY,
    vendor_id INTEGER REFERENCES vendors(vendor_id),
    user_id INTEGER REFERENCES users(user_id),
    rating INTEGER NOT NULL CHECK (rating BETWEEN 1 AND 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tillar jadvali
CREATE TABLE languages (
    language_id SERIAL PRIMARY KEY,
    code VARCHAR(10) NOT NULL UNIQUE, -- uz, ru, en kabi
    name VARCHAR(50) NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    is_default BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Kategoriyalar tarjimalari
CREATE TABLE category_translations (
    translation_id SERIAL PRIMARY KEY,
    category_id INTEGER REFERENCES categories(category_id) ON DELETE CASCADE,
    language_id INTEGER REFERENCES languages(language_id) ON DELETE CASCADE,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(category_id, language_id)
);

-- Mahsulotlar tarjimalari
CREATE TABLE product_translations (
    translation_id SERIAL PRIMARY KEY,
    product_id INTEGER REFERENCES products(product_id) ON DELETE CASCADE,
    language_id INTEGER REFERENCES languages(language_id) ON DELETE CASCADE,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(product_id, language_id)
);

-- Atribut turlari tarjimalari
CREATE TABLE attribute_type_translations (
    translation_id SERIAL PRIMARY KEY,
    attribute_type_id INTEGER REFERENCES attribute_types(attribute_type_id) ON DELETE CASCADE,
    language_id INTEGER REFERENCES languages(language_id) ON DELETE CASCADE,
    name VARCHAR(50) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(attribute_type_id, language_id)
);

-- Atribut qiymatlari tarjimalari
CREATE TABLE attribute_value_translations (
    translation_id SERIAL PRIMARY KEY,
    attribute_value_id INTEGER REFERENCES attribute_values(attribute_value_id) ON DELETE CASCADE,
    language_id INTEGER REFERENCES languages(language_id) ON DELETE CASCADE,
    value VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(attribute_value_id, language_id)
);

-- Statik tarjima kontentlari uchun
CREATE TABLE content_translations (
    translation_id SERIAL PRIMARY KEY,
    content_key VARCHAR(100) NOT NULL,
    language_id INTEGER REFERENCES languages(language_id) ON DELETE CASCADE,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(content_key, language_id)
);

-- Create indexes for frequently queried columns
CREATE INDEX idx_products_category ON products(category_id);
CREATE INDEX idx_products_vendor ON products(vendor_id);
CREATE INDEX idx_orders_user ON orders(user_id);
CREATE INDEX idx_cart_user ON carts(user_id);
CREATE INDEX idx_products_featured ON products(is_featured);
CREATE INDEX idx_vendor_payments_vendor ON vendor_payments(vendor_id);
CREATE INDEX idx_product_variants_product ON product_variants(product_id);
CREATE INDEX idx_variant_attributes_variant ON variant_attributes(variant_id);
CREATE INDEX idx_variant_images_variant ON variant_images(variant_id);
CREATE INDEX idx_variant_inventory_variant ON variant_inventory(variant_id);
CREATE INDEX idx_variant_inventory_location ON variant_inventory_location(variant_id, location_id);
CREATE INDEX idx_order_items_variant ON order_items(variant_id);
CREATE INDEX idx_cart_items_variant ON cart_items(variant_id);
CREATE INDEX idx_category_translations_category ON category_translations(category_id);
CREATE INDEX idx_category_translations_language ON category_translations(language_id);
CREATE INDEX idx_product_translations_product ON product_translations(product_id);
CREATE INDEX idx_product_translations_language ON product_translations(language_id);
CREATE INDEX idx_attribute_type_translations_language ON attribute_type_translations(language_id);
CREATE INDEX idx_attribute_value_translations_language ON attribute_value_translations(language_id);
CREATE INDEX idx_content_translations_key ON content_translations(content_key);