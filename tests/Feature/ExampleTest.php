<?php

test('the root url redirects to the dashboard', function () {
    $response = $this->get('/');

    $response->assertRedirect('/dashboard');
});
