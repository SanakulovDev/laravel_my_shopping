<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_uz', 60)->nullable();
            $table->string('name_oz', 60)->nullable();
            $table->string('name_ru', 60)->nullable();
        });

        // Insert data for all regions
        $regions = [
            [1, 'Qoraqalpog\'iston Respublikasi', 'Қорақалпоғистон Республикаси', 'Республика Каракалпакстан'],
            [2, 'Andijon viloyati', 'Андижон вилояти', 'Андижанская область'],
            [3, 'Buxoro viloyati', 'Бухоро вилояти', 'Бухарская область'],
            [4, 'Jizzax viloyati', 'Жиззах вилояти', 'Джизакская область'],
            [5, 'Qashqadaryo viloyati', 'Қашқадарё вилояти', 'Кашкадарьинская область'],
            [6, 'Navoiy viloyati', 'Навоий вилояти', 'Навоийская область'],
            [7, 'Namangan viloyati', 'Наманган вилояти', 'Наманганская область'],
            [8, 'Samarqand viloyati', 'Самарқанд вилояти', 'Самаркандская область'],
            [9, 'Surxandaryo viloyati', 'Сурхандарё вилояти', 'Сурхандарьинская область'],
            [10, 'Sirdaryo viloyati', 'Сирдарё вилояти', 'Сырдарьинская область'],
            [11, 'Toshkent viloyati', 'Тошкент вилояти', 'Ташкентская область'],
            [12, 'Farg\'ona viloyati', 'Фарғона вилояти', 'Ферганская область'],
            [13, 'Xorazm viloyati', 'Хоразм вилояти', 'Хорезмская область'],
            [14, 'Toshkent shahri', 'Тошкент шаҳри', 'Город Ташкент'],
        ];

        foreach ($regions as $region) {
            DB::table('regions')->insert([
                'id' => $region[0],
                'name_uz' => $region[1], 
                'name_oz' => $region[2],
                'name_ru' => $region[3],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regions');
    }
}
