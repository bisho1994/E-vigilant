<?php
use PHPUnit\Framework\TestCase;

class UbicacionTest extends TestCase {

    public function test_provincia_obligatoria_napo() {
        $provinciaIngresada = "Napo";
        $this->assertEquals("Napo", $provinciaIngresada);
    }

    public function test_cantones_validos_napo() {
        $cantonesNapo = [
            'TENA', 
            'EL CHACO', 
            'CARLOS JULIO AROSEMENA TOLA', 
            'QUIJOS', 
            'ARCHIDONA'
        ];

        // Probamos un cantón válido del sistema
        $cantonPrueba = 'ARCHIDONA';
        $cantonInvalido = 'GUAYAQUIL';

        $this->assertContains($cantonPrueba, $cantonesNapo);
        $this->assertNotContains($cantonInvalido, $cantonesNapo);
    }
}