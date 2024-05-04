<?php

class Cart {
    private $cookieName = 'cart_items';

    public function addToCart($productId, $userId, $quantity) {
        $cartItems = $this->getCartItems();
        
        $existingCartItem = $this->getCartItem($productId);
        if ($existingCartItem) {
            $existingCartItem['quantity'] = $quantity;
            $this->updateCartItem($productId, $existingCartItem, $cartItems); 
        } else {
            $cartItems[] = [
                'product_id' => $productId,
                'user_id' => $userId,
                'quantity' => $quantity
            ];
            $this->updateCartCookie($cartItems); 
        }

        header("Location: cart.php");
        exit();
    }

    private function updateCartItem($productId, $updatedItem, &$cartItems) {
        foreach ($cartItems as &$item) {
            if ($item['product_id'] == $productId) {
                $item = $updatedItem;
                break;
            }
        }
        $this->updateCartCookie($cartItems); 
    }

    public function updateCartItemQuantity($productId, $quantity) {
        $cartItems = $this->getCartItems();
        foreach ($cartItems as &$item) {
            if ($item['product_id'] == $productId) {
                $item['quantity'] = $quantity;
                break;
            }
        }
        $this->updateCartCookie($cartItems);
    }

    public function getCartItems() {
        return isset($_COOKIE[$this->cookieName]) ? json_decode($_COOKIE[$this->cookieName], true) : [];
    }

    public function getCartItem($productId) {
        $cartItems = $this->getCartItems();
        foreach ($cartItems as $item) {
            if ($item['product_id'] == $productId) {
                return $item;
            }
        }
        return null;
    }

    public function removeCartItem($productId) {
        $cartItems = $this->getCartItems();
        foreach ($cartItems as $key => $item) {
            if ($item['product_id'] == $productId) {
                unset($cartItems[$key]);
                break;
            }
        }
        $this->updateCartCookie($cartItems);
    }

    private function updateCartCookie($cartItems) {
        setcookie($this->cookieName, json_encode($cartItems), time() + (86400 * 30), "/"); 
    }

    public function clearCart() {
        setcookie($this->cookieName, "", time() - 3600, "/"); 
    }

    public function getQuantity($productId, $cartItems) {
        foreach ($cartItems as $item) {
            if ($item['product_id'] == $productId) {
                return $item['quantity'];
            }
        }
        return 1; 
    }
}

?>
