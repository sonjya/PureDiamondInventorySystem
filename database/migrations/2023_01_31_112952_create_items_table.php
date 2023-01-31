<?php

use App\Models\Item;
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
        Schema::create('tbl_items', function (Blueprint $table) {
            $table->id('ItemID');
            $table->string('ItemName');
            $table->decimal('ItemPrice',10,2)->default(0.00);
            $table->string('ItemUOM')->default('Pc');
            $table->foreignId('BrandID')->constrained('tbl_brand','BrandID');
            $table->integer('MinStock')->default(0);
            $table->integer('ReorderQty')->default(0);
            $table->string('IsActive')->default('Yes');
            $table->timestamps();
        });

        $data = array(
            ['ItemName' => 'NESTEA Milk Tea Winter Melon Pack of 2','ItemPrice' => 190.00,'ItemUOM' => 'Pack/2s','BrandID' => 1,'MinStock' => 100,'ReorderQty' => 50],
            ['ItemName' => 'Vita Herb Green Coffee 10 sachets','ItemPrice' => 500.00,'ItemUOM' => 'Box/10s','BrandID' => 2,'MinStock' => 100,'ReorderQty' => 50],
            ['ItemName' => 'NESTEA Peach Lemon Blend Iced Tea 1L Pack of 24','ItemPrice' => 220.80,'ItemUOM' => 'Pack/24s','BrandID' => 1,'MinStock' => 100,'ReorderQty' => 50],
        );
        foreach ($data as $item){
            $newItem = new Item();
            $newItem->ItemName = $item['ItemName'];
            $newItem->ItemPrice = $item['ItemPrice'];
            $newItem->ItemUOM = $item['ItemUOM'];
            $newItem->BrandID = $item['BrandID'];
            $newItem->MinStock = $item['MinStock'];
            $newItem->ReorderQty = $item['ReorderQty'];
            $newItem->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
};
