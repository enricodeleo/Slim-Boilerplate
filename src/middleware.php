<?php
// Application middlewares
// these services will be available on every http request

// a middleware for CSFR
// in routes, retrieve $request->getAttribute('csrf_name') and $request->getAttribute('csrf_value')
// and put them in a form with two hidden inputs like
// <input type="hidden" name="csrf_name" value="{{ csfr.name }}">
// <input type="hidden" name="csrf_value" value="{{ csfr.value }}">
$app->add($container->get('csrf'));

// retrieving client ip address
// retrieve this in routes with $request->getAttribute('ip_address')
$app->add($container->get('ip'));
