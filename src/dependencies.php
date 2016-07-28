<?php
// This file contains all the services that will be available within routes via $this->[nameoftheservice]
// example $this->logger->info('variable or string to log.');

$container = $app->getContainer();

// Views powered by Twig
$container['view'] = function ($c) {
    $settings = $c->get('settings')['view'];
    $view = new \Slim\Views\Twig($settings['template_path'], [
        'cache' => false
    ]);
    $view->addExtension(new \Slim\Views\TwigExtension(
        $c['router'],
        $c['request']->getUri()
    ));
    return $view;
};

// CSFR protection on each route
$container['csrf'] = function ($c) {
    return new \Slim\Csrf\Guard;
};

// User's IP
// Included in middlewares, allow each route to get the user's ip address
$container['ip'] = function ($c) {
    $checkProxyHeaders = true;
    $trustedProxies = [];
    return new RKA\Middleware\IpAddress($checkProxyHeaders, $trustedProxies);
};

// email service
$container['mail'] = function ($c) {
    $settings = $c->get('settings')['mail'];
    $mail = new PHPMailer;
    $mail->isSMTP(); // Set mailer to use SMTP
    $mail->SMTPAuth = true;
    $mail->Host = $settings['host'];
    $mail->Username = $settings['username'];
    $mail->Password = $settings['password'];
    $mail->SMTPSecure = $settings['secure'];
    $mail->Port = $settings['port'];
    $mail->setFrom('noreply@yourdomain.com', 'Company'); // default sender address and name
    $mail->isHTML(true); // enable html emails
    return $mail;
};

// Service factory for the ORM
$container['db'] = function ($c) {
    $settings = $c->get('settings')['db'];
    // Using PDO to create a DB if it doesn't exists.
    // In production you could comment out this section once you have your database already configured
    $db = new PDO('sqlite:' . $settings['database_file']);
    $database = new medoo($settings);
    // Read settings and create tables and schemas accordingly.
    // In production you could comment out this section once you have your database already configured
    foreach ( $settings['tables'] as $key => $value ) {
        $database->query('CREATE TABLE IF NOT EXISTS `' . $key . '` (' . $value . ')' );
    }
    return $database;
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], Monolog\Logger::DEBUG));
    return $logger;
};