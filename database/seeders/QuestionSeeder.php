<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $questions = [
            '¿Cuál es el objetivo principal del procedimiento de elección de representantes de los gremios de las MYPE?',
            '¿Qué sectores productivos están comprendidos en el procedimiento de elección?',
            '¿Quién convoca públicamente a la elección de los representantes de los gremios de las MYPE?',
            '¿Qué funciones tiene el Comité Electoral en el proceso de elección?',
            '¿Cuáles son los requisitos para que una Asociación de MYPE o Comité de MYPE pueda inscribirse como elector?',
            '¿Cuáles son los requisitos para que un candidato pueda postularse como representante del gremio de MYPE?',
            '¿Cómo se realiza la presentación y resolución de tachas contra candidatos durante el proceso electoral?',
            '¿Cuáles son las modalidades de votación permitidas en el proceso electoral y cómo se garantiza la confidencialidad del voto?',
            '¿Qué sucede en caso de empate entre gremios de las MYPE en la elección de representantes?',
            '¿Cuáles son las causales para declarar nulo o desierto el proceso de elección?',
            'En el caso de que nuestra asociación no esté inscrita en el RENAMYPE, quisiéramos saber si aún podemos participar y qué condiciones adicionales debemos cumplir.',
            'Agradeceríamos nos aclaren cuál es el número mínimo de socios que debe tener nuestro gremio para poder inscribirse en este proceso electoral.',
            'También deseamos conocer qué documentos específicos debemos presentar para que nuestra inscripción sea aceptada y en qué formato se deben entregar.',
            'Qué sucederá en caso no haya suficientes candidatos inscritos o si durante la votación se produce un empate entre los gremios.',
            'Finalmente, pedimos que nos informen por cuánto tiempo durarán en el cargo los representantes elegidos y cuáles serán sus principales responsabilidades dentro de los Núcleos Ejecutores de Compras.'
        ];

        foreach ($questions as $index => $content) {
            Question::create([
                'number' => $index + 1,
                'content' => $content,
                'is_sent' => false
            ]);
        }
    }
}
