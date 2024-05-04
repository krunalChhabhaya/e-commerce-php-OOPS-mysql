<?php

class Order
{
    private $db;

    public function __construct($mysqli)
    {
        $this->db = $mysqli;
    }

    public function getUserOrders($userId)
    {
        $sql = "SELECT o.order_id, o.order_date, o.total_price, oi.quantity, oi.price AS item_price, p.product_name, p.product_image
                FROM orders o
                INNER JOIN order_item oi ON o.order_id = oi.orders_order_id
                INNER JOIN product p ON oi.product_product_id = p.product_id
                WHERE o.user_user_id = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[$row['order_id']][] = $row;
        }

        $stmt->close();

        return $orders;
    }

    public function clearUserOrders($userId)
    {
        $sqlDeleteItems = "DELETE FROM order_item WHERE orders_order_id IN (SELECT order_id FROM orders WHERE user_user_id = ?)";
        $stmtDeleteItems = $this->db->prepare($sqlDeleteItems);
        $stmtDeleteItems->bind_param("i", $userId);
        $stmtDeleteItems->execute();
        $stmtDeleteItems->close();

        $sqlDeleteOrders = "DELETE FROM orders WHERE user_user_id = ?";
        $stmtDeleteOrders = $this->db->prepare($sqlDeleteOrders);
        $stmtDeleteOrders->bind_param("i", $userId);
        $result = $stmtDeleteOrders->execute();
        $stmtDeleteOrders->close();

        return $result;
    }
}
