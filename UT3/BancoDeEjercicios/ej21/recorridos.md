# Ejercicio 21. Recorridos de prueba

Al empezar cada petición, `$portadaActual` es la portada A (`0123456789abcdef0123456789abcdef.png`). Si A no está en `storage/portadas`, el script la crea, así que los recorridos se pueden repetir.

| Recorrido | Lo que espero en la respuesta | `$portadaActual` | Directorio `storage/portadas` |
|---|---|---|---|
| 1. Título, páginas y PNG válidos | Confirmación con estado 200 | Nombre nuevo B | Está B; A se ha retirado |
| 2. Páginas inválidas y PNG válido | Formulario con los textos, el error de páginas y el control de archivo vacío (200) | A | Sigue A y no aparece ningún archivo nuevo |
| 3. Campos válidos y `texto.jpg` | Formulario con el error de formato de la portada (200) | A | Sigue A y no aparece ningún archivo nuevo |
| 4. Campos válidos sin archivo | Confirmación con la portada A (200) | A | Sigue A y no aparece ningún archivo nuevo |
