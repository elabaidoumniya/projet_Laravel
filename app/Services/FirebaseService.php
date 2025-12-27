<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use GuzzleHttp\Client;

class FirebaseService
{
    private $projectId;
    private $apiKey;
    private $client;
    
    public function __construct()
    {
        $this->projectId = env('FIREBASE_PROJECT_ID');
        $this->apiKey = env('FIREBASE_API_KEY');
        $this->client = new Client();
    }
    
    public function verifyIdToken($idToken)
    {
        try {
           
            $response = $this->client->get('https://www.googleapis.com/robot/v1/metadata/x509/securetoken@system.gserviceaccount.com');
            $publicKeys = json_decode($response->getBody(), true);
            
            $decoded = JWT::decode($idToken, new Key($publicKeys, 'RS256'));
            
            if ($decoded->aud !== $this->projectId) {
                throw new \Exception('Audience invalide');
            }
            
            if ($decoded->iss !== "https://securetoken.google.com/{$this->projectId}") {
                throw new \Exception('Émetteur invalide');
            }
            
            return $decoded;
            
        } catch (\Exception $e) {
            throw new \Exception('Token invalide: ' . $e->getMessage());
        }
    }
    
    public function signInWithEmailPassword($email, $password)
    {
        $url = "https://identitytoolkit.googleapis.com/v1/accounts:signInWithPassword?key={$this->apiKey}";
        
        $response = $this->client->post($url, [
            'json' => [
                'email' => $email,
                'password' => $password,
                'returnSecureToken' => true
            ]
        ]);
        
        return json_decode($response->getBody(), true);
    }
    
    public function createUser($email, $password, $displayName = null)
    {
        $url = "https://identitytoolkit.googleapis.com/v1/accounts:signUp?key={$this->apiKey}";
        
        $data = [
            'email' => $email,
            'password' => $password,
            'returnSecureToken' => true
        ];
        
        if ($displayName) {
            $data['displayName'] = $displayName;
        }
        
        $response = $this->client->post($url, [
            'json' => $data
        ]);
        
        return json_decode($response->getBody(), true);
    }
    
    public function sendPasswordResetEmail($email)
    {
        $url = "https://identitytoolkit.googleapis.com/v1/accounts:sendOobCode?key={$this->apiKey}";
        
        $response = $this->client->post($url, [
            'json' => [
                'email' => $email,
                'requestType' => 'PASSWORD_RESET'
            ]
        ]);
        
        return json_decode($response->getBody(), true);
    }
}
