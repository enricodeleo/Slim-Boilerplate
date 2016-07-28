<?php
// Routes

/**
 * Root path
 * this is a the base route that will optionally accepts an argument (arguments are available in $args)
 * try to to visit http://localhost:8000/Joseph to see args in action
 */
$app->get('/[{name}]', function ($request, $response, $args) {

    // We can execute functions or set variables that will be exposed to the view
    // for example, we will be able to use {{ title }} or {{ current_date }},
    // see the `return` statement below.
    $variables = [
      'title' => 'Main Route',
      'name' => array_key_exists('name', $args) ? $args['name'] : 'buddy'
    ];

    // CSRF tokens to secure form submissions
    $variables['csfr'] = [
      'name' => $request->getAttribute('csrf_name'),
      'value' => $request->getAttribute('csrf_value')
    ];

    // Parsing query strings and put in response variables if a key exists
    $qs = $request->getQueryParams();
    if ( array_key_exists('feedback', $qs) ) {
      $variables['feedback'] = $qs['feedback'];
    }

    // Sample log message
    $ip = $request->getAttribute('ip_address');
    $this->logger->info($ip);

    // Render index view
    return $this->view->render( $response, 'index.html', $variables );

});

/**
 * Subscribe path
 * you can submit post requests to this route to have emails sent
 * CSRF protection will prevent to reach this route if no valid token is provided
 */
$app->post('/subscribe', function ($request, $response, $args) {

  $ip = $request->getAttribute('ip_address'); // get sender ip address
  $body = $request->getParsedBody(); // body
  $email = $body['email']; // body
  $feedback = '';

  $insert = $this->db->insert('subscriptions', [
    'email' => $email,
    'ip' => $ip,
    'joinedOn' => date(DATE_ISO8601)
  ]);

  // immediate redirect with fail message if the data cannot be stored (ex.: the email is already subscribed)
  if (!$insert) {
    $feedback = 'warning';
    return $response->withRedirect( '/?feedback=' . $feedback );
  }

  // Everything is okay, prepare email message
  $this->mail->addAddress($email);
  $this->mail->Subject = 'You\'ve been subscribed';
  $this->mail->Body    = 'This is the HTML message <b>that confirms everything is ok!</b>';

  // Send the confirmation email
  if(!$this->mail->send()) {
      $this->logger->info('Message could not be sent.');
      $this->logger->info($this->mail->ErrorInfo);
      $feedback = 'warning';
  } else {
      $this->logger->info('Message has been sent');
      $feedback = 'success';
  }

  return $response->withRedirect( '/?feedback=' . $feedback );

});
