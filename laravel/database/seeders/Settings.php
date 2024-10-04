<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Settings extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            'pagina' => "home",
            'titulo' => "Experimenta, Vive y Comparte ",
            'subtitulo' => "Blog Hecho para compartir ",
            'contenido' => "",
        ]);
        DB::table('settings')->insert([
            'pagina' => "about",
            'titulo' => "Somos una escuela de programación ",
            'subtitulo' => "Aprende PHP,HTML,CSS, Laravel,VueJS",
            'contenido' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam fugit ducimus voluptates similique, possimus voluptatibus laudantium soluta explicabo iusto vero rerum corrupti saepe fugiat obcaecati. Ducimus doloremque ipsum dolorum repudiandae. ",
        ]);
        DB::table('settings')->insert([
            'pagina' => "post",
            'titulo' => "Descubre nuestros post",
            'subtitulo' => "Aquí podrás encontrar todos nuestros post ",
            'contenido' => "",
        ]);
        DB::table('settings')->insert([
            'pagina' => "contact",
            'titulo' => "Contactanos",
            'subtitulo' => "¿Quieres saber más acerca de los cursos? ",
            'contenido' => "Escribenos para cualquier duda o sugerencia a través del siguiente formulario",
        ]);
    }
}
