<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\TransactionService;
use Framework\TemplateEngine;

class HomeController
{



    public function __construct(private TemplateEngine $view, private TransactionService $transactionService) {}

    public function home()
    {
        $page = $_GET['p'] ?? 1;
        $page = (int) $page;
        $length = 3;
        $offset = ($page - 1) * $length;
        $searchTerm = $_GET['s'] ?? "";

        [$transactions, $transactionCount] = $this->transactionService->getUserTransactions($length, $offset);

        $lastPage = ceil($transactionCount / $length);
        $pages = $lastPage ? range(1, $lastPage) : [];


        $pageLinks = array_map(
            fn($pageNumber) => http_build_query(["p" => $pageNumber, "s" => $searchTerm]),
            $pages,
        );


        echo   $this->view->render(
            "index.php",
            [
                "title" => "Home",
                "transactions" => $transactions,
                "currentPage" => $page,
                "previousPageQuery" => http_build_query(["p" => $page - 1, "s" => $searchTerm]),
                "nextPageQuery" => http_build_query(["p" => $page + 1, "s" => $searchTerm]),
                "lastPage" => $lastPage,
                "pageLinks" => $pageLinks,
                "searchTerm" => $searchTerm
            ]
        );
    }
}
