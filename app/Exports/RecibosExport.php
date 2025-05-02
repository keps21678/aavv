<?php

namespace App\Exports;

use App\Models\Socio;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

/* Campos necesarios para las remesas de recibos en Caja Rural
    IBAN --> ESXXYYYYYYYYYYYYYYYYYYYYYYYY, lo sacamos de la tabla socios
    Nombre del deudor: Apellidos, Nombre --> Socio->nombre, Socio->apellidos, lo sacamos de la tabla socios
    Referencia mandato: NSocio --> Socio->id, lo sacamos de la tabla socios
    Fecha de firma del mandato: 31/10/2009  'Para que no pida justificantes'
    Referencia del adeudo: NSocio --> Socio->id, lo sacamos de la tabla socios
    Tipo de adeudo: RCUR 'Explicado en la WEB de Caja Rural'
    Concepto del adeudo: Cuota "AÑO" --> Cuota->anyo, lo sacamos de la tabla cuotas
    Importe: Cuota que corresponda --> Cuota->cantidad, lo sacamos de la tabla cuotas
*/
class RecibosExport implements FromCollection, WithHeadings
{
    /**
     * Devuelve la colección de datos para el Excel.
     */
    public function collection()
    {
        // Filtrar solo los socios con domiciliación activa
        return Socio::with('cuota')
            ->where('domiciliacion', true) // Filtrar por domiciliación
            ->get()
            ->map(function ($socio) {
                return [
                    'IBAN' => $socio->iban,
                    'Nombre del deudor' => $socio->apellidos . ', ' . $socio->nombre,
                    'Referencia mandato' => $socio->id,
                    'Fecha de firma del mandato' => '31/10/2009',
                    'Referencia del adeudo' => $socio->id,
                    'Tipo de adeudo' => 'RCUR',
                    'Concepto del adeudo' => 'Cuota ' . ($socio->cuota->anyo ?? 'N/A'),
                    'Importe' => $socio->cuota->cantidad ?? 'N/A',
                ];
            });
    }

    /**
     * Devuelve los encabezados para el Excel.
     */
    public function headings(): array
    {
        return [
            'IBAN',
            'Nombre del deudor',
            'Referencia mandato',
            'Fecha de firma del mandato',
            'Referencia del adeudo',
            'Tipo de adeudo',
            'Concepto del adeudo',
            'Importe',
        ];
    }
}
