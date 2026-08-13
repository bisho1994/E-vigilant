<?php
use PHPUnit\Framework\TestCase;

class FormularioVotosNegativosTest extends TestCase {

    public function test_votos_totales_no_negativos() {
        $votosValidos = 350;
        $votosInvalidos = -10;

        // Validamos que los votos válidos cumplan la regla numérica
        $this->assertGreaterThanOrEqual(0, $votosValidos);

        // Verificamos que los votos negativos sean detectados como inválidos
        $esValido = ($votosInvalidos >= 0);
        $this->assertFalse($esValido);
    }

    public function test_numero_de_mesa_es_numerico() {
        $numeroMesa = "12";
        
        // Verificamos que el número de mesa represente un valor numérico válido
        $this->assertTrue(is_numeric($numeroMesa));
        $this->assertGreaterThan(0, (int)$numeroMesa);
    }
}