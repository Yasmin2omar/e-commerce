<?php
namespace App;

use App\Traits\ManageFiles;
use PDO;

class Product{
    
    private int $id;
    private string $name;
    private float $price;
    private string $description;
    private string $stock;
    private int $category_id;
    private string|array $image;
    public function __construct(int $id,string $name,float $price,string $description,string $stock,int $category_id  ,string|array $image){
        
        $this->id=$id;
        $this->name=$name;
        $this->price=$price;
        $this->description=$description;
        $this->stock=$stock;
        $this->category_id=$category_id;
        $this->image=$image;
    }
    public function getID(): int{
        return $this->id;
    }
    public function getName(): string{
        return $this->name;
    }
    public function getPrice(): float{
        return $this->price;
    }
    public function getDescription(): string{
        return $this->description;
    }
    public function getStock(): string{
        return $this->stock;
    }
    public function getCategoryId(): int{
        return $this->category_id;
    }
    public function getImage(): string|array{
        return $this->image;
    }
    public static function getImageByID(PDO $pdo , int $id): array{
        $statment=$pdo->prepare("SELECT image FROM product_color WHERE product_id =?");
        $statment->execute([$id]);
        $rows=$statment->fetchAll(PDO::FETCH_ASSOC);
        $image=[];
        foreach($rows as $row){
            $image[]=$row['image'];
        }
        return $image;
    }
    public static function getAll(PDO $pdo): array{
        $statment=$pdo->query("SELECT * FROM products");
        $rows=$statment->fetchAll(PDO::FETCH_ASSOC);
        $products=[];
        foreach($rows as $row){
             $products[]=new self($row['id'],$row['name'],$row['price'],$row['description'],$row['stock'],$row['category_id'],$row['image']);
        }
        return $products;
    }
    public static function findByID(PDO $pdo , int $id): Product|null{
        $statment=$pdo->prepare("SELECT * FROM products WHERE id =?");
        $statment->execute([$id]);
        $row=$statment->fetch(PDO::FETCH_ASSOC);
        if($row){
            return new self($row['id'],$row['name'],$row['price'],$row['description'],$row['stock'],$row['category_id'],$row['image']);
        }
        return null;
    }
    public static function removeProduct(PDO $pdo,int $id): bool{
        $statment=$pdo->prepare("DELETE FROM products WHERE id=?");
        $success=$statment->execute([$id]);
        if($success){
            return true;
        }return false;
    }
    public static function findNameByID(PDO $pdo , int $id): mixed{
        $statment=$pdo->prepare("SELECT name FROM products WHERE id =?");
        $statment->execute([$id]);
        $row=$statment->fetch(PDO::FETCH_ASSOC);
        if($row['name']){
            return $row['name'];
        }return false;
    }
    use ManageFiles;
    public static function createProduct(PDO $pdo,string $name,float $price,string $description,string $stock,int $category_id, $image=null): Product|null{
        $imagePath=null; 
        if($image && isset($image['tmp_name']) && $image['error'] === 0){
            $imagePath=self::uploadFiles($image,"products");
        }
        $statment=$pdo->prepare("INSERT INTO products(name,price,description,stock,category_id,image)VALUES(?,?,?,?,?,?)");
        $success=$statment->execute( [ $name, $price, $description, $stock, $category_id,$imagePath]);
        if($success){
            $id=(int)$pdo->lastInsertId();
            return new self($id,$name,$price,$description,$stock,$category_id, $image);
        }
        return null;
    } 
   public static function searchProducts(PDO $pdo, string $keyword): array{
     $keyword = trim($keyword);
    $sql = "SELECT * FROM products WHERE name LIKE :keyword OR description LIKE :keyword";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function updateProduct(PDO $pdo,int $id ,string $newName,string $newPrice,string $newStock,string $newDesc,int $newCateID,array|string|null $newImage): bool{
        $imagePath=null; 
        if($newImage && isset($newImage['tmp_name']) && $newImage['error'] === 0){
            $imagePath=self::uploadFiles($newImage,"products");
        }elseif (is_string($newImage)) {
        $imagePath = $newImage;
        } else {
        $imagePath = null;
        }
        $statment=$pdo->prepare("UPDATE products SET  name = ?, price = ?,  stock = ?,description = ?, category_id = ?, image = ? WHERE id = ? ");
        $success=$statment->execute([ $newName,$newPrice,$newStock, $newDesc, $newCateID, $imagePath ,$id]);
        if($success){
            return true;
        }
        return false;
    }

}
