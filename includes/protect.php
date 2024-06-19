<?php
if(!isset($_SESSION)) {
    session_start();
}

if(!isset($_SESSION['id'])) {
    die("<!DOCTYPE html>
        <html lang=\"en\">
        <head>
            <meta charset=\"UTF-8\">
            <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
            <title>Unauthorized Access</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f9f9f9;
                    margin: 0;
                    padding: 0;
                }
                
                .container {
                    max-width: 800px;
                    margin: 50px auto;
                    padding: 20px;
                    background-color: #fff;
                    border-radius: 8px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }
                
                .alert {
                    padding: 15px;
                    border-radius: 4px;
                    margin-bottom: 20px;
                }
                
                .alert-danger {
                    background-color: #f8d7da;
                    color: #721c24;
                    border: 1px solid #f5c6cb;
                }
                
                .alert a {
                    color: #721c24;
                    text-decoration: underline;
                }
                
                .alert a:hover {
                    color: #721c24;
                }
                
                .link {
                    text-decoration: none;
                    color: #007bff;
                }
                
                .link:hover {
                    text-decoration: underline;
                }
                p{
                    margin-left: auto;
                    margin-right: auto;
                    width: fit-content;
                }
                h2{
                    margin-left: auto;
                    margin-right: auto;
                    width: fit-content;
                }
                
            </style>
        </head>
        <body>
            <div class=\"container\">
                <div class=\"alert alert-danger\">
                    <h2>Você não pode acessar esta página porque não está logado</h2>.<p><a class=\"link\" href=\"./index.php\">Entrar</a></p>
                </div>
            </div>
        </body>
        </html>");
}
?>