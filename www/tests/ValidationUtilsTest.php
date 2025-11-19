<?php

declare(strict_types=1);

namespace www\tests;

use PHPUnit\Framework\TestCase;

class ValidationUtilsTest extends TestCase
{
    public function testEmailValidationWithValidEmails(): void
    {
        $validEmails = [
            'test@example.com',
            'user.name+tag@example.co.uk',
            'test.email@subdomain.example.org',
            '123@example.com'
        ];

        foreach ($validEmails as $email) {
            $this->assertTrue($this->isValidEmail($email), "Email '{$email}' should be valid");
        }
    }

    public function testEmailValidationWithInvalidEmails(): void
    {
        $invalidEmails = [
            'invalid-email',
            '@example.com',
            'test@',
            'test.example.com',
            'test@.com',
            'test..test@example.com',
            ''
        ];

        foreach ($invalidEmails as $email) {
            $this->assertFalse($this->isValidEmail($email), "Email '{$email}' should be invalid");
        }
    }

    public function testPhoneValidationWithValidPhones(): void
    {
        $validPhones = [
            '612345678',
            '912345678',
            '712345678',
            '622345678'
        ];

        foreach ($validPhones as $phone) {
            $this->assertTrue($this->isValidSpanishPhone($phone), "Phone '{$phone}' should be valid");
        }
    }

    public function testPhoneValidationWithInvalidPhones(): void
    {
        $invalidPhones = [
            '512345678', // No empieza por 6, 7, 8, 9
            '61234567',  // Muy corto
            '6123456789', // Muy largo
            '61234567a', // Contiene letras
            '',
            '612345678 '
        ];

        foreach ($invalidPhones as $phone) {
            $this->assertFalse($this->isValidSpanishPhone($phone), "Phone '{$phone}' should be invalid");
        }
    }

    public function testPasswordStrengthValidation(): void
    {
        // Contraseñas válidas (mínimo 8 caracteres)
        $validPasswords = [
            'password123',
            '12345678',
            'abcdefgh',
            'PassWord123!'
        ];

        foreach ($validPasswords as $password) {
            $this->assertTrue($this->isValidPassword($password), "Password should be valid");
        }

        // Contraseñas inválidas
        $invalidPasswords = [
            'pass',     // Muy corta
            '1234567',  // Muy corta
            '',         // Vacía
            '       '   // Solo espacios
        ];

        foreach ($invalidPasswords as $password) {
            $this->assertFalse($this->isValidPassword($password), "Password should be invalid");
        }
    }

    public function testSanitizeInput(): void
    {
        $input = '<script>alert("XSS")</script>Hello & World "test" \'quote\'';
        $expected = '&lt;script&gt;alert(&quot;XSS&quot;)&lt;/script&gt;Hello &amp; World &quot;test&quot; &#039;quote&#039;';

        $sanitized = $this->sanitizeInput($input);
        $this->assertEquals($expected, $sanitized);
    }

    public function testFormatPrice(): void
    {
        $this->assertEquals('29,99 €', $this->formatPrice(29.99));
        $this->assertEquals('1.250,50 €', $this->formatPrice(1250.50));
        $this->assertEquals('0,00 €', $this->formatPrice(0));
        $this->assertEquals('100,00 €', $this->formatPrice(100));
    }

    public function testCalculatePagination(): void
    {
        // Test cálculo de páginas totales
        $this->assertEquals(1, $this->calculateTotalPages(5, 10));   // 5 items, 10 por página
        $this->assertEquals(2, $this->calculateTotalPages(15, 10));  // 15 items, 10 por página
        $this->assertEquals(3, $this->calculateTotalPages(25, 10));  // 25 items, 10 por página
        $this->assertEquals(0, $this->calculateTotalPages(0, 10));   // 0 items debería dar 0 páginas
    }

    public function testValidateProductData(): void
    {
        // Datos válidos
        $validData = [
            'nombre' => 'Proteína Whey',
            'descripcion' => 'Suplemento proteico de alta calidad',
            'precio' => 29.99,
            'stock' => 100,
            'categoria' => 1
        ];

        $this->assertTrue($this->validateProductData($validData));

        // Datos inválidos
        $invalidDataSets = [
            ['nombre' => '', 'descripcion' => 'Test', 'precio' => 10, 'stock' => 1, 'categoria' => 1], // Nombre vacío
            ['nombre' => 'Test', 'descripcion' => 'Test', 'precio' => -5, 'stock' => 1, 'categoria' => 1], // Precio negativo
            ['nombre' => 'Test', 'descripcion' => 'Test', 'precio' => 10, 'stock' => -1, 'categoria' => 1], // Stock negativo
            ['nombre' => 'Test', 'descripcion' => 'Test', 'precio' => 10, 'stock' => 1, 'categoria' => 99], // Categoría inválida
        ];

        foreach ($invalidDataSets as $invalidData) {
            $this->assertFalse($this->validateProductData($invalidData), 'Invalid product data should fail validation');
        }
    }

    public function testGenerateSlug(): void
    {
        $this->assertEquals('protena-whey', $this->generateSlug('Proteína Whey'));
        $this->assertEquals('suplemento-proteico-calidad', $this->generateSlug('Suplemento Proteico - Calidad'));
        $this->assertEquals('producto-especial-123', $this->generateSlug('Producto Especial 123!'));
        $this->assertEquals('test', $this->generateSlug('  TEST  '));
    }

    // Funciones helper para testing (simulando funciones de utilidad)

    private function isValidEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    private function isValidSpanishPhone(string $phone): bool
    {
        return preg_match('/^[6789]\d{8}$/', $phone) === 1;
    }

    private function isValidPassword(string $password): bool
    {
        return strlen(trim($password)) >= 8;
    }

    private function sanitizeInput(string $input): string
    {
        return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    }

    private function formatPrice(float $price): string
    {
        return number_format($price, 2, ',', '.') . ' €';
    }

    private function calculateTotalPages(int $totalItems, int $itemsPerPage): int
    {
        return (int)ceil($totalItems / $itemsPerPage);
    }

    private function validateProductData(array $data): bool
    {
        if (empty(trim($data['nombre'] ?? ''))) return false;
        if (!is_numeric($data['precio'] ?? null) || ($data['precio'] ?? 0) < 0) return false;
        if (!is_numeric($data['stock'] ?? null) || ($data['stock'] ?? 0) < 0) return false;
        if (!in_array($data['categoria'] ?? null, [1, 2, 3, 4, 5])) return false;
        return true;
    }

    private function generateSlug(string $text): string
    {
        // Convertir a minúsculas y eliminar caracteres especiales
        $slug = strtolower(trim($text));
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/[\s-]+/', '-', $slug);
        return trim($slug, '-');
    }
}
