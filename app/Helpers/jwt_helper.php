<?php

function getJWTFromRequest($autenticationRequest): string
{
    if(is_null($autenticationRequest)){
        throw new Exception('Missing or invalid JWT in request');
    }

    return explode(' ', $autenticationRequest[1]);
}

function getSignedJWTForUser(string $email)
{
    $issuedAdTime = time();
    $tokenTimeToLive = getenv('JWT_TIME_TO_LIVE');
    $tokenExpiration = $issuedAdTime + $tokenTimeToLive;
    $payload = array(
        'email' => $email,
        'iat' => $issuedAdTime,
        'exp' => $tokenExpiration
    );

    $jwt = \Firebase\JWT\JWT::encode($payload, \Config\Services::getSectretKey());
}

function ValidateJWTFromRequest(string $encodedToken)
{
    $key = \Config\Services::getSectretKey();
    $decodedToken = \Firebase\JWT\JWT::decode($encodedToken, $key, ['HS 256']);
    $userModel = new App\Models\UserModel();

}