<?php

class ProductController
{
    public function __construct(private ProductGateway $gateway)
    {
    }
    
    public function processRequest(string $method, ?string $id): void
    {
        if ($id) {
            
            $this->processResourceRequest($method, $id); //editing one product
            
        } else {
            
            $this->processCollectionRequest($method);  //show all or add
            
        }
    }
    
    //===============================================================//


    
    private function processResourceRequest(string $method, string $id): void
    {
        $product = $this->gateway->get($id);
        
        if (!$product) {// Not found
            http_response_code(404);
            echo json_encode(["message" => "Product not found"]);
            return;
        }
        
        switch ($method) {
    //========================= get ===========================//
            case "GET": 
                echo json_encode($product);
                break;

    //========================= patch ===========================//
                
            case "PATCH":
                $data = (array) json_decode(file_get_contents("php://input"), true);
                
                $errors = $this->getValidationErrors($data, false);
                
                if ( ! empty($errors)) {
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }
                
                $rows = $this->gateway->update($product, $data);
                
                echo json_encode([
                    "message" => "Product $id updated",
                    "rows" => $rows
                ]);
                break;
    //========================= delete ===========================//
                
            case "DELETE":
                $rows = $this->gateway->delete($id);
                
                echo json_encode([
                    "message" => "Product $id deleted",
                    "rows" => $rows
                ]);
                break;
    //======================== default =============================//

            default:
                http_response_code(405);
                header("Allow: GET, PATCH, DELETE");
        }
    }
    //===============================================================//
    
    private function processCollectionRequest(string $method): void
    {
        switch ($method) {  

              //======================= Get All ===========================//

            case "GET":
                echo json_encode($this->gateway->getAll());
                break;

             //======================= Add Product ===========================//
    
            case "POST":

                //get data
                $data = (array) json_decode(file_get_contents('php://input'),true);

                //validtion
                $errors = $this->getValidationErrors($data);
                

                if ( ! empty($errors)) {
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }
                
                $id = $this->gateway->create($data);
                
                http_response_code(201);
                echo json_encode([
                    "message" => "Product created",
                    "id" => $id
                ]);
                break;


             //======================= default ===========================//
            
            default:
                http_response_code(405);
                header("Allow: GET, POST");
        }
    }
    //======================= Error handling ===========================//
    
    private function getValidationErrors(array $data, bool $is_new = true): array
    {
        $errors = [];
        
        if ($is_new && empty($data["name"])) {
            $errors[] = "name is required";
        }
        
        if (array_key_exists("size", $data)) {
            if (filter_var($data["size"], FILTER_VALIDATE_INT) === false) {
                $errors[] = "size must be an integer";
            }
        }
        
        return $errors;
    }
    //===============================================================//

}