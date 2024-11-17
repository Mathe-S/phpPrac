<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;

class TransactionService
{

    public function __construct(private Database $db) {}

    public function create(array $data)
    {
        $formattedDate = "{$data["date"]} 00:00:00";

        $this->db->query("INSERT INTO transactions (description, amount, date, user_id) VALUES (:description, :amount, :date, :user_id)", [
            "description" => $data["description"],
            "amount" => $data["amount"],
            "date" => $formattedDate,
            "user_id" => $_SESSION["user"],
        ]);
    }

    public function getUserTransactions(int $length, int $offset)
    {
        $searchTerm =  addcslashes($_GET['s'] ?? "", "%_");
        $params = ["user_id" => $_SESSION["user"], "searchTerm" => "%{$searchTerm}%"];


        $transactions = $this->db->query(
            "SELECT *, DATE_FORMAT(date, '%Y-%m-%d') AS formatted_date 
            FROM transactions 
            WHERE user_id = :user_id 
            AND description LIKE :searchTerm
            LIMIT {$length} OFFSET {$offset}",
            $params
        )->findAll();

        $transactions = array_map(function ($transaction) {
            $transaction["receipts"] = $this->db->query(
                "SELECT * FROM receipts WHERE transaction_id = :transaction_id",
                ["transaction_id" => $transaction["id"]]
            )->findAll();
            return $transaction;
        }, $transactions);

        $transactionCount = $this->db->query(
            "SELECT COUNT(*) 
            FROM transactions 
            WHERE user_id = :user_id 
            AND description LIKE :searchTerm",
            $params
        )->count();

        return [$transactions, $transactionCount];
    }

    public function getUserTransaction(int $transactionId)
    {
        return $this->db->query(
            "SELECT *, DATE_FORMAT(date, '%Y-%m-%d') AS formatted_date 
            FROM transactions WHERE id = :id AND user_id = :user_id",
            ["id" => $transactionId, "user_id" => $_SESSION["user"]]
        )->fetch();
    }

    public function update(array $data, array $params)
    {
        $formattedDate = "{$data["date"]} 00:00:00";

        $this->db->query("UPDATE transactions SET description = :description, amount = :amount, date = :date WHERE id = :id AND user_id = :user_id", [
            "description" => $data["description"],
            "amount" => $data["amount"],
            "date" => $formattedDate,
            "id" => (int) $params["transaction"],
            "user_id" => $_SESSION["user"],
        ]);
    }

    public function delete(int $transactionId)
    {
        $this->db->query("DELETE FROM transactions WHERE id = :id AND user_id = :user_id", ["id" => $transactionId, "user_id" => $_SESSION["user"]]);

        redirectTo("/");
    }
}
