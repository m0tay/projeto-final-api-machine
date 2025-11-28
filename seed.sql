INSERT INTO beverages (id, name, type, preparation, brew_time_seconds, description, is_available) VALUES
    ('b02893ff-c7c4-11f0-bff7-001dd8b7204b', 'Espresso', 'coffee', 'hot,warm', 30, 'Single shot of rich espresso', 1),
    ('b0289798-c7c4-11f0-bff7-001dd8b7204b', 'Americano', 'coffee', 'hot,warm,iced', 35, 'Espresso with hot water', 1),
    ('b02897c9-c7c4-11f0-bff7-001dd8b7204b', 'Cappuccino', 'coffee', 'hot,warm', 45, 'Espresso with steamed milk and foam', 1),
    ('b02897ef-c7c4-11f0-bff7-001dd8b7204b', 'Latte', 'coffee', 'hot,warm,iced', 40, 'Smooth espresso with steamed milk', 1),
    ('b0289853-c7c4-11f0-bff7-001dd8b7204b', 'Hot Chocolate', 'chocolate', 'hot,warm', 50, 'Rich chocolate drink with steamed milk', 1),
    ('b0289883-c7c4-11f0-bff7-001dd8b7204b', 'Green Tea', 'tea', 'hot,warm,iced', 180, 'Green tea', 1);

INSERT INTO beverage_ingredients (beverage_id, ingredient_id, quantity_needed) VALUES
    ('b02893ff-c7c4-11f0-bff7-001dd8b7204b', 1, 30),
    ('b02893ff-c7c4-11f0-bff7-001dd8b7204b', 2, 7);

INSERT INTO beverage_ingredients (beverage_id, ingredient_id, quantity_needed) VALUES
    ('b0289798-c7c4-11f0-bff7-001dd8b7204b', 1, 150),
    ('b0289798-c7c4-11f0-bff7-001dd8b7204b', 2, 7);

INSERT INTO beverage_ingredients (beverage_id, ingredient_id, quantity_needed) VALUES
    ('b02897c9-c7c4-11f0-bff7-001dd8b7204b', 1, 30),
    ('b02897c9-c7c4-11f0-bff7-001dd8b7204b', 2, 7),
    ('b02897c9-c7c4-11f0-bff7-001dd8b7204b', 3, 120);

INSERT INTO beverage_ingredients (beverage_id, ingredient_id, quantity_needed) VALUES
    ('b02897ef-c7c4-11f0-bff7-001dd8b7204b', 1, 30),
    ('b02897ef-c7c4-11f0-bff7-001dd8b7204b', 2, 7),
    ('b02897ef-c7c4-11f0-bff7-001dd8b7204b', 3, 200);

INSERT INTO beverage_ingredients (beverage_id, ingredient_id, quantity_needed) VALUES
    ('b0289853-c7c4-11f0-bff7-001dd8b7204b', 3, 200),
    ('b0289853-c7c4-11f0-bff7-001dd8b7204b', 6, 25),
    ('b0289853-c7c4-11f0-bff7-001dd8b7204b', 7, 5);

INSERT INTO beverage_ingredients (beverage_id, ingredient_id, quantity_needed) VALUES
    ('b0289883-c7c4-11f0-bff7-001dd8b7204b', 1, 250),
    ('b0289883-c7c4-11f0-bff7-001dd8b7204b', 4, 3);
