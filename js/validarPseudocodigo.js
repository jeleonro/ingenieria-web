// js/validarPseudocodigo.js
export function validarPseudocodigo(codigo) {
    const lineas = codigo.trim().split(/\n+/);
    const errores = [];

    const patrones = {
        definir: /^Definir\s+\w+\s+Como\s+(Entero|Real|Cadena|Logico)$/i,
        escribir: /^Escribir\s+(".+"|\w+)$/i,
        leer: /^Leer\s+\w+$/i,
        si: /^Si\s+.+\s+Entonces$/i,
        finsi: /^FinSi$/i,
        mientras: /^Mientras\s+.+\s+Hacer$/i,
        finmientras: /^FinMientras$/i,
        repetir: /^Repetir$/i,
        hastaque: /^Hasta Que\s+.+$/i,
        para: /^Para\s+\w+\s+←\s+\d+\s+Hasta\s+\d+$/i,
        finpara: /^FinPara$/i
    };

    for (let i = 0; i < lineas.length; i++) {
        const linea = lineas[i].trim();
        if (!linea) continue;

        const esValida = Object.values(patrones).some((regex) => regex.test(linea));
        if (!esValida) errores.push(`⚠️ Línea ${i + 1}: "${linea}" no es válida.`);
    }

    if (errores.length > 0) {
        return { valido: false, errores };
    }

    return { valido: true, mensaje: "✅ Tu pseudocódigo es válido." };
}
