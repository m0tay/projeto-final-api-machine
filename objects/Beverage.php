<?php
include_once 'Ingredient.php';

class Beverage implements BREAD
{

  private $conn;
  private $table_name = 'beverages';
  public $id;
  public $name;
  public $type;
  public $size;
  public $preparation;
  public $description;
  public $image;
  public $price;
  public $is_active;
  public $ingredients;

  /**
   * @param mixed $db
   */
  public function __construct($db)
  {
    $this->conn = $db;
  }

  public function browse()
  {
    $query = "SELECT * FROM " . $this->table_name  . " ORDER BY name ASC";

    $stmt = $this->conn->prepare($query);

    $stmt->execute();

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $beverages = array();

    foreach ($rows as $row) {
      $beverage = new Beverage($this->conn);
      $beverage->id = $row['id'];
      $beverage->name = $row['name'];
      $beverage->type = $row['type'];
      $beverage->size = $row['size'];
      $beverage->preparation = $row['preparation'];
      $beverage->description = $row['description'];
      $beverage->image = $row['image'];
      $beverage->price = $row['price'];
      $beverage->is_active = $row['is_active'];

      $beverage->get_ingredients();

      array_push($beverages, $beverage);
    }

    return $beverages;
  }
  public function read()
  {
    $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";

    $stmt = $this->conn->prepare($query);

    $stmt->bindValue(':id', filter_var($this->id, FILTER_UNSAFE_RAW));

    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $this->name = $row['name'];
    $this->type = $row['type'];
    $this->size = $row['size'];
    $this->preparation = $row['preparation'];
    $this->description = $row['description'];
    $this->image = $row['image'];
    $this->price = $row['price'];
    $this->is_active = $row['is_active'];
    $this->get_ingredients();
  }
  public function add()
  {
    $query = 'INSERT INTO ' . $this->table_name . '
      (name, type, size, preparation, price, description, image, is_active)
      VALUES
      (:name, :type, :size, :preparation, :price, :description, :image, 1)';

    $stmt = $this->conn->prepare($query);

    $stmt->bindValue(':name', filter_var($this->name, FILTER_UNSAFE_RAW));
    $stmt->bindValue(':type', filter_var($this->type, FILTER_UNSAFE_RAW));
    $stmt->bindValue(':size', filter_var($this->size, FILTER_UNSAFE_RAW));
    $stmt->bindValue(':preparation', filter_var($this->preparation, FILTER_UNSAFE_RAW));
    $stmt->bindValue(':price', filter_var($this->price, FILTER_VALIDATE_FLOAT));
    $stmt->bindValue(':description', filter_var($this->description, FILTER_UNSAFE_RAW));
    $stmt->bindValue(':image', filter_var($this->image, FILTER_UNSAFE_RAW));

    if ($stmt->execute()) {

      $this->id = $this->conn->lastInsertId();
      return true;
    }

    return false;
  }
  public function edit()
  {
    $query = 'UPDATE ' . $this->table_name . ' SET
      name = :name,
      type = :type,
      size = :size,
      preparation = :preparation,
      price = :price,
      description = :description,
      image = :image,
      is_active = 1
      WHERE id = :id';

    $stmt = $this->conn->prepare($query);

    $stmt->bindValue(':name', filter_var($this->name, FILTER_UNSAFE_RAW));
    $stmt->bindValue(':type', filter_var($this->type, FILTER_UNSAFE_RAW));
    $stmt->bindValue(':size', filter_var($this->size, FILTER_UNSAFE_RAW));
    $stmt->bindValue(':preparation', filter_var($this->preparation, FILTER_UNSAFE_RAW));
    $stmt->bindValue(':price', filter_var($this->price, FILTER_VALIDATE_FLOAT));
    $stmt->bindValue(':description', filter_var($this->description, FILTER_UNSAFE_RAW));
    $stmt->bindValue(':image', filter_var($this->image, FILTER_UNSAFE_RAW));
    $stmt->bindValue(':id', filter_var($this->id, FILTER_UNSAFE_RAW));

    if ($stmt->execute()) {

      $this->id = $this->conn->lastInsertId();
      return true;
    }

    return false;
  }
  public function delete()
  {
    $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

    $stmt = $this->conn->prepare($query);

    $stmt->bindValue(':id', filter_var($this->id, FILTER_UNSAFE_RAW));

    if ($stmt->execute()) {
      return true;
    }

    return false;
  }
  public function search()
  {
    throw new \Exception('Not implemented');
  }
  public function add_ingredient(Ingredient $ingredient)
  {
    $query = 'INSERT INTO ingredients
      (name,current_stock,unit,min_stock,max_stock)
      VALUES
      (:name,:current_stock,:unit,:min_stock,:max_stock)';

    $stmt = $this->conn->prepare($query);

    $stmt->bindValue(':name', filter_var($ingredient->name, FILTER_UNSAFE_RAW));
    $stmt->bindValue(':current_stock', filter_var($ingredient->current_stock, FILTER_VALIDATE_FLOAT));
    $stmt->bindValue(':unit', filter_var($ingredient->unit, FILTER_UNSAFE_RAW));
    $stmt->bindValue(':min_stock', (filter_var($ingredient->min_stock, FILTER_VALIDATE_FLOAT) ?: 0));
    $stmt->bindValue(':max_stock', (filter_var($ingredient->max_stock, FILTER_VALIDATE_FLOAT)) ?: 1000);

    if ($stmt->execute()) {
      $this->id = $this->conn->lastInsertId();
      return true;
    }

    return false;
  }
  public function delete_ingredient(Ingredient $ingredient)
  {
    $query = 'DELETE FROM ingredients WHERE id = :id';

    $stmt = $this->conn->prepare($query);

    $stmt->bindValue(':id', filter_var($ingredient->id, FILTER_VALIDATE_INT));

    if ($stmt->execute()) {
      return true;
    }

    return false;
  }
  public function get_ingredients()
  {
    $query = 'SELECT * FROM beverage_ingredients
      WHERE beverage_id = :beverage_id';

    $stmt = $this->conn->prepare($query);

    $stmt->bindValue(':beverage_id', filter_var($this->id, FILTER_UNSAFE_RAW));

    $stmt->execute();

    $ingredients = array();

    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $i) {
      array_push($ingredients, $i);
    }

