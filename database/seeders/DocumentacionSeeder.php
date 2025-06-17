<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Documentacion;
use App\Models\Categoria;
use App\Models\Estado; // Importa el modelo Estado

class DocumentacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener la categoría cuyo nombre sea 'Plantilla'
        $categoriaPlantilla = Categoria::where('nombre', 'Plantilla')->first();

        if (!$categoriaPlantilla) {
            throw new \Exception('No existe la categoría "Plantilla" en la tabla categorias.');
        }

        // Obtener el estado cuyo nombre sea 'Vigente'
        $estadoVigente = Estado::where('nombre', 'Vigente')->first();

        if (!$estadoVigente) {
            throw new \Exception('No existe el estado "Vigente" en la tabla estados.');
        }
        Documentacion::factory()->create([
            'categoria_id' => $categoriaPlantilla->id,
            'descripcion' => 'Plantilla LOPD para Socios, en Word',
            'fecha_firma' => now(),
            'archivo' => 'Plantilla_LOPD.docx',
            'nombre_archivo' => 'Plantilla LOPD para Socios',
            'estado_id' => $estadoVigente->id,
            'observaciones' => 'Plantilla de consentimiento del tratamiento de datos personales.',
        ]);
        Documentacion::factory()->create([
            'categoria_id' => $categoriaPlantilla->id,
            'descripcion' => 'Formulario Mandato Simple SEPA, en PDF',
            'fecha_firma' => now(),
            'archivo' => 'formulario-mandato-simple.pdf',
            'nombre_archivo' => 'Formulario Mandato Simple SEPA',
            'estado_id' => $estadoVigente->id,
            'observaciones' => 'Plantilla de mandato SEPA.',
        ]);
        Documentacion::factory()->create([
            'categoria_id' => $categoriaPlantilla->id,
            'descripcion' => 'Balance de situación abreviado anual',
            'fecha_firma' => now(),
            'archivo' => 'balance_de_situacion_abreviado.pdf',
            'nombre_archivo' => 'Balance de Situación Abreviado',
            'estado_id' => $estadoVigente->id,
            'observaciones' => 'Plantilla de situación abreviada.',
        ]);
        Documentacion::factory()->create([
            'categoria_id' => $categoriaPlantilla->id,
            'descripcion' => 'Certificación de la A.G. de Aprobación de Cuentas',
            'fecha_firma' => now(),
            'archivo' => 'certif_de_la_A_G_de_aprob_de_cuentas.pdf',
            'nombre_archivo' => 'Certificación de la A.G. de Aprobación de Cuentas',
            'estado_id' => $estadoVigente->id,
            'observaciones' => 'Plantilla de certificación de la aprobación de cuentas.',
        ]);
        Documentacion::factory()->create([
            'categoria_id' => $categoriaPlantilla->id,
            'descripcion' => 'Cuenta de resultados abreviada anual',
            'fecha_firma' => now(),
            'archivo' => 'cuenta_de_resultados_abreviada.pdf',
            'nombre_archivo' => 'Cuenta de Resultados Abreviada',
            'estado_id' => $estadoVigente->id,
            'observaciones' => 'Plantilla de cuenta de resultados abreviada.',
        ]);
        Documentacion::factory()->create([
            'categoria_id' => $categoriaPlantilla->id,
            'descripcion' => 'Memoria económica abreviada anual',
            'fecha_firma' => now(),
            'archivo' => 'memoria_economica_abreviada.pdf',
            'nombre_archivo' => 'Memoria Económica Abreviada',
            'estado_id' => $estadoVigente->id,
            'observaciones' => 'Plantilla de memoria económica abreviada.',
        ]);
        Documentacion::factory()->create([
            'categoria_id' => $categoriaPlantilla->id,
            'descripcion' => 'Modelo orientativo de memoria de actividades',
            'fecha_firma' => now(),
            'archivo' => 'modelo_orientativo_de_memoria_de_actividades.pdf',
            'nombre_archivo' => 'Modelo Orientativo de Memoria de Actividades',
            'estado_id' => $estadoVigente->id,
            'observaciones' => 'Plantilla de modelo orientativo de memoria de actividades.',
        ]);
        Documentacion::factory()->create([
            'categoria_id' => $categoriaPlantilla->id,
            'descripcion' => 'Modificación de Estatutos, en Word',
            'fecha_firma' => now(),
            'archivo' => 'Modificacion_Estatutos.doc',
            'nombre_archivo' => 'Modificación de Estatutos',
            'estado_id' => $estadoVigente->id,
            'observaciones' => 'Plantilla de modificación de estatutos.',
        ]);
        Documentacion::factory()->create([
            'categoria_id' => $categoriaPlantilla->id,
            'descripcion' => 'Modificación de la Junta Directiva, en Word',
            'fecha_firma' => now(),
            'archivo' => 'Modificacion_Junta.doc',
            'nombre_archivo' => 'Modificación de la Junta Directiva',
            'estado_id' => $estadoVigente->id,
            'observaciones' => 'Plantilla de modificación de la junta directiva.',
        ]);
        Documentacion::factory()->create([
            'categoria_id' => $categoriaPlantilla->id,
            'descripcion' => 'Plantilla de Escrito con Escudo, en Word',
            'fecha_firma' => now(),
            'archivo' => 'Plantilla_con_escudo.docx',
            'nombre_archivo' => 'Plantilla de Escrito con Escudo',
            'estado_id' => $estadoVigente->id,
            'observaciones' => 'Plantilla de escrito con escudo.',
        ]);
        Documentacion::factory()->create([
            'categoria_id' => $categoriaPlantilla->id,
            'descripcion' => 'Plantilla de recibo no domiciliado, en Excel',
            'fecha_firma' => now(),
            'archivo' => 'Recibo_no_domiciliado.xlsx',
            'nombre_archivo' => 'Plantilla de Recibo No Domiciliado',
            'estado_id' => $estadoVigente->id,
            'observaciones' => 'Plantilla de recibo no domiciliado.',
        ]);
    }
}
