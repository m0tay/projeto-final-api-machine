CREATE TABLE IF NOT EXISTS beverages (
    id TEXT PRIMARY KEY,
    name TEXT NOT NULL,
    type TEXT NOT NULL, 
    preparation TEXT, 
    brew_time_seconds INTEGER NOT NULL,
    description TEXT,
    is_available INTEGER DEFAULT 1
);


CREATE TABLE IF NOT EXISTS ingredients (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL UNIQUE,
    current_stock REAL NOT NULL DEFAULT 0,
    unit TEXT NOT NULL, 
    min_stock REAL NOT NULL DEFAULT 0,
    max_stock REAL NOT NULL DEFAULT 1000
);


CREATE TABLE IF NOT EXISTS beverage_ingredients (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    beverage_id TEXT NOT NULL,
    ingredient_id INTEGER NOT NULL,
    quantity_needed REAL NOT NULL,
    FOREIGN KEY (beverage_id) REFERENCES beverages(id),
    FOREIGN KEY (ingredient_id) REFERENCES ingredients(id)
);


INSERT INTO ingredients (name, current_stock, unit, min_stock, max_stock) VALUES
    ('Water', 5000, 'ml', 500, 10000),
    ('Coffee Beans', 1000, 'g', 100, 2000),
    ('Milk', 3000, 'ml', 300, 5000),
    ('Green Tea Leaves', 200, 'g', 20, 500),
    ('Hibiscus Tea Leaves', 200, 'g', 20, 500),
    ('Chocolate Powder', 500, 'g', 50, 1000),
    ('Sugar', 1000, 'g', 100, 2000);