    $this->ingredients = $ingredients;
  }
  public function associate_ingredient(Ingredient $ingredient, $quantity_needed)
  {
    $query = 'INSERT INTO beverage_ingredients
      (beverage_id, ingredient_id, quantity_needed)
      VALUES
      (:beverage_id, :ingredient_id, :quantity_needed)';

    $stmt = $this->conn->prepare($query);

    $stmt->bindValue(':beverage_id', filter_var($this->id, FILTER_UNSAFE_RAW));
    $stmt->bindValue(':ingredient_id', filter_var($ingredient->id, FILTER_VALIDATE_INT));
    $stmt->bindValue(':quantity_needed', filter_var($quantity_needed, FILTER_VALIDATE_FLOAT));

    if ($stmt->execute()) {
      return true;
    }

    return false;
  }
  public function dissociate_ingredient(Ingredient $ingredient)
  {
    $query = 'DELETE FROM beverage_ingredients
      WHERE beverage_id = :beverage_id AND ingredient_id = :ingredient_id';

    $stmt = $this->conn->prepare($query);

    $stmt->bindValue(':beverage_id', filter_var($this->id, FILTER_UNSAFE_RAW));
    $stmt->bindValue(':ingredient_id', filter_var($ingredient->id, FILTER_VALIDATE_INT));

    if ($stmt->execute()) {
      return true;
    }

    return false;
  }

  public function consume_ingredient(Ingredient $ingredient, $quantity)
  {
    $check_query = 'SELECT current_stock FROM ingredients WHERE id = :id';
    $check_stmt = $this->conn->prepare($check_query);
    $check_stmt->bindValue(':id', filter_var($ingredient->id, FILTER_VALIDATE_INT));
    $check_stmt->execute();
    $result = $check_stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result || $result['current_stock'] < $quantity) {
      return false;
    }

    $query = 'UPDATE ingredients
      SET current_stock = current_stock - :quantity
      WHERE id = :id';

    $stmt = $this->conn->prepare($query);

    $stmt->bindValue(':quantity', filter_var($quantity, FILTER_VALIDATE_FLOAT));
    $stmt->bindValue(':id', filter_var($ingredient->id, FILTER_VALIDATE_INT));

    if ($stmt->execute()) {
      return true;
    }

    return false;
  }

  public function make()
  {
    $this->conn->beginTransaction();

    try {
      $this->get_ingredients();

      if (empty($this->ingredients)) {
        throw new \Exception('Bebida não possui ingredientes configurados');
      }

      $failures = array();

      // Validate all ingredients for sufficient stock
      foreach ($this->ingredients as $ingredient_data) {
        $check_query = 'SELECT name, current_stock, unit FROM ingredients WHERE id = :id';
        $stmt = $this->conn->prepare($check_query);
        $stmt->bindValue(':id', filter_var($ingredient_data['ingredient_id'], FILTER_VALIDATE_INT));
        $stmt->execute();
        $ingredient_info = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$ingredient_info) {
          $failures[] = 'Ingrediente ID ' . $ingredient_data['ingredient_id'] . ' não encontrado';
        } else if ($ingredient_info['current_stock'] < $ingredient_data['quantity_needed']) {
          $failures[] = 'Estoque insuficiente de ' . $ingredient_info['name'] .
            ' (disponível: ' . $ingredient_info['current_stock'] .
            $ingredient_info['unit'] . ', necessário: ' .
            $ingredient_data['quantity_needed'] . $ingredient_info['unit'] . ')';
        }
      }

      if (!empty($failures)) {
        throw new \Exception(implode('; ', $failures));
      }

      foreach ($this->ingredients as $ingredient_data) {
        $ingredient = new Ingredient();
        $ingredient->id = $ingredient_data['ingredient_id'];

        if (!$this->consume_ingredient($ingredient, $ingredient_data['quantity_needed'])) {
          throw new \Exception('Erro ao consumir ingrediente ID: ' . $ingredient_data['ingredient_id']);
        }
      }

      $this->conn->commit();
      return 'Bebida preparada com sucesso';
    } catch (\Exception $e) {
      $this->conn->rollBack();
      throw $e;
    }
  }
}
