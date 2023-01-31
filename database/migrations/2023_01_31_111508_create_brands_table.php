<?php

use App\Models\Brand;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_brand', function (Blueprint $table) {
            $table->id('BrandID');
            $table->string('BrandName');
            $table->string('IsActive')->default('Yes');
            $table->timestamps();
        });

        $data = ['Nestea','Vita Herbs','Bear Brand'];
        foreach ($data as $item){
            $brand = new Brand();
            $brand->BrandName = $item;
            $brand->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_brand');
    }
};
