<?php
namespace Ecommerce\Controller\Product;

use Ecommerce\Model\Product\Product;
use Ecommerce\Core\Traits\Validation; 

class ProductContr extends Product {

	use Validation;

	Public function ReturnAllProducts(){

		return $this->GetAllProducts();

	}

	Public function ReturnProductsByCategory($cat){

		return $this->GetProductsByCategory($cat);

	}

	Public function ReturnProductsSearch($search){

		return $this->GetProductsByName($search);

	}


	Public function GetProductDetails($id){

		if (!is_numeric($id)){

			$pid = 1;
			return $this->GetProductsByID($pid);
			exit();
		}

		if($this->CheckProductDB($id) == False){

			$pid = 1;
			return $this->GetProductsByID($pid);
			exit();
		}

		return $this->GetProductsByID($id);

	}

	Public function CheckInStock($pid){

		$ProductQuantity = $this->GetProductAvailibity($pid);

		if($ProductQuantity > 0 ){

			return 'In Stock';
		} 

		else {

			return 'Out Of Stock';
		}

	}



}

?>