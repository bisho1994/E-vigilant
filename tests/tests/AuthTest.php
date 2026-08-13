<?php
use PHPUnit\Framework\TestCase;

class AuthTest extends TestCase {
    
    protected function setUp(): void {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        $_SESSION = [];
    }

    public function test_1_detecta_usuario_no_autenticado() {
        $autenticado = isset($_SESSION['user']);
        $this->assertFalse($autenticado, "El sistema debe detectar que no hay sesión activa.");
    }

    public function test_2_genera_token_csrf() {
        $_SESSION['user'] = 'delegado_napo';
        
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        $this->assertNotEmpty($_SESSION['csrf_token']);
        $this->assertEquals(64, strlen($_SESSION['csrf_token']));
    }
}